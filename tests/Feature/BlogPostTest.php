<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BlogPostTest extends TestCase
{
    public function test_blog_page_can_be_viewed(): void
    {
        $response = $this->get(route('blog.posts'));

        $response->assertStatus(200);
    }

    public function test_last_item_is_hidden_in_pagination(): void
    {
        $posts = Post::factory(10)->create();
        $lastPost = $posts->last();

        $response = $this->get(route('blog.posts'));

        $response->assertViewHas('posts', function($collection) use ($lastPost) {

            return !$collection->contains($lastPost);
        });
    }
}
