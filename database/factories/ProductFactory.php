<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->unique()->sentence(3);

        return [
            'category_id' => Category::inRandomOrder()->value('id'),

            'title' => $title,

            'slug' => Str::slug($title),

            'author' => fake()->name(),

            'description' => fake()->paragraph(),

            'price' => fake()->randomFloat(2, 250, 1500),

            'stock' => fake()->numberBetween(5, 50),

            'image_path' => 'books/book' . rand(1, 12) . '.jpg',

            'is_active' => true,
        ];
    }
}
