<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionTendersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_tenders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('order_id',50);
            $table->Integer('tender_id');
            $table->Integer('qty');
            $table->double('paid_amount')->nullable();
            $table->double('changed_amount')->nullable();
            $table->double('rounding_amount')->nullable();
            $table->tinyInteger('status');
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
        Schema::drop('transaction_tenders');
    }
}
