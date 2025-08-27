<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LineItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('line_items')->insert([
            ['order_id' => 1, 'product_id' => 1, 'quantity' => 3, 'price' => 150],
            ['order_id' => 1, 'product_id' => 2, 'quantity' => 3, 'price' => 120],
            ['order_id' => 1, 'product_id' => 5, 'quantity' => 1, 'price' => 80],
            ['order_id' => 1, 'product_id' => 6, 'quantity' => 1, 'price' => 90]
        ]);

        DB::table('line_items')->insert([
            ['order_id' => 2, 'product_id' => 10, 'quantity' => 3, 'price' => 200]
        ]);
    }
}
