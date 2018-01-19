<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderTablesTable extends Migration
{
    
    public function up()
    {
       Schema::create('order_tables', function (Blueprint $table) {
            $table->integer('id')->increment();
            $table->string('order_id');
            $table->integer('table_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

   
    public function down()
    {
        Schema::drop('order_tables');
    }
}
