<?php

namespace App\Http\Controllers\Cashier\Invoice;

use App\RMS\Order\OrderRepositoryInterface;
use App\RMS\Table\Table;
use App\RMS\Addon\Addon;
use App\RMS\OrderExtra\OrderExtra;
use App\RMS\SetMenu\SetMenu;
use App\RMS\Orderdetail\Orderdetail;
use App\RMS\OrderTable\OrderTable;
use App\RMS\OrderRoom\OrderRoom;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Status\StatusConstance;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Collection as Collection;

class OrderViewController extends Controller

{
    private $orderRepository;
    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->OrderRepository = $orderRepository;
    }

    public function index(){
        $orders = $this->OrderRepository->getVoucher();
        $tables = $this->OrderRepository->orderTable();
        $rooms  = $this->OrderRepository->orderRoom(); 
        //Order Detail Status
        $order_detail_cooking_status       = StatusConstance::ORDER_DETAIL_COOKING_STATUS;
        $order_detail_cooked_status        = StatusConstance::ORDER_DETAIL_COOKED_STATUS;
        $order_detail_cooking_done_status  = StatusConstance::ORDER_DETAIL_COOKING_DONE_STATUS;
        // dd($orders);   
        $groupedOrders = Collection::make($orders)->groupBy("order_id","order_status")->filter(function($orderDetails)
        {
            foreach($orderDetails as $detail)
            {
                if($detail->order_status == 1 or $detail->order_status == 2 or $detail->order_status == 3 or $detail->order_status == 4){
                    continue;
                }else
                return false;
            }
            return true;
        });
        $count_start    = 0;
        $count_cooking  = 0;
        $count_cooked   = 0;
        $count_taken    = 0;
        $order_arr      = array();
        $orderValue     = array();
        foreach($groupedOrders as $groupKey=>$groupValue){

            foreach($groupValue as $value){
                $setmenu_id         = $value->setmenu_id;
                if($value->order_id == $groupKey && $value->order_status == 1){
                    $count_start += 1;
                }
                if($value->order_id == $groupKey && $value->order_status == 2){
                    $count_cooking += 1;
                }
                if($value->order_id == $groupKey && $value->order_status == 3){
                    $count_cooked += 1;
                }
                if($value->order_id == $groupKey && $value->order_status == 4){
                    $count_taken += 1;
                }
                $orderValue['order_id']     = $value->order_id;
                $orderValue['order_type']   = $value->order_type;
                $orderValue['take_id']      = $value->take_id;
                $orderValue['status']       = $value->status;
            }
            $orderValue['count_start']      = $count_start;
            $orderValue['count_cooking']    = $count_cooking;
            $orderValue['count_cooked']     = $count_cooked;
            $orderValue['count_taken']      = $count_taken;

            
            $order_arr[$groupKey]   = $orderValue;
            $count_start            = 0;
            $count_cooking          = 0;
            $count_cooked           = 0;
            $count_taken            = 0;
        }
       return view('cashier.foodorderlist.kitchen_view')->with('groupedOrders',$order_arr)->with('tables',$tables)->with('rooms',$rooms);
    }

    public function ajaxRequest(Request $request)
    {
        $orders = $this->OrderRepository->getVoucher();
        $tables = $this->OrderRepository->orderTable();
        $rooms  = $this->OrderRepository->orderRoom();

        $groupedOrders = Collection::make($orders)->groupBy("order_id")
        ->filter(function($orderDetails)
        {
            foreach($orderDetails as $detail)
            {
                if($detail->order_status == 1 or $detail->order_status == 2 or $detail->order_status == 3 or $detail->order_status == 4){
                    continue;
                }else
                return false;
            }
            return true;
        });
        $count_start    = 0;
        $count_cooking  = 0;
        $count_cooked   = 0;
        $count_taken    = 0;
        $order_arr      = array();
        $orderValue     = array();
        foreach($groupedOrders as $groupKey=>$groupValue){

            foreach($groupValue as $value){
                if($value->order_id == $groupKey && $value->order_status == 1){
                    $count_start += 1;
                }
                if($value->order_id == $groupKey && $value->order_status == 2){
                    $count_cooking += 1;
                }
                if($value->order_id == $groupKey && $value->order_status == 3){
                    $count_cooked += 1;
                }
                if($value->order_id == $groupKey && $value->order_status == 4){
                    $count_taken += 1;
                }
                $orderValue['order_id']     = $value->order_id;
                $orderValue['order_type']   = $value->order_type;
                $orderValue['take_id']      = $value->take_id;
            }
            $orderValue['count_start']      = $count_start;
            $orderValue['count_cooking']    = $count_cooking;
            $orderValue['count_cooked']     = $count_cooked;
            $orderValue['count_taken']      = $count_taken;
            $orderValue['status']           = $value->status;

            $order_arr[$groupKey]   = $orderValue;
            $count_start            = 0;
            $count_cooking          = 0;
            $count_cooked           = 0;
            $count_taken            = 0;
        }
        return view('cashier.foodorderlist.real_time_kitchen_view')->with('groupedOrders',$order_arr)->with('tables',$tables)->with('rooms',$rooms);
    }

    public function detail($order_id,$order_status){

        $orders =$this->OrderRepository->getFoodListDetail($order_id,$order_status);

        return \Response::json($orders);
    }
    

}
