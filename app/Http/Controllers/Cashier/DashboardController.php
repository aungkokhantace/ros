<?php

namespace App\Http\Controllers\Cashier;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\RMS\Orderdetail\Orderdetail;
use App\RMS\Order\Order;
use App\RMS\SetMenu\SetMenu;
use App\RMS\Member\Member;
use App\RMS\Item\Item;
use App\RMS\Category\Category;
use App\RMS\DayStart\DayStart;
use App\RMS\Shift\Shift;
use App\RMS\Location\Location;
use App\RMS\Room\Room;
use App\RMS\Table\Table;
use App\RMS\OrderTable\OrderTable;
use App\RMS\OrderRoom\OrderRoom;
use App\RMS\OrderExtra\OrderExtra;
use App\RMS\Shift\OrderShift;
use App\Status\StatusConstance;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard(Request $request)
    {   
        $orderShift = null; 
        $orderDay = DB::table('order_day')->orderBy('id','desc')->first();
        if(isset($orderDay)){
            $orderShift = DB::table('order_shift')->where('day_id',$orderDay->id)->orderBy('id','desc')->first();
        }        
        
        $hide = 'false';

        if(!$orderShift){
            $hide = 'true';            
        }
        
        $sessions        = $this->getDayStart();
        $locations = Location::all();
        return view('cashier.dashboard.dashboard',compact('sessions','locations','hide'));

    }

    protected function getDayStart() 
    {
        $session_status     = StatusConstance::DAY_STARTING_STATUS;
        $daystart           = DayStart::select('id','start_date','status')
                              ->where('status',$session_status)
                              ->whereNull('deleted_at')
                              ->first();

        if (count($daystart) > 0) {

            $day_id          = $daystart->id;
            $status          = StatusConstance::SHIFT_AVAILABLE_STATUS;
            $shift_ordering  = DB::select("SELECT id,name,is_last_shift FROM shift WHERE status = '$status' AND deleted_at IS NULL ORDER BY is_last_shift ASC, id ASC");
            

            $current_shift   = OrderShift::where('day_id','=',$day_id)->whereNull('deleted_at')->get();
            $current_count   = count($current_shift);
            if ($current_count > 0) {
                $count             = 0;
                foreach($current_shift as $current) {
                    $count          = $count + 1;
                    if ($count == $current_count) {
                        $status                 = $current->status;
                        //Check if Day End Condition
                        if ($current_count == count($shift_ordering) AND $status == StatusConstance::ORDER_SHIFT_END_STATUS) {
                            $session_status         = StatusConstance::DAY_END_STATUS;
                        } else {
                            if ($status == StatusConstance::ORDER_SHIFT_START_STATUS) {
                                // dd('hihihehe');
                                $current_step           = $current_count - 1; //Because shift ordering array key start with 0
                                $current_status         = $status;
                            } else {
                                $current_step           = $current_count; //shift ordering array key start 0, So don't need to increase
                                $current_status         = StatusConstance::ORDER_SHIFT_UNAVAILABLE_STATUS;
                            }
                        }
                    }
                }
            } else {
                $current_step        = 0;
                $current_status      = StatusConstance::ORDER_SHIFT_UNAVAILABLE_STATUS;
            }

            //Add session status to daystar
            $daystart->session_status       = $session_status;
        } else {
            $get_today              = date('Y-m-d');
            $daystart               = (object) array();
            $daystart->start_date   = $get_today;
            $daystart->status       = StatusConstance::DAY_START_STATUS;
            $daystart->session_status = StatusConstance::DAY_START_STATUS;
        }
      
         //if Step is not day end step
        $shiftObj           = [];
        if (isset($current_step)) {
           
            $shiftObj                   = $shift_ordering[$current_step];
            $shiftObj->current_status   = $current_status;
            $shiftObj->next_status      = $current_status + 1;
        }

        //Put all data to object
        $get_day    = (object) array();
        $get_day->daystart    = $daystart;
        $get_day->shift       = $shiftObj;
        return $get_day;
    }

    public function getTable($location_id)
    {   
        $tables = Table::where('location_id',$location_id)->get();
        return json_encode($tables);

    }

    public function getRoom()
    {   
        $rooms = Room::all();
        return json_encode($rooms);
    }

    public function getReport()
    {
        $orderDay = DB::table('order_day')->orderBy('id','desc')->first();
         
        if(!is_null($orderDay) && count($orderDay)>0){
                $orders = Order::where('day_id',$orderDay->id)->get();

        }else{
                $orders                 = [];
        }
        $day = null;
        if(!is_null($orderDay) && count($orderDay)>0){
            $day = \Carbon\Carbon::parse($orderDay->start_date)->format('d-m-Y');
        }

        return view('cashier.invoice.report',compact('orders','day'));

    }

    public function getReportByShift()
    {
        $orderDay = DB::table('order_day')->orderBy('id','desc')->first();
        
        $orderShift = DB::table('order_shift')->where('day_id',$orderDay->id)->orderBy('id','desc')->first();
        
        $hide = 'false';

        if(!$orderShift){
            $hide = true;            
        }
        
        $orderDay = DB::table('order_day')->where('id',$orderShift->day_id)->orderBy('id','desc')->first();

        $orders = Order::where('day_id',$orderDay->id)->where('shift_id',$orderShift->shift_id)->get();
   
        $day = \Carbon\Carbon::parse($orderDay->start_date)->format('d-m-Y');

        return view('cashier.invoice.report',compact('orders','day','hide'));

    }

    public function authorized(){
        return view('cashier.error.401');
    }

    public function dashboardAjax()
    {
        $tables = Table::where('location_id',$location_id)->get();
        return json_encode($tables);
    }
}