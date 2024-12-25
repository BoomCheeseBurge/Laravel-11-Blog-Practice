<?php

namespace App\Livewire\Comment;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;

class CommentCreate extends Component
{
    #[Locked]
    public Post $post;
    
    #[Validate('required|min:3|max:100')]
    public string $comment;

    /**
     * Data passed into components is received through the mount() lifecycle hook as method parameters
     */
    public function mount(Post $post): void
    {        
        $this->post = $post; // Assign the post model instance
    }

    /**
     * Store the created comment into the database
     */
    public function submitComment(): void
    {
        // If the user doesn't own the post,
        // an AuthorizationException will be thrown...
        auth()->user()->can('create', Comment::class);

        $this->validateOnly('comment'); // Only validate the comment property

        $this->post->comments()->create([
            'user_id' => auth()->id(),
            'post_id' => $this->post->id,
            'comment' => $this->comment,
        ]);

        $this->reset('comment'); // Reset the comment property to an empty string

        $this->dispatch('render-comments')->to(PostComment::class); // Inform the parent component to refresh the comments
    }
    
    public function render(): View
    {
        return view('livewire.comment.comment-create');
    }
}