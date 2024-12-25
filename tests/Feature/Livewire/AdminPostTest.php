<?php

namespace Tests\Feature\Livewire;

use Tests\TestCase;
use App\Models\Post;
use App\Models\User;
use Livewire\Livewire;
use App\Models\Comment;
use App\Models\Category;
use App\Livewire\Admin\AllPostsIndex;
use Illuminate\Foundation\Testing\WithFaker;

class AdminPostTest extends TestCase
{
    private User $user;
    private User $adminUser;

    public function setUp():void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->adminUser = User::factory()->create(['is_admin' => true]);
    }
    
    public function test_non_admin_users_cannot_access_admin_post_page(): void
    {
        $this->actingAs($this->user)->get(route('admin.posts.index'))->assertStatus(403);
    }

    public function test_admin_users_can_access_admin_post_page(): void
    {
        $this->actingAs($this->adminUser)->get(route('admin.posts.index'))->assertStatus(200);
    }

    public function test_last_item_is_hidden_in_admin_post_pagination(): void
    {
        $posts = Post::factory(11)->create();
        $lastPost = $posts->last();
        
        Livewire::actingAs($this->adminUser)->test(AllPostsIndex::class)
                ->assertViewHas('records', function($records) use($lastPost) {

                    return !$records->contains($lastPost);
                });
    }

    public function test_view_archived_posts_button_is_seen(): void
    {
        Post::factory()->create();
        
        Livewire::actingAs($this->adminUser)->test(AllPostsIndex::class)
                ->assertSeeText('View Archived Posts');
    }

    public function test_bulk_remove_of_selected_records_successful(): void
    {
        Post::factory(10)->create();
        
        Livewire::actingAs($this->adminUser)->test(AllPostsIndex::class)
                ->set('selectedRecords', [1, 2, 3, 4, 5])
                ->call('removeSelected')
                ->assertViewHas('records', function($records) {
                    $this->assertEquals($records->count(), 5);
                    return true;
                });
    }

    public function test_bulk_edit_of_selected_records_successful(): void
    {
        Category::factory()->create(['name' => 'foo']);
        Category::factory()->create(['name' => 'bar']);
        Post::factory(5)->create(['category_id' => 1]);
        
        Livewire::actingAs($this->adminUser)->test(AllPostsIndex::class)
                ->set([
                    'selectedRecords' => [1, 2, 3, 4, 5],
                    'selectedCategory' => 2,
                ])
                ->call('editSelected')
                ->assertViewHas('records', function ($records) {

                    $this->assertTrue($records->first()['category_name'] === 'bar');
                    
                    return true;
                });
    }

    public function test_prohibit_bulk_edit_on_null_selected_category(): void
    {
        Category::factory()->create(['name' => 'foo']);
        Category::factory()->create(['name' => 'bar']);
        Post::factory(5)->create(['category_id' => 1]);
        
        Livewire::actingAs($this->adminUser)->test(AllPostsIndex::class)
                ->set([
                    'selectedRecords' => [1, 2, 3, 4, 5],
                    'selectedCategory' => null,
                ])
                ->call('editSelected')
                ->assertViewHas('records', function ($records) {

                    $this->assertTrue($records->first()['category_name'] === 'foo');
                    
                    return true;
                });
    }

    public function test_bulk_delete_of_selected_records_successful(): void
    {
        Post::factory(5)->create(['deleted_at' => now()]);
        
        Livewire::actingAs($this->adminUser)->test(AllPostsIndex::class)
                ->set([
                    'archive' => true,
                    'selectedRecords' => [1, 2, 3, 4, 5]
                ])
                ->call('deleteSelected')
                ->assertSee('No Records Found')
                ->assertViewHas('records', function($records) {
                    $this->assertTrue($records->isEmpty());
                    return true;
                });
    }

    public function test_prohibit_multiple_posts_deletion_with_existing_comment(): void
    {
        Post::factory(5)->create(['deleted_at' => now()])->each(function($post) {
            Comment::factory()->create([
                'post_id' => $post->id,
                'user_id' => $this->user->id,
            ]);
        });
        
        Livewire::actingAs($this->adminUser)->test(AllPostsIndex::class)
                ->set([
                    'archive' => true,
                    'selectedRecords' => [1, 2, 3, 4, 5]
                ])
                ->call('deleteSelected')
                ->assertViewHas('records', function($records) {
                    $this->assertEquals($records->count(), 5);
                    return true;
                });
    }

    public function test_restore_archived_posts_successful(): void
    {
        Post::factory(5)->create(['deleted_at' => now()]);
        
        Livewire::actingAs($this->adminUser)->test(AllPostsIndex::class)
                ->set([
                    'archive' => true,
                    'selectedRecords' => [1, 2, 3, 4, 5]
                ])
                ->call('restoreSelected')
                ->assertViewHas('records', function($records) {
                    $this->assertEquals($records->count(), 5);
                    return true;
                });

        Livewire::actingAs($this->adminUser)->test(AllPostsIndex::class)
                ->set('archive', true)
                ->assertViewHas('records', function($records) {
                    $this->assertTrue($records->isEmpty());
                    return true;
                });
    }

    public function test_remove_single_post_successful(): void
    {
        $posts = Post::factory(3)->create();
        
        Livewire::actingAs($this->adminUser)->test(AllPostsIndex::class)
                ->set('selectedPost', $posts->first())
                ->call('removeSinglePost')
                ->assertViewHas('records', function($records) {
                    $this->assertEquals($records->count(), 2);
                    return true;
                });
    }

    public function test_restore_single_post_successful(): void
    {
        $posts = Post::factory(3)->create(['deleted_at' => now()]);
        
        Livewire::actingAs($this->adminUser)->test(AllPostsIndex::class)
                ->set([
                    'archive' => true,
                    'selectedPost' => $posts->first(),
                ])
                ->call('restoreSinglePost')
                ->assertViewHas('records', function($records) {
                    $this->assertEquals($records->count(), 1);
                    return true;
                });
    }

    public function test_delete_single_post_successful(): void
    {
        $posts = Post::factory(3)->create(['deleted_at' => now()]);
        
        Livewire::actingAs($this->adminUser)->test(AllPostsIndex::class)
                ->set('selectedPost',$posts->first())
                ->call('restoreSinglePost')
                ->set('archive', true)
                ->assertViewHas('records', function($records) {
                    $this->assertEquals($records->count(), 2);
                    return true;
                });
    }

    public function test_prohibit_single_post_deletion_with_existing_comment(): void
    {
        $posts = Post::factory(3)->create(['deleted_at' => now()])->each(function($post) {
            Comment::factory()->create([
                'post_id' => $post->id,
                'user_id' => $this->user->id,
            ]);
        });
        
        Livewire::actingAs($this->adminUser)->test(AllPostsIndex::class)
                ->set('selectedPost', $posts->first())
                ->call('deleteSinglePost')
                ->set('archive', true)
                ->assertViewHas('records', function($records) {
                    $this->assertEquals($records->count(), 3);
                    return true;
                });
    }
}
