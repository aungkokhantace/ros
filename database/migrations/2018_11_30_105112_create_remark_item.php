<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRemarkItem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_remark', function (Blueprint $table) {
            // $table->increments('id');
            $table->integer('item_id');
            $table->string('remark_id');          
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });    
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::drop('remark');
    }
}
