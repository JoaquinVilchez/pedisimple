<?php

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
            'total' => 500
        ]);

        Order::create([
            'user_id' => 2,
            'restaurant_id' => 2,
            'ordered' => Carbon::now(),
            'state' => 'confirmado',
            'shipping_method' => 'delivery',
            'total' => 370
        ]);
    }
}
