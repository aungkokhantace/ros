<?php

namespace App\Http\Controllers\Cashier\Booking;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\RMS\Infrastructure\Forms\BookingRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\RMS\Booking\Booking;
use App\RMS\BookingTable\BookingTable;
use App\RMS\BookingRoom\BookingRoom;
use App\RMS\CheckingBooking;
use Carbon\Carbon;
use App\RMS\Booking\BookingRepositoryInterface;
use App\RMS\Room\Room;
use App\RMS\Table\Table;
use App\RMS\Config\Config;
use App\RMS\FormatGenerator As FormatGenerator;
use App\RMS\ReturnMessage As ReturnMessage;

class BookingController extends Controller
{
	private $tableRepository;
    public function __construct(BookingRepositoryInterface $bookingRepository)
    {
        $this->bookingRepository = $bookingRepository;
    }

    public function index(){

        $bookings           = $this->bookingRepository->getBookinglist();

        $today              = Carbon::now();
        $cur_date           = Carbon::parse($today)->format('Y-m-d');
        
        $table              = Table::all();
        $room               = Room::all();

        $cur_time           = Carbon::parse($today)->format('H:i:s');

        $cur_seconds        = strtotime($cur_time)-strtotime('Today');
        
        $today_bookings     = $this->bookingRepository->getTodayBooking($cur_date);

        $waiting            = [];
        $waiting_time       = Config::select('booking_waiting_time')->first();

        if($waiting_time != ""){
            $waiting_seconds    = strtotime($waiting_time->booking_waiting_time)-strtotime('Today');

            foreach($today_bookings as $today_booking){
                $today_from_time = strtotime($today_booking->from_time)-strtotime('Today');

                if( $cur_seconds >= ($today_from_time + $waiting_seconds && $cur_seconds <= ($today_from_time - $waiting_seconds))){
                    $waiting[] = $today_booking->id;
                }
              
            }
        }
        $booking_table = BookingTable::all();
        $booking_room  = BookingRoom::all();
        return view('cashier.booking.index',compact('bookings','waiting','table','room','boooking_table','booking_room'));
    }

    public function ajaxBookingRequest()
    {
        $today              = Carbon::now();
        $cur_date           = Carbon::parse($today)->format('Y-m-d');

        $bookings           = $this->tableRepository->getBooking($cur_date);
        $table              = Table::all();
        $room               = Room::all();
        $cur_time           = Carbon::parse($today)->format('H:i:s');
        $cur_seconds        = strtotime($cur_time)-strtotime('Today');

        $today_bookings     = $this->bookingRepository->getTodayBooking($cur_date);
        $waiting            = [];
        $waiting_time       = Config::select('booking_waiting_time')->first();
        $waiting_seconds    = strtotime($waiting_time->booking_waiting_time)-strtotime('Today');
        foreach($today_bookings as $today_booking){
            $today_from_time = strtotime($today_booking->from_time)-strtotime('Today');
            if( $cur_seconds < ($today_from_time+$waiting_seconds)){
                $waiting[] = $today_booking->id;
            }
        }
        return view('cashier.booking.bookingListing',compact('bookings','waiting','table','room'))->render();
    }

    public function create(){
        $today              = Carbon::now();
        $cur_date           = Carbon::parse($today)->format('Y-m-d');
 
        return view('cashier.booking.create_booking',compact('today','cur_date'));
    }

