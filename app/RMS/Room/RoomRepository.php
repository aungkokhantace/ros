<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 5/6/2016
 * Time: 10:58 AM
 */

namespace App\RMS\Room;


use App\RMS\Utility;
use Illuminate\Support\Facades\DB;
use App\RMS\ReturnMessage;
use App\Status\StatusConstance;
class RoomRepository implements RoomRepositoryInterface
{
    
     public function getAllRoom(){
        $restaurant          = Utility::getCurrentRestaurant();
        $branch              = Utility::getCurrentBranch();

        $query               = Room::query();
        $query               = $query->whereNull('deleted_at');
        if($restaurant != 0 || $restaurant != null){
            $query           = $query->where('restaurant_id',$restaurant);
        }
        if($branch != 0 || $branch != null){
            $query          = $query->where('branch_id',$branch);
        }
        $tables           = $query->get();
        // $tables = Table::all();

        return $tables;
    }

    public function store($paramObj){
        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

        try {
            $tempObj                = Utility::addCreatedBy($paramObj);
            $tempObj->save();
            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            return $returnedObj;
        }
        catch(Exception $e){

            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }

    }

    public function getRooms(){
        $rooms                  = Room::all();
        return $rooms;
    }

    public function getRoomById($id){
        $room                   = Room::find($id);
        return $room;
    }

    public function update($paramObj){

        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

        try {
            $tempObj                = Utility::addUpdatedBy($paramObj);
            $tempObj->save();
            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            return $returnedObj;
        }
        catch(Exception $e){

            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }


    }

    public function deleteRoomData($room_id){
        $tempObj                = Room::find($room_id);
        $tempObj                = Utility::addDeletedBy($tempObj);
        $tempObj->deleted_at    = date('Y-m-d H:m:i');
        $tempObj->save();
    }

    public function roomenabled($id){
        $room_enable    = StatusConstance::ROOM_AVAILABLE_STATUS;
        DB::table('rooms')
            ->where('id',$id)
            ->update(['status'=>$room_enable]);
    }

    public function room_active($id){
        $status     = StatusConstance::ROOM_ACTIVE_STATUS;
        $tempObj    = Room::find($id);
        $tempObj->active = $status;
        $tempObj->save();
    }

    public function room_inactive($id){
        $status     = StatusConstance::ROOM_INACTIVE_STATUS;
        $tempObj    = Room::find($id);
        $tempObj->active = $status;
        $tempObj->save();
    }

     public function GetAllActiveRoom(){
        $restaurant          = Utility::getCurrentRestaurant();
        $branch              = Utility::getCurrentBranch();

        $query               = Room::query();
        $query               = $query->whereNull('deleted_at');
        if($restaurant != 0 || $restaurant != null){
            $query           = $query->where('restaurant_id',$restaurant);
        }
        if($branch != 0 || $branch != null){
            $query          = $query->where('branch_id',$branch);
        }
        $tables           = $query->get();
        // $tables = Table::all();

        return $tables;
    }

}