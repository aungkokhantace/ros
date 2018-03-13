<?php

use Illuminate\Database\Seeder;

class StatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('status')->delete();
        
        DB::table('status')->insert([
            'id'    =>'1',
            'stname' =>'Order',
        ]);
        DB::table('status')->insert([
            'id' =>'2',
            'stname' =>'Processing',
        ]);
        DB::table('status')->insert([
            'id' => '3',
            'stname' =>'Cooked',
        ]);
        DB::table('status')->insert([
            'id' => '4',
            'stname' =>'Delievered',
        ]);
        DB::table('status')->insert([
            'id' => '5',
            'stname' =>'Completed',
        ]);
        DB::table('status')->insert([
            'id' => '6',
            'stname' =>'Kitchen Cancel',
        ]);
        DB::table('status')->insert([
            'id'=>'7',
            'stname' =>'Customer Cancel',
        ]);
    }
}
