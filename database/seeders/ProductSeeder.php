<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use App\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::create([
            'name' => 'Empanada de jamon y queso',
            'price' => 35,
            'category_id' => 2,
            'restaurant_id' => 1
        ]);

        Product::create([
            'name' => 'Empanada de carne',
            'price' => 35,
            'category_id' => 2,
            'restaurant_id' => 1
        ]);
        
        Product::create([
            'name' => 'Empanada de verdura',
            'price' => 35,
            'category_id' => 2,
            'restaurant_id' => 1
        ]);

        Product::create([
            'name' => 'Empanada de pollo',
            'price' => 35,
            'category_id' => 2,
            'restaurant_id' => 1
        ]);

        Product::create([
            'name' => 'Pizza Muzzarella 8 porciones',
            'price' => 180,
            'category_id' => 1,
            'restaurant_id' => 1
        ]);

        Product::create([
            'name' => 'Pizza Napolitana 8 porciones',
            'price' => 210,
            'category_id' => 1,
            'restaurant_id' => 1
        ]);

        Product::create([
            'name' => 'Pizza Especial 8 porciones',
            'price' => 210,
            'category_id' => 1,
            'restaurant_id' => 1
        ]);

        Product::create([
            'name' => 'Gaseosa Coca Cola 1,5L',
            'price' => 125,
            'category_id' => 3,
            'restaurant_id' => 1
        ]);
        
        Product::create([
            'name' => 'Gaseosa Sprite 1,5L',
            'price' => 125,
            'category_id' => 3,
            'restaurant_id' => 1
        ]);

        Product::create([
            'name' => 'Cerveza Stella Artois',
            'price' => 180,
            'category_id' => 4,
            'restaurant_id' => 2
        ]);

        Product::create([
            'name' => 'Cerveza Quilmes',
            'price' => 140,
            'category_id' => 4,
            'restaurant_id' => 2
        ]);
    }
}
