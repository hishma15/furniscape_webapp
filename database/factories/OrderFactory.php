<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
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
            'customer_id' => \App\Models\User::factory()->state([
                'role' => 'customer',
            ]), // customer
            'admin_id' => \App\Models\User::factory()->state([
                'role' => 'admin',
            ]), // admin
            'total_amount' => $this->faker->randomFloat(2, 200, 2000),
            'order_date' => now(),
            'delivery_date' => $this->faker->dateTimeBetween('+1 days', '+10 days'),
            'home_no' => $this->faker->buildingNumber,
            'street' => $this->faker->streetName,
            'city' => $this->faker->city,
            'status' => $this->faker->randomElement(['pending', 'processing', 'shipped', 'delivered', 'cancelled']),
        ];
    }
}
