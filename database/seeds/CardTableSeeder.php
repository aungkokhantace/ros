<?php

use Illuminate\Database\Seeder;

class CardTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('card')->delete();
        DB::table('card')->insert([
            'id'   => 1,
            'name' =>'MPU'
        ]);

        DB::table('card')->insert([
            'id'   => 2,
            'name' =>'Cash'
        ]);

        DB::table('card')->insert([
            'id'   => 3,
            'name' =>'Master'
        ]);

        DB::table('card')->insert([
            'id'   => 4,
            'name' =>'Credit'
        ]);
    }
}
