<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
                $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('restaurant_id');
                $table->foreign('restaurant_id')->references('id')->on('restaurants');
            $table->datetime('ordered');
            $table->datetime('shipped')->nullable();
            $table->string('state');
            $table->string('shipping_method');
            $table->decimal('total', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
