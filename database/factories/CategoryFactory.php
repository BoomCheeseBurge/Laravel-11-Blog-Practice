<?php

namespace Database\Factories;

use Illuminate\Support\Str;
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
        $name = fake()->sentence(rand(1,2), false);
        return [
            'name' => $name, // The 'false' argument determines that there will be exactly one or two sentences and no in-between
            'slug' => Str::slug($name),
        ];
    }
}
