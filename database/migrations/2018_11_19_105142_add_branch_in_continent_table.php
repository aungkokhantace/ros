<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBranchInContinentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('continent', function (Blueprint $table) {
             $table->integer('restaurant_id')->nullable()->after('description');            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::table('continent', function (Blueprint $table) {
           $table->dropColumn('restaurant_id');         
          
        });
    }
}
