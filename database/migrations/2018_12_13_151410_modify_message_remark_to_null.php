<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyMessageRemarkToNull extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('config_log', function (Blueprint $table) {
             $table->string('message')->nullable()->change();
             $table->string('remark')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('config_log', function (Blueprint $table) {
             $table->dropColumn('message');
             $table->dropColumn('remark');
        });
    }
}
