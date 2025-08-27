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
    public function definition(): array
    {
        return [
            //
            'product_name' => $this->faker->words(2, true),
            'no_of_stock' => $this->faker->numberBetween(2, 15),
            'price' => $this->faker->randomFloat(2, 100, 1000),
            'type' => $this->faker->randomElement(['furniture', 'home decor', 'other']),
            'product_image' => $this->faker->imageUrl(640, 480, 'products'),
            'description' => $this->faker->paragraph,
            'is_featured' => $this->faker->boolean,
            'category_id' => \App\Models\Category::factory(),
            'admin_id' => \App\Models\User::factory()->state([
                'role' => 'admin',
            ]), // admin
        ];
    }
}
