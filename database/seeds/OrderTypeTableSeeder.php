<?php

use Illuminate\Database\Seeder;

class OrderTypeTableSeeder extends Seeder
{
    
    public function run()
    {
        DB::table('order_type')->delete();
        
        DB::table('order_type')->insert([
            'id' => '1',
            'type'  => 'Dine in',
            
        ]);

        DB::table('order_type')->insert([
        	'id' =>'2',
        	'type'=>'Parcel',
        ]);
    }
}
