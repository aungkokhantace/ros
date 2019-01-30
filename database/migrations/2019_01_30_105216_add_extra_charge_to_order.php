<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExtraChargeToOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order', function (Blueprint $table) {
            $table->integer('extra_charge')->after('over_all_discount_remark')->nullable();
            $table->string('extra_charge_remark')->after('over_all_discount_remark')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order', function (Blueprint $table) {
            $table->dropColumn('extra_charge');
            $table->dropColumn('extra_charge_remark');
        });
    }
}
