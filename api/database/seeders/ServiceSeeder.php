<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        Service::factory()->create([
            'name' => 'Corte de cabello',
            'description' => 'Corte clásico o moderno',
            'price' => 120,
            'duration' => 30,
            'business_id' => 1,
        ]);
    }
}