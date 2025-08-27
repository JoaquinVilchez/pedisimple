<?php

namespace Database\Seeders;


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
            'shipping_method' => 'delivery-pickup',
            'user_id' => 3
        ]);

        Restaurant::create([
            'name' => 'Despensa Mari',
            'description' => 'La despensa mas reconocida del barrio',
            'slug' => 'despensa-mari',
            'phone' => '433967',
            'shipping_price' => 60,
            'shipping_method' => 'delivery',
            'user_id' => 1
        ]);
    }
}
