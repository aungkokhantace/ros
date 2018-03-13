<?php

use Illuminate\Database\Seeder;

class ContinentTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('continent')->delete();
        
        DB::table('continent')->insert([
            'name'          => 'Pork',
            'description'   => 'Pork Curry'
        ]);

        DB::table('continent')->insert([
            'name'          => 'Chicken',
            'description'   => 'Chicken Curry'
        ]);

        DB::table('continent')->insert([
            'name'          => 'Fish',
            'description'   => 'Fish Curry'
        ]);
    }
}
