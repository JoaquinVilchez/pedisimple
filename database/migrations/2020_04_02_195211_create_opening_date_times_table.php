<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOpeningDateTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opening_date_times', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('restaurant_id');
                $table->foreign('restaurant_id')->references('id')->on('restaurants');
            $table->integer('weekday');
            $table->time('start_hour_1')->nullable();
            $table->time('end_hour_1')->nullable();
            $table->time('start_hour_2')->nullable();
            $table->time('end_hour_2')->nullable();
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
        Schema::dropIfExists('opening_date_times');
    }
}
