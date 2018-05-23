<?php

namespace App\Http\Controllers\Backend\Room;

use App\RMS\Infrastructure\Forms\RoomEditRequest;
use App\RMS\Infrastructure\Forms\RoomEntryRequest;
use App\RMS\Room\Room;
use App\RMS\BookingRoom\BookingRoom;
use App\Status\StatusConstance;
use App\RMS\Room\RoomRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;

use App\RMS\FormatGenerator As FormatGenerator;
use App\RMS\ReturnMessage As ReturnMessage;

class RoomController extends Controller
{
    private $roomRepository;

    public function __construct(RoomRepositoryInterface $roomRepository){
        $this->roomRepository = $roomRepository;
    }

    public function index(){//get all rooms from db
        $rooms = $this->roomRepository->getRooms();
        return view('Backend.room.roomList')->with('rooms',$rooms);
    }

    public function create(){ //go to entry form
        return view('Backend.room.room');
    }
    public function store(RoomEntryRequest $request){//get data and insert into db and then go to room listing page
        $request->validate();
        $name                   = trim(Input::get('room_name'));
        $capacity               = trim(Input::get('capacity'));
        $paramObj               = new Room();
        $paramObj->room_name    = $name;
        $paramObj->capacity     = $capacity;
        $paramObj->status       = 0;
        $result = $this->roomRepository->store($paramObj);

        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
            return redirect()->action('Backend\Room\RoomController@index')
                ->withMessage(FormatGenerator::message('Success', 'Room created ...'));
        }
        else{
            return redirect()->action('Backend\Room\RoomController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Room did not create ...'));
        }

    }

    public function edit($id){//get data by ID and go to edit form
        $room = $this->roomRepository->getRoomById($id);
        return view('Backend.room.room')->with('room',$room);
    }

    public function update(RoomEditRequest $request){//get data from edit form
        $request->validate();
        $id          = Input::get('id');
        $name        = trim(Input::get('room_name'));
        $capacity    = trim(Input::get('capacity'));

        $paramObj               = Room::find($id);
        $paramObj->room_name    = $name;
        $paramObj->capacity     = $capacity;
        //check room name already exist in db
        $rooms       = $this->roomRepository->getRooms();
        $old_room    = $this->roomRepository->getRoomById($id);
        $flag        = 0;
        if($old_room->room_name == $name){
            $flag = 0;
        }
        else{
            foreach($rooms as $room){
                if($room->room_name == $name){
                    $flag = 1;
                }
            }
        }
        if($flag == 0){
            $result = $this->roomRepository->update($paramObj);

            if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
                return redirect()->action('Backend\Room\RoomController@index')
                    ->withMessage(FormatGenerator::message('Success', 'Room updated ...'));
            }
            else{
                return redirect()->action('Backend\Room\RoomController@index')
                    ->withMessage(FormatGenerator::message('Fail', 'Room did not update ...'));
            }

        }
        else{
            alert()->warning('Room Name already exists.Please Try Again!')->persistent('Close');
            return back();
        }
    }

    public function delete($ids){//delete room one row or multiple rows
        $date       = Carbon::today();
        $today      = $date->toDateString();

        $datetime   = Carbon::now();
        $timeStr    = $datetime->toTimeString();

        //Check Table Serve in Booking
        $booking    = BookingRoom::leftjoin('booking','booking_room.booking_id','=','booking.id')
                    ->leftjoin('rooms','booking_room.room_id','=','rooms.id')
                    ->select('rooms.id')
                    ->where('booking.booking_date','>=',$today)
                    ->where('booking.from_time','>',$timeStr)
                    ->get();
        $tempArr    = array();
        foreach($booking as $array) {
            $tempArr[]      = $array->id;
        }

        $id = explode(',', $ids);
        foreach($id as $room_id){
            $room       = Room::find($room_id);
            $status     = $room->status;
            //Check if room is serve
            if ($status == StatusConstance::ROOM_UNAVAILABLE_STATUS) {
                alert()->warning('This room is already Serve.')->persistent('Close');
                return redirect()->back();
            }

            //Check If Room is booking
            if(in_array($room_id, $tempArr)) {
                alert()->warning('This rooms is already Booking.')->persistent('Close');
                return redirect()->back();
            }
            $this->roomRepository->deleteRoomData($room_id);
        }
        return redirect()->action('Backend\Room\RoomController@index')
        ->withMessage(FormatGenerator::message('Success', 'Room deleted success ...'));;
    }

    public function roomenabled($id){
        $new_string = explode(',', $id);
        foreach($new_string as $id){
            $this->roomRepository->roomenabled($id);
        }

        return redirect()->action('Backend\Room\RoomController@index');
    }

    public function active($id)
    {
        $rooms     = $this->roomRepository->room_active($id);
        return redirect()->action('Backend\Room\RoomController@index')
        ->withMessage(FormatGenerator::message('Success', 'Room Active create ...')); //to redirect listing page
    }

    public function inactive($id)
    {
        $get_room      = Room::find($id);
        $room_status   = $get_room->status;
        if ($room_status == 1) {
            alert()->warning('Table is Not Avaiable!')->persistent('Close');
            return back();
        }
        $rooms     = $this->roomRepository->room_inactive($id);
        return redirect()->action('Backend\Room\RoomController@index')
        ->withMessage(FormatGenerator::message('Fail', 'Room Inactive create ...')); //to redirect listing page
    }
}
