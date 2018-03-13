<?php

namespace App\Http\Controllers\Backend\Log;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\RMS\Discount\DiscountLog;
use App\User;

class DiscountlogController extends Controller
{

    public function index() {
        // $discounts   = DiscountLog::get();
        $discounts 		= DiscountLog::leftjoin('items','discount_log.item_id','=','items.id')
        				->select('discount_log.name','discount_log.amount','discount_log.type','discount_log.start_date','discount_log.end_date','discount_log.created_by','discount_log.updated_by',
        					'discount_log.deleted_by','discount_log.deleted_by','items.name as item_name')
        				->get();
        $users 			= User::get();
        return view('Backend.log.discountlog_listing')
            ->with('users',$users)
            ->with('discounts',$discounts);
    }
}
