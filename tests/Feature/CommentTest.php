<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Post;
use App\Models\User;
use Livewire\Livewire;
use App\Models\Comment;
use App\Livewire\Comment\CommentItem;
use App\Livewire\Comment\PostComment;
use App\Livewire\Comment\CommentCreate;
use Illuminate\Foundation\Testing\WithFaker;

class CommentTest extends TestCase
{
    private User $user;

    public function setUp():void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }
    
    public function test_non_authenticated_user_cannot_see_comment_create(): void
    {
        $post = Post::factory()->create();

        Livewire::test(PostComment::class, ['post' => $post])
                ->assertDontSee('Submit');
    }

    public function test_authenticated_user_can_see_comment_create(): void
    {
        $post = Post::factory()->create();

        Livewire::actingAs($this->user)->test(PostComment::class, ['post' => $post])
                ->assertSee('Submit');
    }

    public function test_authenticated_user_create_comment_successful(): void
    {
        $post = Post::factory()->create();

        Livewire::actingAs($this->user)->test(CommentCreate::class, ['post' => $post])
                ->set('comment', 'This is a comment example.')
                ->call('submitComment');

        $this->assertDatabaseCount('comments', 1);
    }

    public function test_create_comment_throws_validation_error(): void
    {
        $post = Post::factory()->create();

        Livewire::actingAs($this->user)->test(CommentCreate::class, ['post' => $post])
                ->set('comment', 'This sentence aims to precisely reach the 100 character limit, demonstrating accurate character counting abilities.')
                ->call('submitComment')
                ->assertHasErrors('comment');
    }

    public function test_non_authenticated_user_cannot_see_comment_reply_button(): void
    {
        $post = Post::factory()->create();

        $comment = Comment::factory()->create([
            'post_id' => $post->id,
            'user_id' => $this->user->id,
        ]);

        Livewire::test(PostComment::class, ['post' => $post])
                ->assertDontSee('id="replyButton-' . $comment->id . '"', false);
    }

    public function test_authenticated_user_can_see_comment_reply_button(): void
    {
        $post = Post::factory()->create();

        $comment = Comment::factory()->create([
            'post_id' => $post->id,
            'user_id' => $this->user->id,
        ]);

        Livewire::actingAs($this->user)->test(PostComment::class, ['post' => $post])
                ->assertSee('id="replyButton-' . $comment->id . '"', false);
    }

    public function test_authenticated_user_create_comment_reply_successful(): void
    {
        $post = Post::factory()->create();

        $comment = Comment::factory()->create([
            'post_id' => $post->id,
            'user_id' => $this->user->id,
        ]);

        Livewire::actingAs($this->user)->test(CommentItem::class, ['post' => $post, 'comment' => $comment])
                ->set('commentReply', 'This is an comment reply example.')
                ->call('createReply');

        $this->assertDatabaseCount('comments', 2);
    }

    public function test_create_comment_reply_throws_validation_error(): void
    {
        $post = Post::factory()->create();

        $comment = Comment::factory()->create([
            'post_id' => $post->id,
            'user_id' => $this->user->id,
        ]);

        Livewire::actingAs($this->user)->test(CommentItem::class, ['post' => $post, 'comment' => $comment])
                ->set('commentReply', 'This sentence aims to precisely reach the 100 character limit, demonstrating accurate character counting abilities.')
                ->call('createReply')
                ->assertHasErrors('commentReply');
    }

    public function test_non_authenticated_user_cannot_see_comment_edit_button(): void
    {
        $post = Post::factory()->create();

        $comment = Comment::factory()->create([
            'post_id' => $post->id,
            'user_id' => $this->user->id,
        ]);

        Livewire::test(PostComment::class, ['post' => $post])
                ->assertDontSee('id="editButton-' . $comment->id . '"', false);
    }

    public function test_non_comment_author_cannot_see_edit_button(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();

        $comment = Comment::factory()->create([
            'post_id' => $post->id,
            'user_id' => $user->id,
        ]);

        Livewire::actingAs($this->user)->test(PostComment::class, ['post' => $post])
                ->assertDontSee('id="editButton-' . $comment->id . '"', false);
    }

    public function test_comment_author_can_see_edit_button(): void
    {
        $post = Post::factory()->create();

        $comment = Comment::factory()->create([
            'post_id' => $post->id,
            'user_id' => $this->user->id,
        ]);

        Livewire::actingAs($this->user)->test(PostComment::class, ['post' => $post])
                ->assertSee('id="editButton-' . $comment->id . '"', false);
    }

    public function test_comment_update_successful_by_comment_author(): void
    {
        $post = Post::factory()->create();

        $comment = Comment::factory()->create([
            'post_id' => $post->id,
            'user_id' => $this->user->id,
        ]);

        Livewire::actingAs($this->user)->test(CommentItem::class, ['post' => $post, 'comment' => $comment])
                ->set('commentContent', 'This is an updated comment example.')
                ->call('updateComment');

        $this->assertEquals('This is an updated comment example.', Comment::first()['comment']);
    }

    public function test_comment_update_throws_validation_error(): void
    {
        $post = Post::factory()->create();

        $comment = Comment::factory()->create([
            'post_id' => $post->id,
            'user_id' => $this->user->id,
        ]);

        Livewire::actingAs($this->user)->test(CommentItem::class, ['post' => $post, 'comment' => $comment])
                ->set('commentContent', 'This sentence aims to precisely reach the 100 character limit, demonstrating accurate character counting abilities.')
                ->call('updateComment')
                ->assertHasErrors('commentContent');
    }
    public function test_non_authenticated_user_cannot_see_comment_delete_button(): void
    {
        $post = Post::factory()->create();

        Comment::factory()->create([
            'post_id' => $post->id,
            'user_id' => $this->user->id,
        ]);

        Livewire::test(PostComment::class, ['post' => $post])
                ->assertDontSee('Remove');
    }

    public function test_non_comment_author_cannot_see_delete_button(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();

        Comment::factory()->create([
            'post_id' => $post->id,
            'user_id' => $user->id,
        ]);

        Livewire::actingAs($this->user)->test(PostComment::class, ['post' => $post])
                ->assertDontSee('Remove');
    }

    public function test_comment_author_can_see_delete_button(): void
    {
        $post = Post::factory()->create();

        Comment::factory()->create([
            'post_id' => $post->id,
            'user_id' => $this->user->id,
        ]);

        Livewire::actingAs($this->user)->test(PostComment::class, ['post' => $post])
                ->assertSee('Remove');
    }

    public function test_comment_delete_successful_by_comment_author(): void
    {
        $post = Post::factory()->create();

        $comment = Comment::factory()->create([
            'post_id' => $post->id,
            'user_id' => $this->user->id,
        ]);

        Livewire::actingAs($this->user)->test(CommentItem::class, ['post' => $post, 'comment' => $comment])
                ->call('deleteComment');

        $this->assertDatabaseCount('comments', 0);
    }

    public function test_comment_delete_with_child_comment_becomes_anonymous_comment(): void
    {
        $post = Post::factory()->create();

        $comment = Comment::factory()->create([
            'post_id' => $post->id,
            'user_id' => $this->user->id,
        ]);

        Comment::factory()->create([
            'parent_id' => $comment->id,
            'post_id' => $post->id,
            'user_id' => User::factory()->create(),
        ]);

        Livewire::actingAs($this->user)->test(CommentItem::class, ['post' => $post, 'comment' => $comment])
                ->call('deleteComment');

        $this->assertEquals('[ This comment has been deleted ]', Comment::withTrashed()->find(1)->comment);
    }
}
