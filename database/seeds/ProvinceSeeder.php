<?php

use Illuminate\Database\Seeder;
use App\Province;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Province::create([
            'name' => 'Santa Fe'
        ]);
        Province::create([
            'name' => 'Cordoba'
        ]);
        Province::create([
            'name' => 'Buenos Aires'
        ]);
    }
}
