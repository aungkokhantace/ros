<?php

namespace App\Http\Controllers\Cashier\Log;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\RMS\Pricehistory\PriceLogRepositoryInterface;
use Illuminate\Support\Facades\DB;


class ApilistController extends Controller
{
    public function sync() {
        return view('cashier.log.Syncapi_listing');
    }

    public function make() {
        return view('cashier.log.Makeapi_listing');
    }

    public function down() {
        return view('cashier.log.Downapi_listing');
    }
}
