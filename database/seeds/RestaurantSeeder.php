<?php

use Illuminate\Database\Seeder;
use App\Restaurant;

class RestaurantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Restaurant::create([
            'name' => 'Pizzeria Italia',
            'description' => 'Desde 2003',
            'slug' => 'pizzeria-italia',
            'phone' => '425339',
            'shipping_price' => 50,
            'delivery' => true,
            'user_id' => 1
        ]);

        Restaurant::create([
            'name' => 'Despensa Mari',
            'description' => 'La despensa mas reconocida del barrio',
            'slug' => 'despensa-mari',
            'phone' => '433967',
            'shipping_price' => 60,
            'delivery' => true,
            'user_id' => 3
        ]);
    }
}
