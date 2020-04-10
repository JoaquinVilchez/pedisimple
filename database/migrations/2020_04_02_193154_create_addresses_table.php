<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('street');
            $table->string('number');
            $table->string('floor')->nullable();
            $table->string('department')->nullable();
            $table->string('building_name')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
                $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('restaurant_id')->nullable();
                $table->foreign('restaurant_id')->references('id')->on('restaurants');
            $table->unsignedBigInteger('city_id');
                $table->foreign('city_id')->references('id')->on('cities');
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
        Schema::dropIfExists('addresses');
    }
}
