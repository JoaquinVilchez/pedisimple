<?php

use Illuminate\Database\Seeder;
use App\Address;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Address::create([
            'user_id' => 1,
            'street' => 'Chacabuco',
            'number' => '315',
            'city_id' => 1
            ]);

        Address::create([
            'user_id' => 1,
            'street' => 'Marconi',
            'number' => '688',
            'city_id' => 1
        ]);

        Address::create([
            'user_id' => 2,
            'street' => 'San Luis',
            'number' => '145',
            'city_id' => 2
        ]);

        Address::create([
            'user_id' => 3,
            'street' => 'Laprida',
            'number' => '622',
            'city_id' => 1
        ]);
    }
}
