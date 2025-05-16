<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WorkingHour;

class WorkingHourSeeder extends Seeder
{
    public function run(): void
    {
        foreach (range(1, 7) as $day) {
            WorkingHour::create([
                'day_of_week' => $day,
                'start_time' => '09:00:00',
                'end_time' => '18:00:00',
                'business_id' => 1,
            ]);
        }
        foreach (range(1, 7) as $day) {
            WorkingHour::create([
                'day_of_week' => $day,
                'start_time' => '11:00:00',
                'end_time' => '20:00:00',
                'business_id' => 3,
            ]);
        }
        foreach (range(1, 7) as $day) {
            WorkingHour::create([
                'day_of_week' => $day,
                'start_time' => '12:00:00',
                'end_time' => '21:00:00',
                'business_id' => 4,
            ]);
        }
    }
}