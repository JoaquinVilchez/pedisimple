<?php

use Illuminate\Database\Seeder;
use App\OpeningDateTime;
use Carbon\Carbon;

class OpeningDateTimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($dia=1; $dia < 7; $dia++) { 
            OpeningDateTime::create([
                'restaurant_id' => 1,
                'weekday' => $dia,
                'start_hour_1' => '10:00',
                'end_hour_1' => '14:00',
                'start_hour_2' => '20:00',
                'end_hour_2' => '00:00',
            ]);
        }

        for ($dia=1; $dia < 7; $dia++) { 
            OpeningDateTime::create([
                'restaurant_id' => 2,
                'weekday' => $dia,
                'start_hour_1' => '09:00',
                'start_hour_1' => '21:30',
            ]);
        }
    }
}
