<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddKitchenCodeToKitchenSetupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kitchen', function (Blueprint $table) {
            $table->string('kitchen_code')->after('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kitchen', function (Blueprint $table) {
            $table->dropColumn('kitchen_code');
        });
    }
}
