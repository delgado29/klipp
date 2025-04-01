<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Business;

class BusinessSeeder extends Seeder
{
    public function run(): void
    {
        Business::factory()->create([
            'name' => 'Klipp Barbería',
            'description' => 'Cortes de cabello modernos y clásicos',
            'phone' => '6141234567',
            'address' => 'Av. Tecnológico 123',
            'owner_id' => 1, 
        ]);
    }
}