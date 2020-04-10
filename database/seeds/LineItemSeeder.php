<?php

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
            ['order_id' => 1, 'product_id' => 1, 'quantity' => 3],
            ['order_id' => 1, 'product_id' => 2, 'quantity' => 3],
            ['order_id' => 1, 'product_id' => 5, 'quantity' => 1],
            ['order_id' => 1, 'product_id' => 6, 'quantity' => 1]
        ]);

        DB::table('line_items')->insert([
            ['order_id' => 2, 'product_id' => 10, 'quantity' => 3]
        ]);
    }
}
