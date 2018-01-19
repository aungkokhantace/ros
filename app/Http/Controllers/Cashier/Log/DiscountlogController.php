<?php

namespace App\Http\Controllers\Cashier\Log;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\RMS\Discount\DiscountLog;
use App\User;

class DiscountlogController extends Controller
{

    public function index() {
        $discounts   = DiscountLog::get();
        return view('cashier.log.discountlog_listing')
            ->with('discounts',$discounts);
    }
}
