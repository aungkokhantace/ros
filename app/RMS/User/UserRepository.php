<?php

/**
 * Created by PhpStorm.
 * User: User
 * Date: 3/21/2016
 * Time: 3:51 PM
 */
namespace App\RMS\User;

use App\RMS\Kitchen\Kitchen;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\User;
use App\RMS\Role\Role;
use App\Status\StatusConstance;
use Illuminate\Pagination\LengthAwarePaginator;
use App\RMS\ReturnMessage;
use App\RMS\Utility;

class UserRepository implements UserRepositoryInterface
{
    public function store($paramObj)
    {
        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

        try {
            $tempObj        = Utility::addCreatedBy($paramObj);
            $tempObj->save();
            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            return $returnedObj;
        }
        catch(Exception $e){

            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }

    }
    public function updateProfile($paramObj)
    {
        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;
        try{
            $paramObj->save();
            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            return $returnedObj;
        }
        catch(Exception $e){
            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }
    }

    public function getUsers()
    {
        $users = User::all();
        return $users;
    }

    public function getRoles(){
        $roles = Role::all();
        return $roles;
    }

    public function delete_users($id,$deleted_by){
        User::find($id)->delete();
        DB::table('users')->where('id',$id)->update(['deleted_by'=>$deleted_by]);
    }

    public function getID($id){
        $user = User::find($id);
        return $user;
    }

    public function updateWithUserType($id,$name,$userType,$kitchenId,$updated_by)
    {
        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

        try {
            DB::table('users')->where('id',$id)->update(['user_name'=>$name,'role_id'=>$userType,
                'kitchen_id'=>$kitchenId,'updated_by'=>$updated_by]);
            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            return $returnedObj;
        }
        catch(Exception $e){

            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }

    }

    public function update($id,$name,$updated_by){
        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

        try {
            DB::table('users')->where('id',$id)->update(['user_name'=>$name,'updated_by'=>$updated_by]);
            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            return $returnedObj;
        }
        catch(Exception $e){

            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }

    }

    public function changeDisableToEnable($id,$cur){
        DB::table('users')->where('id',$id)->update(['last_activity'=>$cur,'status'=>1]);
    }

    public function changeEnableToDisable($id)
    {
        DB::table('users')->where('id',$id)->update(['status'=>0]);
    }

    public function getIdForStaffId($id){
        $olduser = DB::table('users')->find($id);
        return $olduser;
    }

    public function getUsersForStaffId($id){
        $all = DB::table('users')
                ->select('user_name')
                ->whereNOTIn('id',[$id])
                ->whereNull('deleted_at')
                ->get();
        $user   = array();
        foreach ($all as $key => $a) {
            $user[]         = $a->user_name;
        }
        return $user;
    }

    public function getKitchens()
    {
        $kitchens=Kitchen::get();
        return $kitchens;
    }

    public function active($id) {
        $status     = StatusConstance::USER_AVAILABLE_STATUS;
        $tempObj    = User::find($id);
        $tempObj->status = $status;
        $tempObj->save();
    }

    public function inactive($id) {
        $status     = StatusConstance::USER_UNAVAILABLE_STATUS;
        $tempObj    = User::find($id);
        $tempObj->status = $status;
        $tempObj->save();
    }
}