    public function search(BookingRequest $request){
        $request->validate();
        $date           = Carbon::parse(Input::get('date'))->format('Y-m-d');
        $from           = Input::get('from_time');

        $from_time      = date("H:i:s", strtotime($from));

        $from_seconds   = strtotime($from_time)-strtotime('Today'); //Change from_time to seconds
    
        $service_time   = Config::select('booking_service_time')->first();
        $service_seconds= strtotime($service_time->booking_service_time)-strtotime('Today');//change seconds
        $total_seconds  = $from_seconds+$service_seconds;
        $to_time        = gmdate('H:i:s',$total_seconds);
        $quantity       = Input::get('quantity');
        $check          = Input::get('check');

        if($check == null){
            $bookinglist = Booking::where('booking_date',$date)->where('from_time','<=',$from_time)->where('to_time','>=',$from_time)->get();
            if(isset($bookinglist) && count($bookinglist) >0){
                $tableIdArr = array();
                $bookingIdArr = array();
                foreach($bookinglist as $booking){
                    array_push($bookingIdArr,$booking->id);
                }

                $bookingTables  = BookingTable::select('table_id')->whereIn('booking_id',$bookingIdArr)->groupBy('table_id')->get();
                foreach($bookingTables as $table){
                    array_push($tableIdArr,$table->table_id);
                }
                $tables = Table::whereNotIn('id',$tableIdArr)->get();
                return view('cashier.booking.booking',compact('tables','date','from','quantity'));
            }else{
                $tables = Table::all();
                return view('cashier.booking.booking',compact('tables','date','from','quantity'));
            }
        }else{
            $bookinglist = Booking::where('booking_date',$date)->where('from_time','<=',$from_time)->where('to_time','>=',$from_time)->get();
            if(isset($bookinglist) && count($bookinglist) >0){
                $roomIdArr = array();
                $bookingIdArr = array();
                foreach($bookinglist as $booking){
                    array_push($bookingIdArr,$booking->id);
                }
                $bookingRooms   = BookingRoom::select('room_id')->whereIn('booking_id',$bookingIdArr)->groupBy('room_id')->get();
                foreach($bookingRooms as $room){
                    array_push($roomIdArr,$room->room_id);
                }
                $rooms = Room::whereNotIn('id',$roomIdArr)->get();
                return view('cashier.booking.booking',compact('rooms','date','from','quantity'));
            }else{
                $rooms = Room::all();
                return view('cashier.booking.booking',compact('rooms','date','from','quantity'));
            }
        }
    }

    public function store(){
       
        $table_id       = Input::get('table_check');
        $room_id        = Input::get('room_check');

        $name           = Input::get('name');
        $capacity       = Input::get('quantity');
        $phone          = Input::get('phone_no');
        $date           = Carbon::parse(Input::get('date'))->format('Y-m-d');
        $from           = Input::get('from_time');

        $from_time      = date("H:i:s", strtotime($from));
        $from_seconds   = strtotime($from_time)-strtotime('Today'); //Change from_time to seconds
    
        $service_time   = Config::select('booking_service_time')->first();
        //change seconds
        $service_seconds= strtotime($service_time->booking_service_time)-strtotime('Today');
 
        $total_seconds = $from_seconds+$service_seconds;
        $to_time = gmdate('H:i:s',$total_seconds);


        $paramObj                   = new Booking();
        $paramObj->customer_name    = $name;
        $paramObj->booking_date     = $date;
        $paramObj->from_time        = $from_time;
        $paramObj->to_time          = $to_time;
        $paramObj->capacity         = $capacity;
        $paramObj->phone            = $phone;

        if(isset($table_id)){
            $result = $this->bookingRepository->saveBooking($paramObj,$table_id);

                if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
                return redirect()->action('Cashier\Booking\BookingController@index')
                    ->withMessage(FormatGenerator::message('Success', 'Booking created ...'));
                }
                else{
                    return redirect()->action('Cashier\Booking\BookingController@index')
                        ->withMessage(FormatGenerator::message('Fail', 'Booking did not create ...'));
                }
        }

