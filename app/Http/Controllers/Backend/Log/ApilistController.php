<?php

namespace App\Http\Controllers\Backend\Log;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\RMS\Pricehistory\PriceLogRepositoryInterface;
use Illuminate\Support\Facades\DB;


class ApilistController extends Controller
{
    public function sync() {
        return view('Backend.log.Syncapi_listing');
    }

    public function make() {
        return view('Backend.log.Makeapi_listing');
    }

    public function down() {
        return view('Backend.log.Downapi_listing');
    }
}
