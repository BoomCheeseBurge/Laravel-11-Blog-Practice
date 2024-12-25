<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Category;
use Illuminate\Support\Collection;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HomepageTest extends TestCase
{
    /**
     * Test if the homepage view can be accessed.
     */
    public function test_homepage_can_be_viewed(): void
    {
        $response = $this->get('/');

        $response->assertOk();
    }

    /**
     * Test if the homepage view can be accessed.
     */
    // public function test_category_images_are_shown(): void
    // {
    //     $category = Category::create(
    //         [
    //             'name' => 'Web Design',
    //             'slug' => 'web-design',
    //             'color' => 'cyan',
    //             'image' => 'web-design.jpg',
    //             'created_at' => now(),
    //             'updated_at' => now(),
    //         ]);

    //     $category = Category::all();

    //     $response = $this->get('/');

    //     $response->assertViewHas('categories', function(Collection $categories) use ($category) {

    //         return $categories->contains($category);
    //     });
    // }
}