        if(isset($room_id)){
            $result = $this->bookingRepository->saveBookingWithRoom($paramObj,$room_id);
            if($result['aceplusStatusCode'] == ReturnMessage::OK){
                return redirect()->action('Cashier\Booking\BookingController@index')
                ->withMessage(FormatGenerator::message('Success','Booking created...'));
            }
            else{
                return redirect()->action('Cashier\Booking\BookingController@index')
                ->withMessage(FormatGenerator::message('Fail','Booking did not create ...'));
            }
        }
    }

    /*
    public function edit($id){
        $booking          = Booking::find($id);
        $tables           = Table::all();
        $rooms            = Room::all();
        $temp             = BookingTable::select('booking_id','table_id')->where('deleted_at','=',NULL)->get();
        $booking_rooms    = array();
        $booking_tables   = array();
        if(isset($temp)){
            foreach($temp as $result){
                if($result->booking_id == $booking->id){
                    $booking_tables[]   = $result->table_id;
                }else{
                    $booking_tables[] = "null";
                }
            }
        }
        
        
        $temp_room        = BookingRoom::select('booking_id','room_id')->where('deleted_at','=',NULL)->get();
        
        if(isset($temp_room)){
            foreach($temp_room as $result){
                if($result->booking_id == $booking->id){
                    $booking_rooms[]     = $result->room_id;
                }else{
                    $booking_rooms[] = "null";
                }
            }
        }
       
        return view('cashier.booking.edit',compact('booking','cur_date','tables','rooms','booking_tables','booking_rooms'));
    }*/

    public function edit($id){
        $booking          = Booking::find($id);
        $temp_table       = BookingTable::select('booking_id','table_id')->where('deleted_at','=',NULL)->get();
        $booking_rooms    = array();
        $booking_tables   = array();
        if(isset($temp_table) && count($temp_table) > 0){
            foreach($temp_table as $result){
                if($result->booking_id == $booking->id){
                    $booking_tables[]   = $result->table_id;
                }
            }
        }

        $temp_room        = BookingRoom::select('booking_id','room_id')->where('deleted_at','=',NULL)->get();

        if(isset($temp_room) && count($temp_room) > 0){
            foreach($temp_room as $result){
                if($result->booking_id == $booking->id){
                    $booking_rooms[]     = $result->room_id;
                }
            }
        }

        $book_id    = $booking->id;
        $book_date  = $booking->booking_date;
        $book_time  = $booking->from_time;
        $bookings = Booking::where('booking_date',$book_date)->where('from_time','<=',$book_time)->where('to_time','>=',$book_time)->where('id','!=',$book_id)->get();
        if(isset($bookings) && count($bookings) >0){

            $tableIdArr     = array();
            $roomIdArr      = array();
            $bookingIdArr   = array();
            foreach($bookings as $book){
                array_push($bookingIdArr,$book->id);
            }
            //Find Available Table
            $bookingTables  = BookingTable::select('table_id')->whereIn('booking_id',$bookingIdArr)->groupBy('table_id')->get();
            foreach($bookingTables as $table){
                array_push($tableIdArr,$table->table_id);
            }
            $tables = Table::whereNotIn('id',$tableIdArr)->get();

            //Find Available Room
            $bookingRooms   = BookingRoom::select('room_id')->whereIn('booking_id',$bookingIdArr)->groupBy('room_id')->get();
            foreach($bookingRooms as $room){
                array_push($roomIdArr,$room->room_id);
            }
            $rooms = Room::whereNotIn('id',$roomIdArr)->get();
        }else{
            $tables = Table::all();
            $rooms  = Room::all();
        }

        return view('cashier.booking.edit_booking',compact('booking','cur_date','tables','rooms','booking_tables','booking_rooms'));
    }

    /*
    public function update(){
        $bid            = Input::get('bid');
        $bname          = Input::get('bname');
        $bdate          = Carbon::parse(Input::get('bdate'))->format('Y-m-d');
        $btable         = Input::get('btable');
        $broom          = Input::get('broom');

        $quantity       = Input::get('bquantity');
        $phone          = Input::get('bphone');
        //change format(eg.00 : 00: PM to 24 hr format)
        $from           = Input::get('bfrom_time');
        $from_time      = date("H:i:s", strtotime($from));
        $from_seconds   = strtotime($from_time)-strtotime('Today'); //Change from_time to seconds

        $to             = Input::get('bto_time');
        $to_time        = date("H:i:s", strtotime($to));
        $to_seconds     = strtotime($to_time)-strtotime('Today');
        //if customer doesn't tell to_time,add booking_service_time from config table as to_time
        $service_time   = Config::select('booking_service_time')->first();

        //change seconds
        $service_seconds = strtotime($service_time->booking_service_time)-strtotime('Today');

        if($to==""){
            $total_seconds = $from_seconds+$service_seconds;
            $to_time = gmdate('H:i:s',$total_seconds);
        }
        
        $tables          = $this->tableRepository->All();
        $rooms           = Room::all();
        $flag1           = 'false';$flag2   = 'false';$flag3    = 'false';
        //$flag = CheckingBooking::checking($tables,$rooms,$flag1,$flag2,$from_seconds,$to_seconds,$to,$btable,$broom,$quantity); // in helpers.php
        if($from_seconds > $to_seconds && $to != ""){
            alert()->warning('To_time should be greater than From_time!')->persistent('Close');
            return back();
        }

        //check booking time already exist or not
        $bookings        = $this->bookingRepository->getBooking($bdate);
        
        if(isset($btable)){
            $b = Booking::find($bid);
            if($bid == $b->id && $b->from_time==$from_time){
                $flag3 ='false';
            }
            else{
            foreach($bookings as $booking){
                foreach($btable as $id){
                    if($booking->table_id == $id && $booking->from_time == $from_time)
                        {
                            $flag3 = 'true';
                        }
                    }
                }
            }
        }

        if(isset($broom)){
            foreach($bookings as $booking){
                foreach($broom as $id){
                    if($booking->room_id == $id && $booking->from_time == $from_time){
                        $flag3 = 'true';
                    }
                }
            }
        }
        if($flag3 == 'true'){
            alert()->warning('Booking already exist!')->persistent('Close');
            return back();
        }
        if( $flag3== 'false'){
            $paramObj                   = Booking::find($bid);
            $paramObj->customer_name    = $bname;
            $paramObj->booking_date     = $bdate;
            $paramObj->from_time        = $from_time;
            $paramObj->to_time          = $to_time;
            $paramObj->capacity         = $quantity;
            $paramObj->phone            = $phone;

             if(isset($btable)){

                 $result                     = $this->bookingRepository->bookingUpdate($paramObj,$btable);

                if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
                return redirect()->action('Cashier\Booking\BookingController@index')
                    ->withMessage(FormatGenerator::message('Success', 'Booking updated ...'));
                }
                else{
                    return redirect()->action('Cashier\Booking\BookingController@index')
                        ->withMessage(FormatGenerator::message('Fail', 'Booking did not update ...'));
                }
            }

            if(isset($broom)){

                $result         = $this->tableRepository->bookingUpdateWithRoom($paramObj,$broom);
                if($result['aceplusStatusCode'] == ReturnMessage::OK){
                    return redirect()->action('Cashier\Booking\BookingController@index')
                    ->withMessage(FormatGenerator::message('Success','Booking updated...'));
                }
                else{
                    return redirect()->action('Cashier\Booking\BookingController@index')
                    ->withMessage(FormatGenerator::message('Fail','Booking did not update ...'));
                }
            }
        }
    }*/

    public function update(){
        $id             = Input::get('id');
        $date           = date('Y-m-d',strtotime(Input::get('date')));
        $capacity       = Input::get('quantity');
        $name           = Input::get('name');
        $phone          = Input::get('phone_no');
        $check          = Input::get('check');
        $table_check    = Input::get('table_check');
        $room_check     = Input::get('room_check');
        $from_time      = date("H:i:s", strtotime(Input::get('from_time')));
        $from_second    = strtotime($from_time)-strtotime('Today'); //Change from_time to seconds
        $service_time   = Config::select('booking_service_time')->first();
        $service_second = strtotime($service_time->booking_service_time)-strtotime('Today');
        $total_seconds  = $from_second+$service_second;
        $to_time        = gmdate('H:i:s',$total_seconds);

        try{
            DB::beginTransaction();
            $booking                    = Booking::find($id);
            $booking->customer_name     = $name;
            $booking->booking_date      = $date;
            $booking->from_time         = $from_time;
            $booking->to_time           = $to_time;
            $booking->capacity          = $capacity;
            $booking->phone             = $phone;
            $booking->save();

            DB::table('booking_table')->where('booking_id',$id)->delete();
            DB::table('booking_room')->where('booking_id',$id)->delete();

            if($check == null){
                foreach($table_check as $table){
                    $booking_table              = new BookingTable();
                    $booking_table->booking_id  = $id;
                    $booking_table->table_id    = $table;
                    $booking_table->save();
                }

            }
            else{
                foreach($room_check as $room){
                    $booking_room               = new BookingRoom();
                    $booking_room->booking_id   = $id;
                    $booking_room->room_id      = $room;
                    $booking_room->save();
                }
            }
            DB::commit();
            return redirect()->action('Cashier\Booking\BookingController@index')->withMessage(FormatGenerator::message('Success', 'Reservation successfully updated! ...'));

        }catch (\Exception $e){
            DB::rollback();
            return redirect()->action('Cashier\Booking\BookingController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Reservation did not update! ...'));
        }

    }


    public function delete($id){
        $new_string = explode(',', $id);
        foreach($new_string as $id){
            $this->bookingRepository->bookingDelete($id);
        }
        return redirect()->action('Cashier\Booking\BookingController@index'); 
    }

    public function checkCapacity($table,$room){
        $table = $table;
        $room  = $room;
        if(isset($table)){
            $count = 0;
            foreach($table as $id){
                $total_table = Table::find($id);
                $t = $total_table->capacity;
            }
            $count += $t;
            return \Response::json($count);
        }

        if(isset($room)){
            $count = 0;
            foreach($room as $id){
                $total_room = Room::find($id);
                $r = $total_room->capacity;
            }
            $count += $r;
            return \Response::json($count);
        }
    }

    public function table_list_view(){
        $tables             = Table::get();
        $before_time        = Config::select('booking_warning_time','booking_waiting_time')->first();
        //quick way of time to seconds
        $config_time        = strtotime($before_time->booking_warning_time)-strtotime('Today');
        $waiting_seconds    = strtotime($before_time->booking_waiting_time)-strtotime('Today');
        $today              = Carbon::now();
        $cur_date           = Carbon::parse($today)->format('Y-m-d');
        $cur_time           = Carbon::parse($today)->format('H:i:s');
        $cur_seconds        = strtotime($cur_time)-strtotime('Today');

        $today_bookings     = $this->bookingRepository->getTodayBooking($cur_date);

        $warning            = [];
        $waiting            = [];

        $waiting_time       = Config::select('booking_waiting_time')->first();
        $waiting_seconds    = strtotime($waiting_time->booking_waiting_time)-strtotime('Today');
        foreach($today_bookings as $today_booking){
            $today_from_time = strtotime($today_booking->from_time)-strtotime('Today');
            
            if( $cur_seconds < ($today_from_time+$waiting_seconds)){
                $waiting[] = $today_booking->table_id;
            }else{
                $waiting[] = null;
            }
        }

       
        foreach($today_bookings as $today_booking){
            $today_from_time = strtotime($today_booking->from_time)-strtotime('Today');
            $diff               = $today_from_time - $config_time;

            if($cur_seconds >= $diff && $cur_seconds <= $today_from_time){
                $warning[] = $today_booking->table_id;
               
            }
        }
        return view('cashier.booking.table_list_view',compact('tables','warning','waiting'));
    }
    public function room_list_view(){
        $rooms              = Room::get();
        $before_time        = Config::select('booking_warning_time','booking_waiting_time')->first();
        //quick way of time to seconds
        $config_time        = strtotime($before_time->booking_warning_time)-strtotime('Today');
        $waiting_seconds    = strtotime($before_time->booking_waiting_time)-strtotime('Today');
        $today              = Carbon::now();
        $cur_date           = Carbon::parse($today)->format('Y-m-d');
        $cur_time           = Carbon::parse($today)->format('H:i:s');
        $cur_seconds        = strtotime($cur_time)-strtotime('Today');
        $today_bookings     = $this->bookingRepository->getTodayBooking($cur_date);
        $warning            = [];
        $waiting            = [];

        $waiting_time       = Config::select('booking_waiting_time')->first();
        $waiting_seconds    = strtotime($waiting_time->booking_waiting_time)-strtotime('Today');
        foreach($today_bookings as $today_booking){
            $today_from_time = strtotime($today_booking->from_time)-strtotime('Today');
            if( $cur_seconds < ($today_from_time+$waiting_seconds)){
                $waiting[] = $today_booking->room_id;
            }else{
                $waiting[] = null;
            }
        }

        foreach($today_bookings as $today_booking){
            $today_from_time = strtotime($today_booking->from_time)-strtotime('Today');
            $diff               = $today_from_time - $config_time;
            if($cur_seconds >= $diff && $cur_seconds <= $today_from_time){
                $warning[] = $today_booking->room_id;
            }
        }
        return view('cashier.booking.room_list_view',compact('rooms','warning','waiting'));
    }

    public function tableRequest()
    {
        $tables             = Table::get();
        $before_time        = Config::select('booking_warning_time','booking_waiting_time')->first();
        $config_time        = strtotime($before_time->booking_warning_time)-strtotime('Today');//quick way of time to seconds
        $waiting_seconds    = strtotime($before_time->booking_waiting_time)-strtotime('Today');
        $today              = Carbon::now();
        $cur_date           = Carbon::parse($today)->format('Y-m-d');
        $cur_time           = Carbon::parse($today)->format('H:i:s');
        $cur_seconds        = strtotime($cur_time)-strtotime('Today');
        $today_bookings     = $this->bookingRepository->getTodayBooking($cur_date);
        $warning            = [];
        $waiting            = [];

        $waiting_time       = Config::select('booking_waiting_time')->first();
        $waiting_seconds    = strtotime($waiting_time->booking_waiting_time)-strtotime('Today');
        foreach($today_bookings as $today_booking){
            $today_from_time = strtotime($today_booking->from_time)-strtotime('Today');
            if( $cur_seconds < ($today_from_time+$waiting_seconds)){
                $waiting[] = $today_booking->table_id;
            }else{
                $waiting[] = null;
            }
        }


        foreach($today_bookings as $today_booking){
            $today_from_time = strtotime($today_booking->from_time)-strtotime('Today');
            $diff               = $today_from_time - $config_time;

            if($cur_seconds >= $diff && $cur_seconds <= $today_from_time){
                $warning[] = $today_booking->table_id;
               
            }
        }
        return view('cashier.booking.tables',compact('tables','warning','waiting'))->render();
    }
    public function roomRequest(){
        $rooms              = Room::get();
        $before_time        = Config::select('booking_warning_time','booking_waiting_time')->first();//quick way of time to seconds
        $config_time        = strtotime($before_time->booking_warning_time)-strtotime('Today');
        $waiting_seconds    = strtotime($before_time->booking_waiting_time)-strtotime('Today');
        $today              = Carbon::now();
        $cur_date           = Carbon::parse($today)->format('Y-m-d');
        $cur_time           = Carbon::parse($today)->format('H:i:s');
        $cur_seconds        = strtotime($cur_time)-strtotime('Today');
        $today_bookings     = $this->bookingRepository->getTodayBooking($cur_date);
        $warning            = [];
        $waiting            = [];

        $waiting_time       = Config::select('booking_waiting_time')->first();
        $waiting_seconds    = strtotime($waiting_time->booking_waiting_time)-strtotime('Today');
        foreach($today_bookings as $today_booking){
            $today_from_time = strtotime($today_booking->from_time)-strtotime('Today');
            if( $cur_seconds < ($today_from_time+$waiting_seconds)){
                $waiting[] = $today_booking->room_id;
            }else{
                $waiting[] = null;
            }
        }


        foreach($today_bookings as $today_booking){
            $today_from_time = strtotime($today_booking->from_time)-strtotime('Today');
            $diff            = $today_from_time - $config_time;
            if($cur_seconds >= $diff && $cur_seconds <= $today_from_time){
                $warning[] = $today_booking->room_id;
            }
        }
        return view('cashier.booking.rooms',compact('rooms','warning','waiting'))->render();
    }

    public function getTables($date,$time){
        $book_date  = date('Y-m-d',strtotime($date));
        $book_time  = date('H:i:s',strtotime($time));
        $bookings = Booking::where('booking_date',$book_date)->where('from_time','<=',$book_time)->where('to_time','>=',$book_time)->get();
        if(isset($bookings) && count($bookings) >0){

            $tableIdArr = array();
            $bookingIdArr = array();
            foreach($bookings as $booking){
                array_push($bookingIdArr,$booking->id);
            }

            $bookingTables  = BookingTable::select('table_id')->whereIn('booking_id',$bookingIdArr)->groupBy('table_id')->get();
            foreach($bookingTables as $table){
                array_push($tableIdArr,$table->table_id);
            }
            $tables = Table::whereNotIn('id',$tableIdArr)->get();
        }else{
            $tables = Table::all();
        }
        return \Response::json($tables);
    }

    public function getRooms($date,$time){
        $book_date  = date('Y-m-d',strtotime($date));
        $book_time  = date('H:i:s',strtotime($time));
        $bookings = Booking::where('booking_date',$book_date)->where('from_time','<=',$book_time)->where('to_time','>=',$book_time)->get();
        if(isset($bookings) && count($bookings) >0){
            $roomIdArr = array();
            $bookingIdArr = array();
            foreach($bookings as $booking){
                array_push($bookingIdArr,$booking->id);
            }
            $bookingRooms   = BookingRoom::select('room_id')->whereIn('booking_id',$bookingIdArr)->groupBy('room_id')->get();
            foreach($bookingRooms as $room){
                array_push($roomIdArr,$room->room_id);
            }
            $rooms = Room::whereNotIn('id',$roomIdArr)->get();
        }else{
            $rooms = Room::all();
        }
        return \Response::json($rooms);
    }
}
