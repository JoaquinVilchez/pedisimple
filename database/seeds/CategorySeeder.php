<?php

use Illuminate\Database\Seeder;
use App\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'name' => 'Pizzas',
            'restaurant_id' => 1
        ]);

        Category::create([
            'name' => 'Empanadas',
            'restaurant_id' => 1
        ]);

        Category::create([
            'name' => 'Bebidas',
            'restaurant_id' => 1
        ]);

        Category::create([
            'name' => 'Cervezas',
            'restaurant_id' => 2
        ]);

        Category::create([
            'name' => 'Higiene Personal',
            'restaurant_id' => 2
        ]);

        Category::create([
            'name' => 'Golosinas',
            'restaurant_id' => 2
        ]);

        Category::create([
            'name' => 'Almacen',
            'restaurant_id' => 2
        ]);
    }
}
