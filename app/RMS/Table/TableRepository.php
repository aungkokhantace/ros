<?php
namespace App\RMS\Table;

use App\RMS\Booking\Booking;
use App\RMS\BookingTable\BookingTable;
use App\RMS\BookingRoom\BookingRoom;
use App\RMS\Location\Location;
use App\RMS\Utility;
use Illuminate\Support\Facades\DB;
use App\RMS\Table\Table;
use App\Status\StatusConstance;
use App\RMS\ReturnMessage;
class TableRepository implements  TableRepositoryInterface
{
    //get all tables from db for table listing
    public function getAllTable(){
        $restaurant          = Utility::getCurrentRestaurant();
        $branch              = Utility::getCurrentBranch();

        $query               = Table::query();
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

    public function All(){
        $tables = Table::get();

        return $tables;
    }

    public function store($paramObj){

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

    public function table_delete($id){
        $tempObj = Table::find($id);
        $tempObj = Utility::addDeletedBy($tempObj);
        $tempObj->deleted_at = date('Y-m-d H:m:i');

        $tempObj->save();
    }

    public function table_active($id){
        $status     = StatusConstance::TABLE_ACTIVE_STATUS;
        $tempObj = Table::find($id);
        $tempObj->active = $status;

        $tempObj->save();
    }

    public function table_inactive($id){
        $status     = StatusConstance::TABLE_INACTIVE_STATUS;
        $tempObj = Table::find($id);
        $tempObj->active = $status;

        $tempObj->save();
    }
    

    public function table_edit($id){
        $tables=DB::table('tables')->find($id);

        return $tables;
    }

    public function update($paramObj){

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

    public function saveBooking($paramObj,$table_id){       
        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

        try {
            $tempObj = Utility::addCreatedBy($paramObj);
            $tempObj->save();
            $id      = $paramObj->id;
            
                foreach($table_id as $table){
                    // DB::table('booking_table')->insert([
                    //             ['booking_id' => $id, 'table_id' => $table]
                    //         ]);
                    $paramObj               = new BookingTable();
                    $paramObj->booking_id   = $id;
                    $paramObj->table_id     = $table;
                    $Obj                    = Utility::addCreatedBy($paramObj);
                    $Obj->save();
                }
    
            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            return $returnedObj;
        }
        catch(Exception $e){
            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }
    }

    public function saveBookingWithRoom($paramObj,$room_id){
        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

        try {
            $tempObj = Utility::addCreatedBy($paramObj);
            $tempObj->save();
            $id      = $paramObj->id;
            
                foreach($room_id as $room){
                    
                    // DB::table('booking_room')->insert([
                    //             ['booking_id' => $id, 'room_id' => $room]
                    //         ]);
                    $paramObj               = new BookingRoom;
                    $paramObj->booking_id   = $id;
                    $paramObj->room_id      = $room;
                    $Obj                    = Utility::addCreatedBy($paramObj);
                    $Obj->save();
                }
    
            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            return $returnedObj;
        }
        catch(Exception $e){
            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }
    }

    public function getTodayBooking($cur_date){
      
        $cur_bookings = Booking::leftjoin('booking_table','booking_table.booking_id','=','booking.id')
        ->leftjoin('booking_room','booking_room.booking_id','=','booking.id')
        ->select('booking.*','booking_table.table_id','booking_room.room_id')->where('booking.booking_date','=',$cur_date)->get();

        return $cur_bookings;
    }

    public function getBooking($cur_date){
        $bookings = Booking::leftjoin('booking_table','booking_table.booking_id','=','booking.id')
        ->leftjoin('booking_room','booking_room.booking_id','=','booking.id')
        ->select('booking.*','booking_table.table_id','booking_room.room_id')->where('booking.booking_date','=',$cur_date)->get();
        
        return $bookings;
    }

    public function getBookinglist($cur_date){
        $bookings = Booking::where('booking.booking_date','=',$cur_date)->get();
        return $bookings;
    }

    public function getBookings($cur_date){
        $bookings = Booking::select('id','customer_name','booking_date','from_time','to_time','capacity','phone','created_by','updated_by','deleted_by','created_at','updated_at','deleted_at')
                        ->where('booking_date','>=',$cur_date)
                        ->orderBy('booking_date')
                        ->get();

       return $bookings;
    }


    

    public function bookingUpdate($paramObj,$btable){
        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

        try {
            $tempObj = Utility::addUpdatedBy($paramObj);
            $tempObj->save();
            $id      = $paramObj->id;
            BookingTable::where('booking_id',$id)->delete();
                foreach($btable as $table){
                    
                    DB::table('booking_table')->insert([
                                ['booking_id' => $id, 'table_id' => $table]
                            ]);
                }
    
            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            return $returnedObj;
        }
        catch(Exception $e){
            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }
    }

    public function bookingUpdateWithRoom($paramObj,$broom){
        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

        try{
            $tempObj  = Utility::addUpdatedBy($paramObj);
            $tempObj->save();
            $id = $paramObj->id;
            BookingRoom::where('booking_id',$id)->delete();
            foreach($broom as $room){
                DB::table('booking_room')->insert([
                        ['booking_id' => $id, 'room_id' => $room]
                 ]);
            }
        
            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            return $returnedObj;
        }
        catch(Exception $e){
            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }
    }

    public function bookingDelete($id){
        
        $tempObj                = Booking::find($id);
        $tempObj                = Utility::addDeletedBy($tempObj);
        $tempObj->deleted_at    = date('Y-m-d H:m:i');
        $tempObj->save();

    }

    public function get_locations(){

        $tempObj    = Location::all();
        return $tempObj;
    }

    public function table_enabled($id){
        $table_enable    = StatusConstance::TABLE_AVAILABLE_STATUS;
        DB::table('tables')
            ->where('id',$id)
            ->update(['status'=>$table_enable]);
    }

    public function get_locationbyBranch($branch_id,$restaurant_id){
        $location           = Location::where('branch_id',$branch_id)->where('restaurant_id',$restaurant_id)->whereNull('deleted_at')->get();
        return $location;
    }

    public function getAllActiveTable(){
        $restaurant          = Utility::getCurrentRestaurant();
        $branch              = Utility::getCurrentBranch();

        $query               = Table::query();
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