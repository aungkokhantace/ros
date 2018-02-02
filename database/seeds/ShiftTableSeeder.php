<?php

use Illuminate\Database\Seeder;

class ShiftTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('shift')->insert([
            'id'    		=>'1',
            'status' 		=>'1',
            'name' 			=>'DAY SHIFT',
            'description' 	=>'This is day shift',
            'created_by' 	=>'1',
        ]);

        DB::table('shift')->insert([
            'id'    		=>'2',
            'status' 		=>'1',
            'name' 			=>'NIGHT SHIFT',
            'description' 	=>'This is night shift',
            'created_by' 	=>'1',
        ]);
    }
}
