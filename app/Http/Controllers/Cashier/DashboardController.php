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
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $member     = Member::all()->count();
        $set        = SetMenu::where('status',1)->count();
        $item       = Item::where('status',1)->count();
        $category   = Category::where('status',1)->count();

        $orders = Order::select(DB::raw('DATE_FORMAT(order_time,"%b") as month'),DB::raw('sum(all_total_amount) as total'))
        ->where('order_time','>=',DB::raw('DATE_ADD(now(),INTERVAL - 12 MONTH)'))
        ->where('status',1)->whereYear('order_time','=',date('Y'))
        ->groupBy(DB::raw('MONTH(order_time)'))->get();    

        $daily_order = Order::select(DB::raw('DATE(order_time) as date'),DB::raw('sum(all_total_amount) as total'))->groupBy(DB::raw('Day(order_time)'))
        ->whereMonth('order_time','=',date('m'))->whereYear('order_time','=',date('Y'))
        ->where('status',1)->limit(7)->orderBy('date','desc')->get();    

        return view('cashier.dashboard.dashboard')->with('member',$member)
            ->with('set',$set)->with('item',$item)->with('category',$category)->with('orders',$orders)
            ->with('daily_order',$daily_order);
    }
    public function authorized(){
        return view('cashier.error.401');
    }
}
