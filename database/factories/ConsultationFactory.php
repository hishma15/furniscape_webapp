<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Consultation>
 */
class ConsultationFactory extends Factory
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
            'prefered_date' => $this->faker->date(),
            'prefered_time' => $this->faker->time(),
            'status' => $this->faker->randomElement(['pending', 'confirmed', 'completed', 'cancelled']),
            'mode' => $this->faker->randomElement(['phone_call', 'video_call', 'in_store']),
            'topic' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph,
        ];
    }
}
