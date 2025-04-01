<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BusinessFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->company(),
            'description' => fake()->catchPhrase(),
            'location' => fake()->address(),
            'phone' => fake()->phoneNumber(),
            'owner_id' => null, // asignar desde el seeder
        ];
    }
}