<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMinimumMaximumColumnsInProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->integer('minimum_variants')->nullable()->after('variants');
            $table->integer('maximum_variants')->nullable()->after('minimum_variants');
            $table->dropColumn('limit_variants');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('minimum_variants');
            $table->dropColumn('maximum_variants');
            $table->dropColumn('limit_variants');
        });
    }
}
