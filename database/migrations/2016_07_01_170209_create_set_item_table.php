<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSetItemTable extends Migration
{

    public function up()
    {
        Schema::create('set_item', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('set_menu_id');
            $table->integer('item_id');
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::drop('set_item');
    }
}
