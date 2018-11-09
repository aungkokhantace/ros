<?php
namespace App\RMS\Profile;

use App\RMS\Utility;
use Illuminate\Support\Facades\DB;
use App\RMS\Config\Config;

class ProfileRepository implements ProfileRepositoryInterface
{
    public function All(){
        $profile        = Profile::get();
        return $profile;
    }

    public function getAllProfile(){
        $restaurant    = Utility::getCurrentRestaurant();
        $query         = Config::query();
        $query         = $query->whereNull('deleted_at');
        if($restaurant != null){
            $query     = $query->where('restaurant_id',$restaurant);
        }
        $profile       = $query->first(); 

        // dd("aa",$profile);
        return $profile;
    }
    
    public function saveall($paramObj){
        $tempObj        = Utility::addCreatedBy($paramObj);
        $tempObj->save();
    }

    public function savelogo($paramObj){
        $tempObj        = Utility::addCreatedBy($paramObj);
        $tempObj->save();
    }

    public function savemobilelogo($paramObj){
        $tempObj        = Utility::addCreatedBy($paramObj);
        $tempObj->save();
    }

    public function save($paramObj){
        $tempObj        = Utility::addCreatedBy($paramObj);
        $tempObj->save();
    }

    public function updateAll($paramObj){
        $tempObj        = Utility::addUpdatedBy($paramObj);
        $tempObj->save();
    }

    public function updatelogo($paramObj){
        $tempObj        = Utility::addUpdatedBy($paramObj);
        $tempObj->save();
    }

    public function updatemobilelogo($paramObj){
        $tempObj        = Utility::addUpdatedBy($paramObj);
        $tempObj->save();
    }

    public function update($paramObj){
        $tempObj        = Utility::addUpdatedBy($paramObj);
        $tempObj->save();
    }
}