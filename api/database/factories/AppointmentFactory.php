<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Service;

class AppointmentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'service_id' => Service::inRandomOrder()->first()->id ?? Service::factory(),
            'date' => $this->faker->dateTimeBetween('+1 days', '+2 months')->format('Y-m-d'),
            'start_time' => $this->faker->time('H:i'),
            'end_time' => $this->faker->time('H:i'),
            'status' => $this->faker->randomElement(['scheduled', 'completed', 'canceled']),
        ];
    }
}