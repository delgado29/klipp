<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Business;

class WorkingHourFactory extends Factory
{
    public function definition(): array
    {
        return [
            'business_id' => Business::inRandomOrder()->first()->id ?? Business::factory(),
            'day_of_week' => $this->faker->numberBetween(0, 6), // 0 = Domingo
            'open_time' => $this->faker->time('H:i'),
            'close_time' => $this->faker->time('H:i'),
        ];
    }
}