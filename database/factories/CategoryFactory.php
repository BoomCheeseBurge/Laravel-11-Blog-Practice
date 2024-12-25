<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->sentence(rand(1,2), false);
        $color = fake()->unique()->safeColorName();
        return [
            'name' => $name, // The 'false' argument determines that there will be exactly one or two sentences and no in-between
            'slug' => Str::slug($name),
            'color' => $color,
            'image' => str_replace(' ', '', $color) . '.png',
        ];
    }
}
