<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;

class AdminCategoryTest extends TestCase
{
    private User $user;
    private User $adminUser;

    public function setUp():void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->adminUser = User::factory()->create(['is_admin' => true]);
    }
    
    public function test_non_admin_users_cannot_access_admin_category_page(): void
    {
        $this->actingAs($this->user)->get(route('categories.index'))->assertStatus(403);
    }

    public function test_admin_users_can_access_admin_category_page(): void
    {
        $this->actingAs($this->adminUser)->get(route('categories.index'))->assertStatus(200);
    }

    public function test_non_admin_users_cannot_store_category(): void
    {
        Storage::fake('posts');

        $file = UploadedFile::fake()->image('update.jpg')->size(800);
        
        $newCategory = [
            
            'name' => 'Category Example',
            'slug' => 'category-example',
            'color' => 'example',
            'image' => $file,
        ];

        $this->actingAs($this->user)
            ->post(route('categories.store'), $newCategory)
            ->assertStatus(403);
    }

    public function test_admin_users_store_category_successful(): void
    {
        Storage::fake('posts');

        $file = UploadedFile::fake()->image('example.jpg')->size(800);
        
        $newCategory = [
            
            'name' => 'Category Example',
            'color' => 'red',
            'image' => $file,
        ];

        $response = $this->actingAs($this->adminUser)
            ->post(route('categories.store'), $newCategory);
        $newCategory['image'] = $file->hashName();

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('categories', $newCategory);
    }

    public function test_create_category_redirects_and_returns_validation_errors()
    {
        Storage::fake('categories');

        $file = UploadedFile::fake()->image('example.jpg')->size(2000);
        
        $newCategory = [
            
            'name' => 'wonderful serenity has taken possession of my entire soul',
            'slug' => 'wonderful-serenity-has-taken-possession-of-my-entire-soul',
            'color' => 'gamboge',
            'image' => $file,
        ];

        $response = $this->actingAs($this->adminUser)->post(route('categories.store'), $newCategory);

        $response->assertSessionHasErrors(['name', 'image', 'color']);
        $response->assertInvalid(['name', 'image', 'color']);
    }

    public function test_non_admin_users_cannot_update_category(): void
    {
        $category = Category::factory()->create([
                                                    'name' => 'Category Example',
                                                    'slug' => 'category-example',
                                                    'color' => 'red',
                                                ]);
        $newCategory = [
            'catName' => 'Category Example',
            'catColor' => 'red',
        ];

        $response = $this->actingAs($this->user)
            ->put(route('categories.update', ['category' => $category->slug]), $newCategory);

        $response->assertStatus(403);
    }

    public function test_admin_users_update_category_successful(): void
    {
        $category = Category::factory()->create([
                                                    'name' => 'Category Example',
                                                    'color' => 'red',
                                                ]);
        $newCategory = [
            'catName' => 'Category Example',
            'catColor' => 'blue',
        ];

        $response = $this->actingAs($this->adminUser)
            ->put(route('categories.update', ['category' => $category->slug]), $newCategory);

        $response->assertSessionHas('success');
        $this->assertEquals(Category::first()['color'], 'blue');
    }

    public function test_category_update_redirects_and_returns_validation_errors()
    {
        Storage::fake('categories');

        $category = Category::factory()->create([
            'name' => 'Category Example',
            'slug' => 'category-example',
            'color' => 'red',
        ]);

        $file = UploadedFile::fake()->image('example.jpg')->size(2000);

        $response = $this->actingAs($this->adminUser)->put(route('categories.update', ['category' => $category->slug]), [
                                                        'catName' => 'wonderful serenity has taken possession of my entire soul',
                                                        'catColor' => 'gamboge',
                                                        'image' => $file,
                                                    ]);

        $response->assertSessionHasErrors(['catName', 'image', 'catColor']);
        $response->assertInvalid(['catName', 'image', 'catColor']);
    }

    public function test_non_admin_users_cannot_delete_category(): void
    {
        $category = Category::factory()->create([
                                                    'name' => 'Category Example',
                                                    'slug' => 'category-example',
                                                    'color' => 'red',
                                                ]);

        $response = $this->actingAs($this->user)
            ->delete(route('categories.destroy', ['category' => $category->slug]));

        $response->assertStatus(403);
    }

    public function test_admin_users_delete_category_successful(): void
    {
        Storage::fake('categories');

        $file = UploadedFile::fake()->image('example.jpg')->size(800);

        $category = Category::factory()->create([
                                                    'name' => 'Category Example',
                                                    'slug' => 'category-example',
                                                    'color' => 'red',
                                                    'image' => $file,
                                                ]);

        $this->actingAs($this->adminUser)
            ->delete(route('categories.destroy', ['category' => $category->slug]));

        $this->assertDatabaseEmpty('categories');
    }

    public function test_prevent_category_deletion_with_associated_posts(): void
    {
        Storage::fake('categories');

        $file = UploadedFile::fake()->image('example.jpg')->size(800);

        $category = Category::factory()->create([
                                                    'name' => 'Category Example',
                                                    'slug' => 'category-example',
                                                    'color' => 'red',
                                                    'image' => $file,
                                                ]);

        Post::factory()->create(['category_id' => 1]);

        $response = $this->actingAs($this->adminUser)
            ->delete(route('categories.destroy', ['category' => $category->slug]));

        $response->assertSessionHas('fail');
    }
}
