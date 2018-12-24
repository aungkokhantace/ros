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
use App\Status\StatusConstance;
use App\RMS\Utility;
use App\RMS\ReturnMessage;
class DayStartRepository implements DayStartRepositoryInterface
{
    public function getDayStart()
    {
        $status             = StatusConstance::DAY_START_STATUS;
        $get_daystart       = DayStart::select('id','day_code','start_date','status')
                              ->where('status',$status)
                              ->whereNull('deleted_at')
                              ->first();
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

    public function update($paramObj)
    {
        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

        try {
            $tempObj        = Utility::addUpdatedBy($paramObj);
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

    public function getcurrent_dayStart(){
        $restaurant     = Utility::getCurrentRestaurant();
        $branch         = Utility::getCurrentBranch();
        $day_status     = StatusConstance::DAY_STARTING_STATUS;
        $shift_status   = StatusConstance::ORDER_SHIFT_START_STATUS;
        $dayStart       = DayStart::leftjoin('order_shift','order_day.id','=','order_shift.day_id')
                    ->select('order_day.id as day_id','order_shift.shift_id')
                    ->where('order_day.status','=',$day_status)
                    ->where('order_shift.status','=',$shift_status)
                    ->where('order_day.branch_id',$branch)
                    ->where('order_shift.branch_id',$branch)
                    ->first();
        return $dayStart;
    }

}