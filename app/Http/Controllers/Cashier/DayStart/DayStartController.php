<?php

namespace App\Http\Controllers\Cashier\DayStart;

// use App\RMS\Infrastructure\Forms\SetMenuEditRequest;
use App\RMS\Infrastructure\Forms\DayStartInsertRequest;
use App\RMS\DayStart\DayStart;
use App\RMS\Shift\Shift;
use App\RMS\Shift\OrderShift;
use App\RMS\Order\Order;
use App\Status\StatusConstance;
use App\RMS\DayStart\DayStartRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;

use App\RMS\FormatGenerator As FormatGenerator;
use App\RMS\ReturnMessage As ReturnMessage;
use InterventionImage;
class DayStartController extends Controller
{
    private $dayStartRepository;

    public function __construct(DayStartRepositoryInterface $dayStartRepository){
        $this->dayStartRepository = $dayStartRepository;
    }

    public function index(){
        
        $daystart        = $this->dayStartRepository->getDayStart();
        //Default Session Status is Day Start
        $session_status  = StatusConstance::DAY_START_STATUS;
        if (count($daystart) > 0) {
            $day_code        = $daystart->day_code;
            $status          = StatusConstance::SHIFT_AVAILABLE_STATUS;
            $shift_ordering  = DB::select("SELECT id,name,is_last_shift FROM shift WHERE status = '$status' AND deleted_at IS NULL ORDER BY is_last_shift ASC, id ASC");

            $current_shift   = OrderShift::where('day_code','=',$day_code)->whereNull('deleted_at')->get();
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
        } else {
            $daystart       = [];
        }

        //if Step is not day end step
        $shiftObj           = [];
        if (isset($current_step)) {
            $shiftObj                   = $shift_ordering[$current_step];
            $shiftObj->current_status   = $current_status;
            $shiftObj->next_status      = $current_status + 1;
        }

        return view('cashier.daystart.daystart_listing')
                ->with('session_status',$session_status)
                ->with('shiftObj',$shiftObj)
                ->with('daystart',$daystart);
    }

    public function create(){
        $today              = Carbon::now();
        $cur_date           = Carbon::parse($today)->format('Y-m-d');
 
        return view('cashier.daystart.daystart',compact('today','cur_date'));
    }

    public function store(Request $request)
    {
        try {
            $start_date                 = Input::get('start_date');
            $status                     = Input::get('status');
            $date                       = Carbon::parse($start_date)->format('Y-m-d');
            $year                       = Carbon::parse($start_date)->format('Y');
            $month                      = Carbon::parse($start_date)->format('m');
            $day                        = Carbon::parse($start_date)->format('d');
            $day_code                   = "DC_" . $year . $month . $day;

            $paramObj                   = new DayStart();
            $paramObj->day_code         = $day_code;
            $paramObj->start_date       = $date;
            $paramObj->status           = $status;
            $result                     = $this->dayStartRepository->store($paramObj);

            if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
                $data       = array('success'=>'1','error'=>'0');
                return \Response::json($data);
            }
            else{
                $data       = array('success'=>'0','error'=>'1');
                return \Response::json($data);
            }
        } catch (\Exception $e){
            $data       = array('error_msg'=>$e->getMessage());
            return \Response::json($data);
        }

    }

    public function orderShift($day_id,$id,$status) {

        $flag               = 0;
        $order_shift        = OrderShift::where('day_id','=',$day_id)
                            ->where('shift_id','=',$id)
                            ->whereNull('deleted_at')
                            ->first();
        if (count($order_shift) > 0) {
            //Check The last shift or not
            $flag           = 0;
            $lastShiftObj   = Shift::select('is_last_shift')->where('id','=',$order_shift->shift_id)->first();
            if ($lastShiftObj->is_last_shift == 1 AND $status == StatusConstance::ORDER_SHIFT_END_STATUS) {
                //Check all order paid or not
                $order_status       = StatusConstance::ORDER_CREATE_STATUS;
                $orders             = Order::select('id','all_total_amount','order_time','status')
                                      ->where('status','=',$order_status)
                                      ->where('day_id','=',$day_id)
                                      ->get();

                if (count($orders) > 0) {
                    $error_code         = 5;
                    return redirect()->back()->with('error_code',$error_code)->with('orders',$orders);
                } else {
                    $order_shift->status        = $status;
                    $result                 = $this->dayStartRepository->update($order_shift);
                    if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
                        return redirect()->back()->withMessage(FormatGenerator::message('Success', 'Shift updated ...'));
                    }
                    else{
                        return redirect()->back()->withMessage(FormatGenerator::message('Fail', 'Shift did not updated ...'));
                    } 
                }
            } else {
                $orders = Order::where('day_id',$day_id)->where('status',1)->update(['shift_id' => 2]);

                $order_shift->status        = $status;
                $result                 = $this->dayStartRepository->update($order_shift);
                if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
                    return redirect()->back()->withMessage(FormatGenerator::message('Success', 'Shift created ...'));
                }
                else{
                    return redirect()->back()->withMessage(FormatGenerator::message('Fail', 'Shift did not created ...'));
                }
            }
        } else {
            $paramObj               = new OrderShift();
            $paramObj->day_id       = $day_id;
            $paramObj->shift_id     = $id;
            $paramObj->status       = $status;
            $result                 = $this->dayStartRepository->store($paramObj);
            if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
                return redirect()->back()->withMessage(FormatGenerator::message('Success', 'Shift created ...'));
            }
            else{
                $error_code         = 5;
                return redirect()->back()->with('error_code',$error_code)->with('orders',$orders);
            }
        }
    }

    public function dayend($id) {
        $status             = StatusConstance::DAY_END_STATUS;
        //Check All payment have done
        $shift_status       = StatusConstance::SHIFT_AVAILABLE_STATUS;
        $shift_ordering     = Shift::where('status',$shift_status)->whereNull('deleted_at')->get()->count();
        $order_shift        = OrderShift::where('day_id','=',$id)->where('status',2)->whereNull('deleted_at')->get()->count();

        if ($shift_ordering == $order_shift) {
            $paramObj           = DayStart::find($id);
            $paramObj->status   = $status;
            $result             = $this->dayStartRepository->update($paramObj);
            if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
                return redirect()->back()->withMessage(FormatGenerator::message('Success', 'Day End ...'));
            }
        } else {
            alert()->warning('You need to end all shift!')->persistent('Close');
            return redirect()->back();
        }   
    }
}