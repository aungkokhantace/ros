<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBranchInBookingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('booking', function (Blueprint $table) {
             $table->integer('restaurant_id')->nullable()->after('phone'); 
             $table->integer('branch_id')->nullable()->after('restaurant_id');            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::table('booking', function (Blueprint $table) {
           $table->dropColumn('restaurant_id');    
           $table->dropColumn('branch_id');     
          
        });
    }
}
