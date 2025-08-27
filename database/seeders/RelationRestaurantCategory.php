<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RelationRestaurantCategory extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('relation_restaurant_category')->insert([
            ['restaurant_id' => 1, 'category_restaurant_id' => 1],
            ['restaurant_id' => 1, 'category_restaurant_id' => 2],
            ['restaurant_id' => 2, 'category_restaurant_id' => 5],
            ['restaurant_id' => 2, 'category_restaurant_id' => 2],
        ]);
    }
}
