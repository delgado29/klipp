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
        Service::factory()->create([
            'name' => 'Afeitado',
            'description' => 'Afeitado clásico con navaja',
            'price' => 80,
            'duration' => 20,
            'business_id' => 1,
        ]);
        Service::factory()->create([
            'name' => 'Coloración de cabello',
            'description' => 'Cambio de color o mechas',
            'price' => 500,
            'duration' => 120,
            'business_id' => 4,
        ]);
        Service::factory()->create([
            'name' => 'Peinado de gala',
            'description' => 'Peinado para eventos especiales',
            'price' => 300,
            'duration' => 60,
            'business_id' => 4,
        ]);
        Service::factory()->create([
            'name' => 'Masaje relajante',
            'description' => 'Masaje de cuerpo completo',
            'price' => 600,
            'duration' => 90,
            'business_id' => 3,
        ]);
        Service::factory()->create([
            'name' => 'Facial hidratante',
            'description' => 'Tratamiento facial para piel seca',
            'price' => 400,
            'duration' => 60,
            'business_id' => 3,
        ]);
        Service::factory()->create([
            'name' => 'Manicura',
            'description' => 'Cuidado y esmaltado de uñas',
            'price' => 200,
            'duration' => 45,
            'business_id' => 3,
        ]);
        Service::factory()->create([
            'name' => 'Pedicura',
            'description' => 'Cuidado y esmaltado de pies',
            'price' => 250,
            'duration' => 60,
            'business_id' => 3,
        ]);
        Service::factory()->create([
            'name' => 'Corte de barba',
            'description' => 'Corte y arreglo de barba',
            'price' => 100,
            'duration' => 30,
            'business_id' => 1,
        ]);
        
    }
}