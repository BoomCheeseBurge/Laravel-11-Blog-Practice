<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use App\Models\Comment;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;

class DashboardPostTest extends TestCase
{
    private User $user;
    private User $adminUser;

    public function setUp():void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->adminUser = User::factory()->create(['is_admin' => true]);
    }

    public function test_dashboard_post_page_can_be_viewed(): void
    {
        $response = $this->actingAs($this->user)->get(route('posts.index'));

        $response->assertStatus(200);
    }

    public function test_last_item_is_hidden_in_pagination(): void
    {
        $posts = Post::factory(11)->create();
        $lastPost = $posts->last();

        $response = $this->actingAs($this->user)->get(route('posts.index'));

        $response->assertViewHas('posts', function($collection) use ($lastPost) {

            return !$collection->contains($lastPost);
        });
    }

    public function test_create_post_successful():void
    {
        Storage::fake('posts');

        // $this->withoutExceptionHandling();

        $file = UploadedFile::fake()->image('example.jpg')->size(800);

        Category::factory()->create();

        $dummyData = [
            'title' => 'Neque porro quisquam est qui dolorem ipsum',
            'slug' => 'neque-porro-quisquam-est-qui-dolorem-ipsum',
            'category_id' => 1,
            'body' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse non odio ante. In sed libero mollis, eleifend ipsum dignissim, pharetra nibh. Quisque mollis, erat a aliquet pharetra, nibh metus fringilla neque, a ullamcorper massa tellus sit amet nibh. Duis tempus.',
            'featured_image' => $file,
        ];
 
        $response = $this->actingAs($this->user)->post(route('posts.store'), $dummyData);

        Storage::disk('posts')->assertExists($file->hashName());
        $response->assertRedirect(route('posts.index'));
        $dummyData['featured_image'] = $file->hashName();

        $this->assertDatabaseHas('posts', $dummyData);

        $recentPost = Post::latest()->first();
        $this->assertEquals($dummyData['title'], $recentPost->title);
        $this->assertEquals($dummyData['slug'], $recentPost->slug);
        $this->assertEquals($file->hashName(), $recentPost->featured_image);
    }

    public function test_create_post_redirects_and_returns_validation_errors()
    {
        Storage::fake('posts');

        // $this->withoutExceptionHandling();

        $file = UploadedFile::fake()->image('example.jpg')->size(2000);

        Category::factory()->create();

        $dummyData = [
            'title' => 'Neque #porro %quisquam e&&st qui dolorem^!@: ipsum',
            'slug' => 'neque-porro-quisquam-est-qui-dolorem-ipsum',
            'category_id' => 1,
            'body' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse non odio ante. In sed libero mollis, eleifend ipsum dignissim, pharetra nibh. Quisque mollis, erat a aliquet pharetra, nibh metus fringilla neque, a ullamcorper massa tellus sit amet nibh. Duis tempus.',
            'featured_image' => $file,
        ];

        $response = $this->actingAs($this->user)->post(route('posts.store'), $dummyData);

        $response->assertSessionHasErrors(['title', 'featured_image']);
        $response->assertInvalid(['title', 'featured_image']);
    }

    public function test_post_edit_accessible_by_the_author()
    {
        Category::factory()->create();
        $post = Post::factory()->create(['author_id' => $this->user->id]);

        $response = $this->actingAs($this->user)->get(route('posts.edit', ['post' => $post->slug]));

        $response->assertStatus(200);
    }

    public function test_post_edit_accessible_by_the_admin()
    {
        Category::factory()->create();
        $post = Post::factory()->create();

        $response = $this->actingAs($this->adminUser)->get(route('posts.edit', ['post' => $post->slug]));

        $response->assertStatus(200);
    }

    public function test_post_edit_inaccessible_by_non_author()
    {
        Category::factory()->create();
        $post = Post::factory()->create();

        $response = $this->actingAs($this->user)->get(route('posts.edit', ['post' => $post->slug]));

        $response->assertStatus(403);
    }

    public function test_post_edit_contains_the_correct_values()
    {
        Category::factory()->create();
        $post = Post::factory()->create(['author_id' => $this->user->id]);

        $response = $this->actingAs($this->user)->get(route('posts.edit', ['post' => $post->slug]));

        $response->assertStatus(200);
        $response->assertSee('value="' . $post->title . '"', false);
        $response->assertSee('value="' . $post->slug . '"', false);
        $response->assertViewHas('post', $post);
    }

    public function test_post_update_redirects_and_returns_validation_errors()
    {
        Storage::fake('posts');

        Category::factory()->create();
        $post = Post::factory()->create(['author_id' => $this->user->id]);
        $file = UploadedFile::fake()->image('update.jpg')->size(2000);

        $response = $this->actingAs($this->user)->put(route('posts.update', ['post' => $post->slug]), [
                                                        'title' => '',
                                                        'featured_image' => $file,
                                                    ]);

        $response->assertSessionHasErrors(['title', 'featured_image']);
        $response->assertInvalid(['title', 'featured_image']);
    }

    public function test_post_update_successful_by_author()
    {
        Category::factory()->create();
        $post = Post::factory()->create(['author_id' => $this->user->id]);

        $this->actingAs($this->user)->put(route('posts.update', ['post' => $post->slug]), [
                                                        'title' => 'Updated Title',
                                                        'slug' => 'updated-title',
                                                        'category_id' => 1,
                                                        'body' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque malesuada malesuada orci, sit amet auctor tortor porta eu. Morbi posuere lectus quis sem scelerisque, at accumsan justo tincidunt. Nam tempus mi at erat tincidunt, ac blandit nunc eleifend. Sed et velit eget augue tempor feugiat. Praesent lacinia commodo enim id imperdiet. Quisque sit amet magna nulla. Etiam pulvinar tempus libero, nec varius sem laoreet eu. Pellentesque vestibulum accumsan facilisis. Cras vel justo ligula. Donec efficitur neque ut varius condimentum. Mauris quis ante in mauris efficitur dignissim in eget lectus. Nulla facilisi.',
                                                ]);
        // var_dump('Old value: ' . $post->title . ' | New Value: ' . Post::first()['title']);

        $this->assertNotEquals($post->title, Post::first()['title']);
    }

    public function test_prevent_non_author_from_post_update()
    {
        Category::factory()->create();
        $post = Post::factory()->create(['author_id' => 2]);

        $response = $this->actingAs($this->user)->put(route('posts.update', ['post' => $post->slug]), [
                                                        'title' => 'Updated Title',
                                                        'slug' => 'updated-title',
                                                        'category_id' => 1,
                                                        'body' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque malesuada malesuada orci, sit amet auctor tortor porta eu. Morbi posuere lectus quis sem scelerisque, at accumsan justo tincidunt. Nam tempus mi at erat tincidunt, ac blandit nunc eleifend. Sed et velit eget augue tempor feugiat. Praesent lacinia commodo enim id imperdiet. Quisque sit amet magna nulla. Etiam pulvinar tempus libero, nec varius sem laoreet eu. Pellentesque vestibulum accumsan facilisis. Cras vel justo ligula. Donec efficitur neque ut varius condimentum. Mauris quis ante in mauris efficitur dignissim in eget lectus. Nulla facilisi.',
                                                ]);
        
        $response->assertStatus(403);
    }

    public function test_post_delete_successful_by_author()
    {
        Storage::fake('posts');

        Category::factory()->create();
        $file = UploadedFile::fake()->image('update.jpg')->size(800);
        $post = Post::factory()->create([
                                        'author_id' => $this->user->id,
                                        'featured_image' => $file->hashName(),
        ]);
        Storage::disk('posts')->putFileAs('/', $file, $file->hashName());
        
        $response = $this->actingAs($this->user)->delete(route('posts.destroy', ['post' => $post->slug]));

        $response->assertRedirect(route('posts.index'));
        Storage::disk('posts')->assertMissing($file->hashName());
        $this->assertDatabaseMissing('posts', $post->toArray());
        $this->assertDatabaseEmpty('posts');
    }

    public function test_post_delete_forbidden_for_non_author()
    {
        Storage::fake('posts');

        Category::factory()->create();
        $file = UploadedFile::fake()->image('update.jpg')->size(800);
        $post = Post::factory()->create([
                                        'author_id' => 2,
                                        'featured_image' => $file->hashName(),
        ]);
        Storage::disk('posts')->putFileAs('/', $file, $file->hashName());

        $response = $this->actingAs($this->user)->delete(route('posts.destroy', ['post' => $post->slug]));

        $response->assertStatus(403);
        Storage::disk('posts')->assertExists($file->hashName());
        $this->assertDatabaseHas('posts', $post->toArray());
    }

    public function test_prevent_post_with_comment_from_deletion()
    {
        Storage::fake('posts');

        Category::factory()->create();
        $file = UploadedFile::fake()->image('update.jpg')->size(800);
        $post = Post::factory()->create([
                                        'author_id' => $this->user->id,
                                        'featured_image' => $file->hashName(),
        ]);

        Comment::factory()->create([
            'post_id' => $post->id,
            'user_id' => $this->user->id,
        ]);

        $response = $this->actingAs($this->user)->delete(route('posts.destroy', ['post' => $post->slug]));

        $response->assertRedirect(route('posts.index'));
    }
}
