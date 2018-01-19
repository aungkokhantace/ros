<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderExtraTables extends Migration
{

    public function up()
    {
        Schema::create('order_extra', function (Blueprint $table) {
            $table->integer('order_detail_id');
            $table->integer('extra_id');
            $table->integer('quantity');
            $table->double('amount');
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }


    public function down()
    {
        Schema::drop('order_extra');
    }
}
