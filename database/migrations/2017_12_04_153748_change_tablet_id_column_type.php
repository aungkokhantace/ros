<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeTabletIdColumnType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tablet_activation', function (Blueprint $table) {
            $table->dropColumn('tablet_id');
        });
        Schema::table('tablet_activation', function (Blueprint $table) {
            $table->string('tablet_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
