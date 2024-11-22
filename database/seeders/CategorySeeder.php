<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Category::factory(3)->create();

        Category::create([
            'name' => 'Web Design',
            'slug' => 'web-design',
            'color' => 'cyan',
            'image' => 'IMG/category-img/web-design.jpg',
        ]);

        Category::create([
            'name' => 'UI UX',
            'slug' => 'ui-ux',
            'color' => 'teal',
            'image' => 'IMG/category-img/ui-ux.jpg',
        ]);

        Category::create([
            'name' => 'Machine Learning',
            'slug' => 'machine-learning',
            'color' => 'amber',
            'image' => 'IMG/category-img/machine-learning.jpg',
        ]);

        Category::create([
            'name' => 'Data Structure',
            'slug' => 'data-structure',
            'color' => 'violet',
            'image' => 'IMG/category-img/data-structure.jpg',
        ]);
    }
}
