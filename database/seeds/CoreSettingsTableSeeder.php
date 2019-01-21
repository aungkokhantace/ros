<?php

use Illuminate\Database\Seeder;

class CoreSettingsTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('core_settings')->delete();

        DB::table('core_settings')->insert([
            'code'          => 'ITEMS',
            'type'          => 'ITEMS_TYPE',
            'value'         => '1',
            'description'   => 'ITEMS code will generate Whent get value 1'
        ]);

        DB::table('core_settings')->insert([
            'code'          => 'CAT',
            'type'          => 'CATEGORY_TYPE',
            'value'         => '2',
            'description'   => 'CATEGORY code will generate Whent get value 2'
        ]);

        DB::table('core_settings')->insert([
            'code'          => 'ADD_ON',
            'type'          => 'ADD_ON_TYPE',
            'value'         => '3',
            'description'   => 'ADD_ON code will generate Whent get value 3'
        ]);

        DB::table('core_settings')->insert([
            'code'          => 'SET_MENU',
            'type'          => 'SET_MENU_TYPE',
            'value'         => '4',
            'description'   => 'SET_MENU code will generate Whent get value 4'
        ]);

        DB::table('core_settings')->insert([
            'code'          => 'Remark',
            'type'          => 'Remark_TYPE',
            'value'         => '5',
            'description'   => 'Remark code will generate Whent get value 4'
        ]);

        DB::table('core_settings')->insert([
            'code'          => 'Continent',
            'type'          => 'Continent_TYPE',
            'value'         => '6',
            'description'   => 'Continent code will generate Whent get value 4'
        ]);
        DB::table('core_settings')->insert([
            'code'          => 'VOUCHER',
            'type'          => 'VOUCHER_TYPE',
            'value'         => '6',
            'description'   => 'VOUCHER ID LENGTH'
        ]);
        DB::table('core_settings')->insert([
            'code'          => 'VOUCHER_PREFIX',
            'type'          => 'VOUCHER_PREFIX TYPE',
            'value'         => 'VOC',
            'description'   => 'VOUCHER ID PREFIX'
        ]);
        DB::table('core_settings')->insert([
            'code'          => 'BI2URL',
            'type'          => 'URL_TYPE',
            'value'         => 'http://gr8.acebi2.com.preview.my-hosting-panel.com',
            'description'   => 'BI2 URL'
        ]);
    }
}
