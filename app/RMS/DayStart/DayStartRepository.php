<?php

/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 6/8/2016
 * Time: 10:22 AM
 */
namespace App\RMS\DayStart;
use Illuminate\Support\Facades\DB;
use App\RMS\DayStart\DayStart;
use App\RMS\Utility;
use App\RMS\ReturnMessage;
class DayStartRepository implements DayStartRepositoryInterface
{
    public function getDayStart()
    {
        $get_daystart       = DayStart::select('id','day_code','start_date','status')
                              ->whereNull('deleted_at')
                              ->get();
        return $get_daystart;
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


    public function delete($id){
        $tempObj = DayStart::find($id);
        $tempObj = Utility::addDeletedBy($tempObj);
        $tempObj->deleted_at = date('Y-m-d H:m:i');
        $tempObj->save();
    }

}