<?php

namespace Database\Seeders;

use App\Models\SystemSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SystemSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SystemSetting::firstOrCreate(
            [
                'submit_day_allow'   => 5,
                'date_salary'        => 5,

                'working_start'      => '09:00:00',
                'working_end'        => '18:00:00',

                'meal_allowance'     => 10.00,

                'ot_rate'            => 1.5,
                'ot_weekend_rate'    => 2.0,
                'ot_holiday_rate'    => 3.0,

                'first_ot_meal_hrs'  => 2,
                'first_ot_meal_time' => '20:00:00',
                'extra_ot_meal_hrs'  => 4,
            ]
        );
    }
}