<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSyncsTables extends Migration
{

    public function up()
    {
        Schema::create('syncs_tables', function (Blueprint $table) {
            $table->increments('id');
            $table->string('table_name');
            $table->integer('version');
            $table->integer('active')->default(1);
            //Common to all table ----------------------------------------------
            $table->integer('created_by')->default(1);
            $table->integer('updated_by')->default(1);
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }


    public function down()
    {
        Schema::drop('syncs_tables');
    }
}
