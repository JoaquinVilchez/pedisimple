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
                'shop-id' => 1,
                'weekday' => $dia,
                'start-hour' => '20:00',
                'end-hour' => '00:00',
            ]);
        }

        for ($dia=1; $dia < 7; $dia++) { 
            OpeningDateTime::create([
                'shop-id' => 2,
                'weekday' => $dia,
                'start-hour' => '09:00',
                'end-hour' => '21:30',
            ]);
        }
    }
}
