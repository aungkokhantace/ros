<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRestRestaurantANDbranchInAddOnTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('add_on', function (Blueprint $table) {
            $table->integer('restaurant_id')->after('stock_code');
            $table->integer('branch_id')->after('restaurant_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::table('add_on', function (Blueprint $table) {
            $table->dropColumn('restaurant_id');
            $table->dropColumn('branch_id');
        });
    }
}
