<?php

namespace App\Livewire\Comment;

use App\Models\Post;
use App\Models\Comment;
use Livewire\Component;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Reactive;
use Livewire\Attributes\Validate;
use Illuminate\Database\Eloquent\Collection;


class CommentItem extends Component
{
    #[Locked]
    public Comment $comment;

    #[Locked]
    public Post $post;

    #[Validate('required|min:3|max:200')]
    public string $commentContent;

    #[Validate('required|min:3|max:200')]
    public string $commentReply;

    protected $listeners = [
        'reload-comments' => '$refresh'
    ];

    /**
     * Data passed into components is received through the mount() lifecycle hook as method parameters
     */
    public function mount(Comment $comment, Post $post): void
    {
        $this->comment = $comment; // Assign the comment model instance
        $this->commentContent = $comment->comment; // Assign the content of the comment

        $this->post = $post; // Assign the post model instance
    }

    /**
     * Compute the child comments that belong to this parent comment
     */
    #[Computed()]
    public function getChildComments(): Collection
    {
        return $this?->comment?->comments()->with(['post','comments','user'])->withTrashed()->latest()->get();
    }

    /**
     * Save the edited comment into the database
     */
    public function updateComment(): void
    {
        // Check if the user is allowed to update the comment,
        // Otherwise, throw an AuthorizationException
        $this->authorize('update', $this->comment);

        $this->validateOnly('commentContent'); // Only validate the comment content property

        $this->comment->comment = $this->commentContent;
        $this->comment->save();

        /**
         * To clear, or "bust", the stored cache, you can use PHP's unset() function.
         * The computed property needs to be re-computed to include the newly added record.
         */
        unset($this->getChildComments);

        $this->dispatch('render-comments')->to(PostComment::class); // Inform the parent component to refresh the comments
    }

    /**
     * Delete the comment from the database
     */
    public function deleteComment(): void
    {
        // Check if the user is allowed to delete the comment,
        // Otherwise, throw an AuthorizationException
        $this->authorize('delete', $this->comment);

        // Check if the comment has any child comments
        if ($this->comment->comments->count() > 0) {
            // The comment will be soft-deleted
            if($this->comment->delete()) {
    
                $this->comment->comment = '[ This comment has been deleted ]'; // Change the content of the comment
                $this->comment->save();
            }
        } else {
            $this->comment->forceDelete(); // Permanently delete the comment
        }

        /**
         * To clear, or "bust", the stored cache, you can use PHP's unset() function.
         * The computed property needs to be re-computed to include the newly added record.
         */
        unset($this->getChildComments);

        $this->dispatch('render-comments')->to(PostComment::class); // Inform the parent component to refresh the comments
    }

    /**
     * Store the comment reply into the database
     */
    public function createReply(): void
    {
        // If the user doesn't own the post,
        // an AuthorizationException will be thrown...
        $this->authorize('create', $this->comment);

        $this->validateOnly('commentReply');

        $this->post->comments()->create([
            'comment' => $this->commentReply,
            'user_id' => auth()->id(),
            'post_id' => $this->post->id,
            'parent_id' => $this->comment->id,
        ]);

        $this->reset('commentReply'); // Reset the comment reply property to an empty string

        /**
         * To clear, or "bust", the stored cache, you can use PHP's unset() function.
         * The computed property needs to be re-computed to include the newly added record.
         */
        unset($this->getChildComments);

        $this->dispatch('render-comments')->to(PostComment::class); // Inform the parent component to refresh the comments
    }

    public function render(): View
    {
        return view('livewire.comment.comment-item')->with([
            'count' =>  Str::uuid(),
        ]);
    }
}
