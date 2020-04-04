<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRelationShopCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relation_shop_category', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('shop-id');
                $table->foreign('shop-id')->references('id')->on('shops');
            $table->unsignedBigInteger('category-shop-id');
                $table->foreign('category-shop-id')->references('id')->on('shop_categories');
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
        Schema::dropIfExists('relation_shop_category');
    }
}
