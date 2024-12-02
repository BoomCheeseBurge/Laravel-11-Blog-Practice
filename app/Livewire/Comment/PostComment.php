<?php

namespace App\Livewire\Comment;

use App\Models\Post;
use Livewire\Component;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Computed;
use Illuminate\Pagination\LengthAwarePaginator;

class PostComment extends Component
{
    use WithPagination;

    #[Locked]
    public Post $post;

    protected $listeners = [
        'reload-comments' => '$refresh'
    ];

    /**
     * Compute the post comments
     */
    #[Computed()]
    public function getComments(): LengthAwarePaginator
    {
        return $this?->post?->comments()->with(['post','comments','user'])->withTrashed()->whereNull('parent_id')->latest()->paginate(5);
    }

    /**
     * Count the number of comments that belongs to this post
     */
    public function countComments(): int
    {
        return $this?->post?->comments()->withTrashed()->whereNull('parent_id')->count();
    }

    /**
     * Event listener that listens to its child components
     */
    public function refreshComments(): void
    {
        $this->dispatch('reload-comments');
    }

    /**
     *  Returns the name of the Livewire pagination view to be used
     */
    public function paginationView()
    {
        return 'vendor.livewire.custom';
    }
    
    #[On('render-comments')]
    public function render(): View
    {
        return view('livewire.comment.post-comment')->with([
            'count' =>  Str::uuid(),
        ]);
    }
}