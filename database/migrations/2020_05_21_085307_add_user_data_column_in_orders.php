<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserDataColumnInOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('guest_first_name')->nullable();
            $table->string('guest_last_name')->nullable();
            $table->string('guest_address')->nullable();
            $table->string('guest_number')->nullable();
            $table->string('guest_floor')->nullable();
            $table->string('guest_department')->nullable();
            $table->string('guest_characteristic')->nullable();
            $table->string('guest_phone')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('guest_first_name');
            $table->dropColumn('guest_last_name');
            $table->dropColumn('guest_address');
            $table->dropColumn('guest_number');
            $table->dropColumn('guest_floor');
            $table->dropColumn('guest_department');
            $table->dropColumn('guest_characteristic');
            $table->dropColumn('guest_phone');
        });
    }
}
