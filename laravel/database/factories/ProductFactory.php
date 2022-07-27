<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->words(4, true),
            'description' => fake()->text(800),
            'picture' => 'products_images/slushy.jpg',
            'price' => fake()->randomFloat(2, 1, 10000),
            'number_available' => fake()->numberBetween(1, 10000)
        ];
    }
}
