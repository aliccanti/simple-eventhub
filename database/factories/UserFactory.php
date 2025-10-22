<?php

namespace Database\Factories;

use App\Enums\UserTypeEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => 'password',
            'type' => UserTypeEnum::PARTICIPANT->value,
        ];
    }

    public function organizer(): self
    {
        return $this->state(fn () => ['type' => UserTypeEnum::ORGANIZER->value]);
    }
}
