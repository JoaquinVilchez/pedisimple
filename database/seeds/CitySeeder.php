<?php

use Illuminate\Database\Seeder;
use App\City;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        City::create([
            'zip-code' => '2600',
            'name' => 'Venado Tuerto',
            'province' => 'Santa Fe'
        ]);

        City::create([
            'zip-code' => '6100',
            'name' => 'Rufino',
            'province' => 'Santa Fe'
        ]);
    }
}
