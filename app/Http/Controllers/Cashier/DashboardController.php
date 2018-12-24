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
use App\RMS\Shift\OrderShift;
use App\Status\StatusConstance;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\RMS\Utility;

class DashboardController extends Controller
{
    public function dashboard(Request $request)
    {  
    // dd("cashir");

        $sessions        = $this->getDayStart();
        // dd($sessions);
        return view('cashier.dashboard.dashboard')->with('sessions',$sessions);
    }

    protected function getDayStart() 
    {
        $restaurant         = Utility::getCurrentRestaurant();
        $branch             = Utility::getCurrentBranch();

        $session_status     = StatusConstance::DAY_STARTING_STATUS;

        $query              = DayStart::query();

        if($restaurant != 0 || $restaurant != null){
            $query           = $query->where('restaurant_id',$restaurant);
        }
        if($branch != 0 || $branch != null){
            $query          = $query->where('branch_id',$branch);
        }

        $daystart           = $query->select('id','start_date','status')
                              ->where('status',$session_status)
                              ->whereNull('deleted_at')
                              ->first();
        
         /* day was already start */ 
        if (count($daystart) > 0) {
            $day_id          = $daystart->id;
            $status          = StatusConstance::SHIFT_AVAILABLE_STATUS;
            $shift_ordering  = DB::select("SELECT id,name,is_last_shift FROM shift WHERE status = '$status' AND deleted_at IS NULL  AND restaurant_id = '$restaurant' AND branch_id ='$branch' ORDER BY is_last_shift ASC, id ASC");
            // dd($shift_ordering);        

           

            $shift_query    = OrderShift::query();
            if($restaurant  != 0 || $restaurant != null){
                $shift_query = $shift_query->where('restaurant_id',$restaurant);
            }
            if($branch != 0 || $branch != null){
                $shift_query = $shift_query->where('branch_id',$branch);
            }
            $current_shift   = $shift_query->where('day_id','=',$day_id)->whereNull('deleted_at')->get();
            // dd($current_shift);

            /* check shift */
            $current_count   = count($current_shift);
            if ($current_count > 0) {
                $count              = 0;
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
        }
        /* day is not start */ 
        else {
            $get_today              = date('Y-m-d');
            $daystart               = (object) array();
            $daystart->start_date   = $get_today;
            $daystart->status       = StatusConstance::DAY_START_STATUS;
            $daystart->session_status = StatusConstance::DAY_START_STATUS;
            // dd($daystart);
        }
         //if Step is not day end step
        $shiftObj           = [];
        // dd($shift_ordering);
        // var_dump($shift_ordering);
        // dd($shift_ordering);
        // exit();
        if (isset($current_step)) {
            $shiftObj                   = $shift_ordering[$current_step];
            $shiftObj->current_status   = $current_status;
            $shiftObj->next_status      = $current_status + 1;
        }

        //Put all data to object
        $get_day    = (object) array();
        $get_day->daystart    = $daystart;
        $get_day->shift       = $shiftObj;
        // dd($get_day);
        return $get_day;
    }

    public function authorized(){
        return view('cashier.error.401');
    }
}