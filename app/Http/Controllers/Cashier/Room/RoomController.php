<?php

namespace App\Http\Controllers\Cashier\Room;

use App\RMS\Infrastructure\Forms\RoomEditRequest;
use App\RMS\Infrastructure\Forms\RoomEntryRequest;
use App\RMS\Room\Room;
use App\RMS\Room\RoomRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
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
        return view('cashier.room.roomList')->with('rooms',$rooms);
    }

    public function create(){ //go to entry form
        return view('cashier.room.room');
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
            return redirect()->action('Cashier\Room\RoomController@index')
                ->withMessage(FormatGenerator::message('Success', 'Room created ...'));
        }
        else{
            return redirect()->action('Cashier\Room\RoomController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Room did not create ...'));
        }

    }

    public function edit($id){//get data by ID and go to edit form
        $room = $this->roomRepository->getRoomById($id);
        return view('cashier.room.room')->with('room',$room);
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
                return redirect()->action('Cashier\Room\RoomController@index')
                    ->withMessage(FormatGenerator::message('Success', 'Room updated ...'));
            }
            else{
                return redirect()->action('Cashier\Room\RoomController@index')
                    ->withMessage(FormatGenerator::message('Fail', 'Room did not update ...'));
            }

        }
        else{
            alert()->warning('Room Name already exists.Please Try Again!')->persistent('Close');
            return back();
        }
    }

    public function delete($ids){//delete room one row or multiple rows
        $id = explode(',', $ids);
        foreach($id as $room_id){
            $this->roomRepository->deleteRoomData($room_id);
        }
        return redirect()->action('Cashier\Room\RoomController@index');
    }


}
