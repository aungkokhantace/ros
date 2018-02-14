<?php

namespace App\Http\Controllers\Cashier\DayStart;

// use App\RMS\Infrastructure\Forms\SetMenuEditRequest;
use App\RMS\Infrastructure\Forms\DayStartInsertRequest;
use App\RMS\DayStart\DayStart;
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
        $daystarts       = $this->dayStartRepository->getDayStart();
        return view('cashier.daystart.daystart_listing')
                ->with('daystarts',$daystarts);
    }

    public function create(){
        $today              = Carbon::now();
        $cur_date           = Carbon::parse($today)->format('Y-m-d');
 
        return view('cashier.daystart.daystart',compact('today','cur_date'));
    }

    public function store(DayStartInsertRequest $request)
    {
        $start_date                 = Input::get('start_date');
        $date                       = Carbon::parse($start_date)->format('Y-m-d');
        $year                       = Carbon::parse($start_date)->format('Y');
        $month                      = Carbon::parse($start_date)->format('m');
        $day                        = Carbon::parse($start_date)->format('d');
        $status                     = StatusConstance::DAY_START_STATUS;
        $day_code                   = "DC_" . $year . $month . $day;

        $paramObj                   = new DayStart();
        $paramObj->day_code         = $day_code;
        $paramObj->start_date       = $date;
        $paramObj->status           = $status;
        $result                     = $this->dayStartRepository->store($paramObj);

        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
            return redirect()->action('Cashier\DayStart\DayStartController@index')
                ->withMessage(FormatGenerator::message('Success', 'Day Start created ...'));
        }
        else{
            return redirect()->action('Cashier\DayStart\DayStartController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Day Start did not create ...'));
        }

    }

    public function dayend($id) {
        $status             = StatusConstance::DAY_END_STATUS;
        //Check All payment have done

        $paramObj           = DayStart::find($id);
        $day_code           = $paramObj->day_code;
        $order_status       = StatusConstance::ORDER_CREATE_STATUS;
        $orders             = Order::select('id','all_total_amount','order_time','status')
                              ->where('status','=',$order_status)
                              ->where('day_code','=',$day_code)
                              ->get();
        if (count($orders) > 0) {
            $error_code         = 5;
            return redirect()->back()->with('error_code',$error_code)->with('orders',$orders);
        } else {
            $paramObj->status   = $status;
            $result             = $this->dayStartRepository->update($paramObj);
            if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
                return redirect()->action('Cashier\DayStart\DayStartController@index')
                    ->withMessage(FormatGenerator::message('Success', 'Day End created ...'));
            }
            else{
                return redirect()->action('Cashier\DayStart\DayStartController@index')
                    ->withMessage(FormatGenerator::message('Fail', 'Day End did not create ...'));
            }
        }
    }

    public function delete($id)
    {
        $new_string = explode(',', $id);
        
        foreach($new_string as $id){
            $this->dayStartRepository->delete($id);
        }

        return redirect()->action('Cashier\DayStart\DayStartController@index')
                ->withMessage(FormatGenerator::message('Success', 'Day Start deleted ...'));
    }
}