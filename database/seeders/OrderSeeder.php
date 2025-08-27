<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use App\Order;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Order::create([
            'user_id' => 1,
            'restaurant_id' => 1,
            'ordered' => Carbon::now(),
            'state' => 'entregado',
            'shipping_method' => 'delivery',
            'delivery' => 0,
            'subtotal' => 500,
            'total' => 500,
            'code' => 'ORD001'
        ]);

        Order::create([
            'user_id' => 2,
            'restaurant_id' => 2,
            'ordered' => Carbon::now(),
            'state' => 'confirmado',
            'shipping_method' => 'delivery',
            'delivery' => 0,
            'subtotal' => 370,
            'total' => 370,
            'code' => 'ORD002'
        ]);
    }
}
