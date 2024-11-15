<?php

namespace App\Livewire\Admin;

use App\Models\Post;
use Livewire\Component;
use App\Models\Category;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;
use Illuminate\Database\Eloquent\Collection;

class AllPostsIndex extends Component
{
    use WithPagination;

    /**
     * Table Tools
     */
    #[Url(as: 's', history: true)]
    public string $search = ''; // Store search keyword

    public int $perPage = 10; // Display records per page

    public string $sortHeader = 'updated_at'; // Store the current sorted by column
    public string $sortDirection = 'desc'; // Store the current sort direction
    protected $queryString = [ // Add a query string to the URL to indicate which column and direction is currently sorted by
        'sortHeader'  => ['keep' => true], // Include the query string even on first page load
        'sortDirection' => ['keep' => true] // Include the query string even on first page load
    ];

    public array $checked = []; // Store record IDs to be bulk deleted
    public bool $selectCurrentPage = false; // Determine whether the records in the current page are all selected
    public bool $selectAll = false; // Determine whether the all records are selected
    public Collection $categories; // Store the categories from the database
    public ?int $selectedCategory = null; // Store the selected category


    /**
     * Table Info
     */
    public string $title = 'Admin';
    public string $subTitle = 'Admin Posts';
    public array $columns = [
                                'Bulk',
                                'Number',
                                'Title',
                                'Slug',
                                'Category',
                                'Date Created',
                                'Action'
                            ];

    /**
     * Action Column
     */
    public Post $selectedPost;

    /**
     * Data passed into components is received through the mount() lifecycle hook as method parameters
     */
    public function mount()
    {
        $this->categories = Category::get();
    }

    /**
     * Retrieve the models for this table
     */
    #[Computed()]
    public function loadData() // Retrieve the table records
    {
        return Post::join('categories', 'posts.category_id', '=', 'categories.id')
                ->select('posts.*', 'posts.created_at as Date Created', 'categories.name as category_name', 'categories.color as category_color')
                ->when($this->search, fn ($query) => $query->where('title', 'like', '%' . $this->search . '%')) // Search query
                ->when($this->sortHeader === 'category', function ($query) {
                    return $query->orderBy('categories.name', $this->sortDirection); // Order by category name
                }, function ($query) {
                    return $query->orderBy($this->sortHeader, $this->sortDirection);
                })
                ->paginate($this->perPage);
    }

    /**
     * Reset to the first page when there is a search input,
     * otherwise, the page is stuck on wherever the page was before and the table data will not display correctly
     */
    public function updatedSearch()
    {
        $this->resetPage();
    }

    /**
     * Sort column
     */
    public function sortBy(string $columnName)
    {
        $this->sortHeader === $columnName ?
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc' // Sort direction based on the clicked column name
            : $this->sortDirection = 'asc'; // Default sort direction

        $this->sortHeader = $columnName;
    }

    /**
     * Bulk delete selected records
     */
    public function deleteSelected()
    {
        Post::whereIn('id', $this->checked)->delete(); // Delete the selected posts

        /**
         * Reset all variables
         */
        $this->selectCurrentPage = false;
        $this->selectAll = false;
        $this->checked = [];

        request()->session()->flash('success', 'Posts successfully deleted!');

        $this->dispatch('hide-bulk'); // Hide the bulk dropdown
    }

    /**
     * Bulk edit selected records
     */
    public function editSelected()
    {
        // Check if there is no selected category
        if($this->selectedCategory == null)
        {
            request()->session()->flash('fail', 'Updated failed! No category was chosen for the bulk edit.');

            /**
             * Reset all variables
             */
            $this->selectCurrentPage = false;
            $this->selectAll = false;
            $this->checked = [];

            $this->dispatch('hide-bulk'); // Hide the bulk dropdown

            return;
        }

        Post::whereIn('id', $this->checked)->update(['category_id' => $this->selectedCategory]); // Update the selected posts with the new category

        request()->session()->flash('success', 'Posts\' category successfully updated!');

        /**
         * Reset all variables
         */
        $this->selectedCategory = null;
        $this->selectCurrentPage = false;
        $this->selectAll = false;
        $this->checked = [];

        $this->resetPage(); // Go back to the first page of the table

        $this->dispatch('hide-bulk'); // Hide the bulk dropdown
    }

    /**
     * Select all records
     */
    public function getAllRecords() { return Post::pluck('id')->toArray(); }

    /**
     * Select records in current page
     */
    public function getCurrentPageRecords() { return $this->loadData()->pluck('id')->toArray(); }

    /**
     * Livewire Pagination Hook
     */
    public function updatedPage()
    {
        // On the next page, reset bulk selection
        $this->checked = [];
        $this->selectCurrentPage = false;
        $this->selectAll = false;
    }

    /**
     * Send slug to modal
     */
    public function sendSlugToModal(Post $post)
    {
        $this->selectedPost = $post;
    }

    /**
     * Delete single post
     */
    public function deleteSinglePost()
    {
        $this->selectedPost->delete();

        request()->session()->flash('success', 'Post successfully deleted!');
    }

    public function render()
    {
        return view('livewire.admin.all-posts-index', [
                        'columns' => $this->columns,
                        'records' => $this->loadData(),
                    ])
                    ->layout('components.layouts.app', [
                        'title' => 'Admin',
                        'page' => 'allPosts',
                    ]);
    }
}
