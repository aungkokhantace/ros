<?php

/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 6/8/2016
 * Time: 10:22 AM
 */
namespace App\RMS\Location;
use Illuminate\Support\Facades\DB;
use App\RMS\Utility;
use App\RMS\ReturnMessage;
use App\RMS\Location\Location;
class LocationRepository implements LocationRepositoryInterface
{
    
    public function get_location(){

        $restaurant          = Utility::getCurrentRestaurant();
        $branch              = Utility::getCurrentBranch();

        $query               = Location::query();
        $query               = $query->whereNull('deleted_at');
        if($restaurant != 0 || $restaurant != null){
            $query           = $query->where('restaurant_id',$restaurant);
        }
        if($branch != 0 || $branch != null){
            $query          = $query->where('branch_id',$branch);
        }
        $location           = $query->get();
        // $tables = Table::all();

        return $location;
    }
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


    public function delete($id){
        $tempObj = Location::find($id);
        $tempObj = Utility::addDeletedBy($tempObj);
        $tempObj->deleted_at = date('Y-m-d H:m:i');
        $tempObj->save();
    }

}