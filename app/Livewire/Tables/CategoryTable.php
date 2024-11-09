<?php

namespace App\Livewire\Tables;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;

class CategoryTable extends Component
{
    use WithPagination;


    public string $search = ''; // Store search keyword

    public int $perPage = 10; // Display records per page

    public string $sortHeader = 'updated_at'; // Store the current sorted by column
    public string $sortDirection = 'asc'; // Store the current sort direction

    public array $selectedRecords = []; // Store record IDs to be bulk deleted
    // public bool $selectAll = false; // Boolean value for bulk all deletion
    // public bool $selectCurrentPage = false; // Boolean value for bulk current page deletion

    public bool $archive = false; // Determines whether to switch to archive records

    protected $queryString = [ // Add a query string to the URL to indicate which column and direction is currently sorted by
                                'sortHeader'  => ['keep' => true], // Include the query string even on first page load
                                'sortDirection' => ['keep' => true] // Include the query string even on first page load
                            ];

    public function paginationView() // Use custom pagination view
    {
        return 'vendor.livewire.custom2';
    }

    #[Computed()]
    public function getPosts() // Retrieve the table records
    {
        return Post::join('categories', 'posts.category_id', '=', 'categories.id')
                ->when($this->archive, fn($query) => $query->onlyTrashed()) // Switch to archived posts
                ->when($this->search, fn ($query) => $query->where('title', 'like', '%' . $this->search . '%')) // Search query
                ->when($this->sortHeader === 'category', function ($query) {
                    return $query->orderBy('categories.name', $this->sortDirection); // Order by category name
                }, function ($query) {
                    return $query->orderBy($this->sortHeader, $this->sortDirection);
                })
                ->select('posts.*', 'categories.name as category_name')
                ->paginate($this->perPage);
    }

    public function getArchive() // Switch to archived posts
    {
        $this->archive = true;
    }

    public function deleteSelected(array $selectedRecords) // Bulk delete selected records
    {
        // dd($selectedRecords);
        Post::whereIn('id', $selectedRecords)->delete();

        // $this->selectedRecords = []; // Reset selected records
        // $this->selectAll = false; // Reset if all records were selected
    }

    // Select all records
    public function getAllRecords() { return Post::pluck('id')->toArray(); }

    // Select records in current page
    public function getCurrentPageRecords() { return $this->getPosts()->pluck('id')->toArray(); }

    // public function updatedSelectAll($value) // Select all records
    // {
    //     if ($value) {
    //         $this->selectedRecords = Post::pluck('id')->toArray();
    //     } else {
    //         $this->selectedRecords = [];
    //     }
    // }

    // public function updatedSelectCurrentPage($value) // Select records in current page
    // {
    //     if ($value) {
    //         $this->selectedRecords = $this->getPosts()->pluck('id')->toArray();
    //     } else {
    //         $this->selectedRecords = [];
    //     }
    // }

    public function sortBy(string $columnName) // Sort column based on name
    {
        // if($this->sortHeader === $columnName)
        // {
        //     $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc'; // Sort direction based on the clicked column name
        // } else {
        //     $this->sortDirection = 'asc'; // Default sort direction
        // }
        $this->sortHeader === $columnName ?
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc' // Sort direction based on the clicked column name
            : $this->sortDirection = 'asc'; // Default sort direction

        $this->sortHeader = $columnName;
    }

    public function render()
    {
        return view('livewire.tables.category-table')->with([
            'headers' => ['Title', 'Category', 'Author', 'Status'],
        ]);
    }
}
