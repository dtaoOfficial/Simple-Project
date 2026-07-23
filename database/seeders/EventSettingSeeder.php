<?php

namespace Database\Seeders;

use App\Models\EventSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         EventSetting::create([
            'start_date' => '2026-08-01',
            'end_date' => '2026-09-30',
            'timings' => '4:00 PM - 6:00 PM',
            'fee' => 2500.00,
            'phone' => '9876543210',
            'min_age' => 5,
            'max_age' => 12,
        ]);
    }
}
