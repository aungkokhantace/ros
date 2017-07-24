<?php
namespace App\RMS\Config;

use App\RMS\Config\ConfigRepositoryInterface;
use App\RMS\Config\Config;
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
    }

    public function getAllConfig(){
        $config=DB::table('config')->first();
        return $config;
    }
}