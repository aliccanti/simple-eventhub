<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'organizer_id' => User::factory()->organizer(),
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'date' => now()->addDays(7)->toDateString(),
            'ticket_price' => 100.00,
            'capacity' => 100,
        ];
    }
}
