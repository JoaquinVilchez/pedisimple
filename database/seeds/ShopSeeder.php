<?php

use Illuminate\Database\Seeder;
use App\Shop;

class ShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Shop::create([
            'name' => 'Pizzeria Italia',
            'description' => 'Desde 2003',
            'slug' => 'pizzeria-italia',
            'phone' => '425339',
            'shipping-price' => 50,
            'delivery' => true,
            'user-id' => 1
        ]);

        Shop::create([
            'name' => 'Despensa Mari',
            'description' => 'La despensa mas reconocida del barrio',
            'slug' => 'despensa-mari',
            'phone' => '433967',
            'shipping-price' => 60,
            'delivery' => true,
            'user-id' => 3
        ]);
    }
}
