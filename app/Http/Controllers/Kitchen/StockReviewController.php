<?php
namespace App\Http\Controllers\Kitchen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Auth;
use App\RMS\Kitchen\Kitchen;
use App\RMS\CoreSetting\CoreSetting;

class StockReviewController extends Controller
{
    public function index()
    {
        $coreSetting = new CoreSetting();
        $url = $coreSetting->select('value')->where('code', '=', 'BI2URL')->first();
        $id      = Auth::guard('Cashier')->user()->kitchen_id;
        $kitchen = Kitchen::find($id);
        $client  = new Client([
          'base_uri' => $url->value
        ]);

        $review_url = 'dailybalance/get_dailybalance';
        $remain_stocks   = json_decode($client->get($review_url)->getBody());

        return view('kitchen/StockReview', compact('remain_stocks'))->with('kitchen', $kitchen);
    }
}
