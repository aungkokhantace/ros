<?php

namespace App\Http\Controllers\Cashier\Log;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\RMS\Config\ConfigLog;


class ConfiglogController extends Controller
{

    public function index() {
        $configs    = ConfigLog::orderBy('id', 'DESC')->get();
        return view('cashier.log.configlog_listing')
            ->with('configs',$configs);
    }
}
