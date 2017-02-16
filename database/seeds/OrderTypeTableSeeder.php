<?php

use Illuminate\Database\Seeder;

class OrderTypeTableSeeder extends Seeder
{
    
    public function run()
    {
        DB::table('order_type')->insert([
            'id' => '1',
            'type'  => 'Eat',
            
        ]);

        DB::table('order_type')->insert([
        	'id' =>'2',
        	'type'=>'Parcek',
        ])
    }
}
