<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Appointment;
use Carbon\Carbon;

class AppointmentSeeder extends Seeder
{
    public function run(): void
    {
        Appointment::create([
            'customer_id' => 3, // client
            'employee_id' => 2, // employee
            'service_id' => 1,
            'business_id' => 1,
            'date' => Carbon::now()->format('Y-m-d'),
            'time' => '10:00:00',
            'status' => 'pending',
            'start_time' => Carbon::now()->addHours(1),
            'end_time' => Carbon::now()->addHours(2),
        ]);
    }
}