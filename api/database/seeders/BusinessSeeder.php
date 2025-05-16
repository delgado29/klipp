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

        Business::factory()->create([
            'name' => 'Salón Estilo Único',
            'description' => 'Especialistas en coloración y peinados de gala',
            'phone' => '6142345678',
            'address' => 'Calle Reforma 456',
            'owner_id' => 2,
        ]);

        Business::factory()->create([
            'name' => 'Spa Relax Total',
            'description' => 'Masajes terapéuticos y faciales relajantes',
            'phone' => '6143456789',
            'address' => 'Blvd. Benito Juárez 789',
            'owner_id' => 3,
        ]);

       


    }
}