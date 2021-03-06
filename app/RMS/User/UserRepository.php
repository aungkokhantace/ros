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
use Illuminate\Pagination\LengthAwarePaginator;
use App\RMS\ReturnMessage;
use App\RMS\Utility;

class UserRepository implements UserRepositoryInterface
{
    public function store($name,$staffId,$password,$roleId,$kitchenId,$id)
    {
        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

        try {
            DB::table('users')->insert(['user_name'=>$name,'staff_id'=>$staffId,'password'=>$password,'role_id'=>$roleId,
                'kitchen_id'=>$kitchenId,'created_by'=>$id]);
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

    public function updateWithUserType($id,$name,$staffId,$userType,$kitchenId,$updated_by)
    {
        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

        try {
            DB::table('users')->where('id',$id)->update(['user_name'=>$name,'staff_id'=>$staffId,'role_id'=>$userType,
                'kitchen_id'=>$kitchenId,'updated_by'=>$updated_by]);
            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            return $returnedObj;
        }
        catch(Exception $e){

            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }

    }

    public function update($id,$name,$staffId,$updated_by){
        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

        try {
            DB::table('users')->where('id',$id)->update(['user_name'=>$name,'staff_id'=>$staffId,'updated_by'=>$updated_by]);
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

    public function getUsersForStaffId(){
        $all = DB::table('users')->get();
        return $all;
    }

    public function getKitchens()
    {
        $kitchens=Kitchen::get();
        return $kitchens;
    }
}