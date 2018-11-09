<?php
namespace App\RMS\Config;

use App\RMS\Config\ConfigRepositoryInterface;
use App\RMS\Config\Config;
use App\RMS\Config\ConfigLog;
use App\RMS\Utility;
use Illuminate\Support\Facades\DB;


class ConfigRepository implements ConfigRepositoryInterface {
    public function find($id){
        $data               = DB::table('config')->find($id);
        return $data;
    }

    public function insert_config($paramObj){
        $tempObj            = Utility::addCreatedBy($paramObj);
        $tempObj->save();       
    }

    public function update_config($paramObj){
        $tempObj            = Utility::addUpdatedBy($paramObj);
        $tempObj->save();
        $this->insert_config_log($tempObj);
    }

    public function getAllConfig(){
        $restaurant  = Utility::getCurrentRestaurant();
        $query         = Config::query();
        $query         = $query->whereNull('deleted_at');
        if($restaurant != null){
            $query     = $query->where('restaurant_id',$restaurant);
        }
        $config       = $query->first(); 
        // $config=DB::table('config')->first();
        return $config;
    }

    public function insert_config_log($tempObj)
    {
        try {
            $paramObj                       = new ConfigLog();
            $paramObj->site_activation_key  = $tempObj->site_activation_key;
            $paramObj->tax                  = $tempObj->tax;
            $paramObj->service              = $tempObj->service;
            $paramObj->room_charge          = $tempObj->room_charge;
            $paramObj->booking_warning_time = $tempObj->booking_warning_time;
            $paramObj->booking_waiting_time = $tempObj->booking_waiting_time;
            $paramObj->booking_service_time = $tempObj->booking_service_time;
            $paramObj->restaurant_name      = $tempObj->restaurant_name;
            $paramObj->logo                 = $tempObj->logo;
            $paramObj->mobile_logo          = $tempObj->mobile_logo;
            $paramObj->mobile_image         = $tempObj->mobile_image;
            $paramObj->email                = $tempObj->email;
            $paramObj->website              = $tempObj->website;
            $paramObj->phone                = $tempObj->phone;
            $paramObj->address              = $tempObj->address;
            $paramObj->message              = $tempObj->message;
            $paramObj->remark               = $tempObj->remark;
            $updateObj                      = Utility::addUpdatedBy($paramObj);
            $updateObj->save();
        } catch(Exception $e){
            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
			return $returnedObj;
        }
    }
}