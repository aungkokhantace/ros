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
        $discounts   = DiscountLog::get();
        return view('Backend.log.discountlog_listing')
            ->with('discounts',$discounts);
    }
}
