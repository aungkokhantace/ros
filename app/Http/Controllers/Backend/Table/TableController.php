<?php

namespace App\Http\Controllers\Backend\Table;

use App\RMS\Config\Config;

use App\RMS\Infrastructure\Forms\TableEditRequest;
use App\RMS\Infrastructure\Forms\TableRequest;
use App\RMS\Room\Room;
use App\RMS\Table\Table;
use App\RMS\BookingTable\BookingTable;
use App\RMS\Location\Location;
use App\Status\StatusConstance;
use App\RMS\Table\TableRepositoryInterface;
use App\Http\Requests;
use Auth;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\RMS\Booking\Booking;
use App\RMS\CheckingBooking;

use App\RMS\FormatGenerator As FormatGenerator;
use App\RMS\ReturnMessage As ReturnMessage;

class TableController extends Controller
{
    private $tableRepository;
    public function __construct(TableRepositoryInterface $tableRepository)
    {
        $this->tableRepository = $tableRepository;
    }

    //get table listing view
    public function index()
    {
       $tables = $this->tableRepository->getAllTable();
        return view('Backend.table.tablelisting')->with('tables', $tables);

    }
    public function create(){
        $locations = location::where('deleted_at',NULL)->get();
        
        return view('Backend.table.table')->with('locations',$locations);
    }
    public function All()
    {
         $tables = $this->tableRepository->All();
         return view('cashier.table.tablelisting')->with('tables', $tables);

    }

    //insert table and go to table listing view
    public function store(TableRequest $request)
    {
        $request->validate();
        $name           = Input::get('table_no');
        $capacity       = Input::get('capacity');
        $location       = Input::get('location');
        $area           = Input::get('area');

        $paramObj               = new Table();
        $paramObj->table_no     = $name;
        $paramObj->capacity     = $capacity;
        $paramObj->location_id  = $location;
        $paramObj->area         = $area;

        $result = $this->tableRepository->store($paramObj);

        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
            return redirect()->action('Backend\Table\TableController@index')
                ->withMessage(FormatGenerator::message('Success', 'Table created ...'));
        }
        else{
            return redirect()->action('Backend\Table\TableController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Table did not create ...'));
        }

    }

    //get id to edit and go to edit page
    public function edit($id){
        $tables = $this->tableRepository->table_edit($id);
        $locations = $this->tableRepository->get_locations();
        return view('Backend.table.table')->with('tables', $tables)->with('locations',$locations);

    }

    //delete table one row or multiple row
    public function delete($id)
    {
        $date       = Carbon::today();
        $today      = $date->toDateString();

        $datetime   = Carbon::now();
        $timeStr    = $datetime->toTimeString();

        //Check Table Serve in Booking
        $booking    = BookingTable::leftjoin('booking','booking_table.booking_id','=','booking.id')
                    ->leftjoin('tables','booking_table.table_id','=','tables.id')
                    ->select('tables.id')
                    ->where('booking.booking_date','>=',$today)
                    ->where('booking.from_time','>',$timeStr)
                    ->get();
        $tempArr    = array();
        foreach($booking as $array) {
            $tempArr[]      = $array->id;
        }

        $id_arr     = explode(",", $id);
        foreach($id_arr as $ids) {
            $table      = Table::find($ids);
            $status     = $table->status;
            //Check if table is serve
            if ($status == StatusConstance::TABLE_UNAVAILABLE_STATUS) {
                alert()->warning('This table is already Serve.')->persistent('Close');
                return redirect()->back();
            }
            //Check If table is booking
            if(in_array($ids, $tempArr)) {
                alert()->warning('This table is already Booking.')->persistent('Close');
                return redirect()->back();
            }
            $tables     = $this->tableRepository->table_delete($ids);
        }
        // $table      = Table::find($id);
        return redirect()->action('Backend\Table\TableController@index')->withMessage(FormatGenerator::message('Success', 'Table Deleted...')); //to redirect listing page
    }

    public function active($id)
    {
        $tables     = $this->tableRepository->table_active($id);
        return redirect()->action('Backend\Table\TableController@index')
        ->withMessage(FormatGenerator::message('Success', 'Table Active create ...')); //to redirect listing page
    }

    public function inactive($id)
    {
        $get_table      = Table::find($id);
        $table_status   = $get_table->status;
        if ($table_status == 1) {
            alert()->warning('Table is Not Avaiable!')->persistent('Close');
            return back();
        }
        $tables     = $this->tableRepository->table_inactive($id);
        return redirect()->action('Backend\Table\TableController@index')
        ->withMessage(FormatGenerator::message('Success', 'Table Inactive create ...')); //to redirect listing page
    }

    //get data from edit form
    public function update(TableEditRequest $request)
    {
        $request->validate();
        $id                     = Input::get('id');
        $name                   = Input::get('table_no');
        $lowername              = strtolower($name);
        $capacity               = Input::get('capacity');
        $location               = Input::get('location');
        $area                   = Input::get('area');
        //check table name already exist in db
        $paramObj               = Table::find($id);
        $paramObj->table_no     = $name;
        $paramObj->capacity     = $capacity;
        $paramObj->location_id  = $location;
        $paramObj->area         = $area;
        $oldtable               = $this->tableRepository->table_edit($id);
        $old                    = strtolower($oldtable->table_no);
        $alltables              = $this->tableRepository->All();
        //if true, update table and go to table listing page

        $result = $this->tableRepository->update($paramObj);
        
        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
            return redirect()->action('Backend\Table\TableController@index')
                ->withMessage(FormatGenerator::message('Success', 'Table updated ...'));
        }
        else{
            return redirect()->action('Backend\Table\TableController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Table did not update ...'));
        }
    }

 
    public function table_enabled($id){
        $new_string = explode(',', $id);
        foreach($new_string as $id){
            $this->tableRepository->table_enabled($id);
        }

        return redirect()->action('Backend\Table\TableController@index');
    }
    
    

}
