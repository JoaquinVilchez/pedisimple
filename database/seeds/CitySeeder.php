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
            'zip_code' => '2600',
            'name' => 'Venado Tuerto',
            'province_id' => 1
        ]);
    }
}
