<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\RMS\Orderdetail\Orderdetail;
use App\RMS\Order\Order;
use App\RMS\SetMenu\SetMenu;
use App\RMS\Member\Member;
use App\RMS\Item\Item;
use App\RMS\Category\Category;

use App\Status\StatusConstance;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        $member     = Member::all()->count();
        $set        = SetMenu::whereNull('deleted_at')->where('status',1)->count();
        $item       = Item::where('status',1)->where('group_id','')->orWhere('isdefault',1)->count();
        $category   = Category::where('status',1)->count();
        $order_paid_status      = StatusConstance::ORDER_PAID_STATUS;

        $orders = Order::select(DB::raw('DATE_FORMAT(order_time,"%b") as month'),DB::raw('sum(all_total_amount) as total'))
        ->where('order_time','>=',DB::raw('DATE_ADD(now(),INTERVAL - 12 MONTH)'))
        ->where('status',$order_paid_status)->whereYear('order_time','=',date('Y'))
        ->groupBy(DB::raw('MONTH(order_time)'))->get();    
        
        $daily_order = Order::select(DB::raw('DATE(order_time) as date'),DB::raw('sum(all_total_amount) as total'))->groupBy(DB::raw('Day(order_time)'))
        ->whereMonth('order_time','=',date('m'))->whereYear('order_time','=',date('Y'))
        ->where('status',$order_paid_status)->limit(7)->orderBy('date','desc')->get();    
        return view('Backend.dashboard.dashboard')->with('member',$member)
            ->with('set',$set)->with('item',$item)->with('category',$category)->with('orders',$orders)
            ->with('daily_order',$daily_order);
    }
    public function authorized(){
        return view('Backend.error.401');
    }
}
