<?php

namespace Database\Factories;

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
        return [
            //
            'category_name' => $this->faker->word,
            'category_desc' => $this->faker->sentence,
            'category_image' => $this->faker->imageUrl(640, 480, 'products'),
            'admin_id' => \App\Models\User::factory()->state([
                'role' => 'admin',
            ]),
        ];
    }
}
