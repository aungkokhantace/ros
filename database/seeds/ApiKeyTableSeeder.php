<?php

use Illuminate\Database\Seeder;

class ApiKeyTableSeeder extends Seeder
{
   
    public function run()
    {
        DB::table('api_keys')->insert([
            'id' => '1',
            'key' => 'ap1',
            'level'  => '10',
            'ignore_limits'  =>'1'
        ]);
    }
}
