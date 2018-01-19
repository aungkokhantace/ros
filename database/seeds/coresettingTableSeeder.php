<?php

use Illuminate\Database\Seeder;

class coresettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('core_settings')->insert([
            'code' =>'ITEMS',
            'type' => 'ITEMS_TYPE',
            'value' => '1',
            'description' => 'ITEMS code will generate Whent get value 1',
        ]);

        DB::table('core_settings')->insert([
            'code' =>'CAT',
            'type' => 'CATEGORY_TYPE',
            'value' => '2',
            'description' => 'CATEGORY code will generate Whent get value 2',
        ]);

        DB::table('core_settings')->insert([
            'code' =>'ADD_ON',
            'type' => 'ADD_ON_TYPE',
            'value' => '3',
            'description' => 'ADD_ON code will generate Whent get value 3',
        ]);

        DB::table('core_settings')->insert([
            'code' =>'SET_MENU',
            'type' => 'SET_MENU_TYPE',
            'value' => '4',
            'description' => 'SET_MENU code will generate Whent get value 4',
        ]);
    }
}
