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
            $table->unsignedBigInteger('shop-id');
                $table->foreign('shop-id')->references('id')->on('shops');
            $table->integer('weekday');
            $table->string('start-hour');
            $table->string('end-hour');
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
