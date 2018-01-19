<?php
namespace App\RMS\Profile;

use App\RMS\Utility;
use Illuminate\Support\Facades\DB;

class ProfileRepository implements ProfileRepositoryInterface
{
    public function All(){
        $profile        = Profile::get();
        return $profile;
    }

    public function getAllProfile(){
        $profile        = DB::table('config')->first();
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