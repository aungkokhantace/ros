<?php

use Illuminate\Database\Seeder;

class ContinentTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('continent')->delete();
        
        DB::table('continent')->insert([
            'id'            => '1',
            'name'          => 'Pork',
            'description'   => 'Pork Curry'
        ]);

        DB::table('continent')->insert([
            'id'            => '2',
            'name'          => 'Chicken',
            'description'   => 'Chicken Curry'
        ]);

        DB::table('continent')->insert([
            'id'            => '3',
            'name'          => 'Fish',
            'description'   => 'Fish Curry'
        ]);
    }
}
