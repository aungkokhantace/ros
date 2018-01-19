<?php
namespace App\RMS\Pricehistory;

use App\RMS\Utility;
use Illuminate\Support\Facades\DB;
use App\User;

class PriceLogRepository implements PriceLogRepositoryInterface
{
    public function getPricehistory($type,$id){

        $items = DB::table('items')
                 ->select('id','name')
                 ->get();
        $add_ons = DB::table('add_on')
            ->select('id','food_name')
            ->get();

        $set_menus = DB::table('set_menu')
            ->select('id','set_menus_name')
            ->get();

        foreach($items as $item){
            $items[$item->id] = $item;
        }

        foreach($add_ons as $add_on){
            $add_ons[$add_on->id] = $add_on;
        }

        foreach($set_menus as $set_menu){
            $set_menus[$set_menu->id] = $set_menu;
        }

        $priceHistories = array();
        if($type == 'all') {
            $priceHistories = DB::table('setup_price_tracking')
                                ->select('id','table_name','table_id','table_id_type','action','old_price','new_price','created_by','updated_by',
                    'deleted_by','created_at','updated_at','deleted_at')
                                ->ORDERBY ('created_at','DESC')
                                ->get();
        }
        else{
            if($id == 0){
                $priceHistories = DB::table('setup_price_tracking')
                                  ->select('id','table_name','table_id','table_id_type','action','old_price','new_price','created_by','updated_by',
                        'deleted_by','created_at','updated_at','deleted_at')
                                  ->WHERE('table_name','=',$type)
                                  ->get();
            }
            else{
                $priceHistories = DB::table('setup_price_tracking')
                                  ->select('id','table_name','table_id','table_id_type','action','old_price','new_price','created_by','updated_by',
                        'deleted_by','created_at','updated_at','deleted_at')
                                  ->WHERE('table_name','=',$type)
                                  ->WHERE('table_id','=',$id)
                                  ->get();
            }
        }

        if(isset($priceHistories) && count($priceHistories) > 0)
        {
            foreach($priceHistories as $keyPrice => $priceHistorie) {

                if($priceHistorie->table_name == 'items') {
                    $tempName = $items[$priceHistorie->table_id]->name;
                    $priceHistories[$keyPrice]->setup_name = $tempName;
                }
                if($priceHistorie->table_name == 'add_on') {
                    $tempName = $add_ons[$priceHistorie->table_id]->food_name;
                    $priceHistories[$keyPrice]->setup_name = $tempName;
                }
                if($priceHistorie->table_name == 'set_menu') {
                    $tempName = $set_menus[$priceHistorie->table_id]->set_menus_name;
                    $priceHistories[$keyPrice]->setup_name = $tempName;
                }
            }
        }

        return $priceHistories;
    }
}