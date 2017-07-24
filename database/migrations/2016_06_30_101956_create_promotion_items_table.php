<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromotionItemsTable extends Migration
{

    public function up()
    {
        Schema::create('promotion_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('promotion_id');
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
        Schema::drop('promotion_items');
    }
}
