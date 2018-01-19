<?php

/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 6/8/2016
 * Time: 10:22 AM
 */
namespace App\RMS\Kitchen;
use Illuminate\Support\Facades\DB;
use App\RMS\Utility;
use App\RMS\ReturnMessage;
class KitchenRepository implements KitchenRepositoryInterface
{
    public function store($paramObj)
    {
        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

        try {
            $tempObj    = Utility::addCreatedBy($paramObj);
            $tempObj->save();
            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            return $returnedObj;
        }
        catch(Exception $e){

            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }
    }

    public function find($id)
    {
        $data = Kitchen::find($id);
        return $data;
    }

    public function getKitchen(){
        $kitchen = Kitchen::all();
        return $kitchen;

    }

    public function update($paramObj){
        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

        try {
            $tempObj = Utility::addUpdatedBy($paramObj);
            $tempObj->save();
            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            return $returnedObj;
        }
        catch(Exception $e){

            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }
    }

    public function check_category($id){
        $category = DB::table('category')->where('kitchen_id', '=', $id)->where('deleted_at','=',NULL)->first();
        return $category;
    }

    public function check_staff($id){
        $staff = DB::table('users')->where('kitchen_id', '=', $id)->where('deleted_at','=',NULL)->first();
        return $staff;
    }

    public function delete($id){
        $tempObj = Kitchen::find($id);
        $tempObj = Utility::addDeletedBy($tempObj);
        $tempObj->deleted_at = date('Y-m-d H:m:i');
        $tempObj->save();
    }

}