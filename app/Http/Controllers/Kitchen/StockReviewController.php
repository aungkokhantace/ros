<?php
namespace App\Http\Controllers\Kitchen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;


class StockReviewController extends Controller
{
    private $requestServerURL = 'http://gr8.acebi2.com.preview.my-hosting-panel.com';

    public function index()
    {
        $client = new Client([
          'base_uri' => $this->requestServerURL
        ]);

        $review_url = 'dailybalance/get_dailybalance';
        // $remain_stocks   = json_decode($client->get($review_url)->getBody());

        $remain_stocks = json_decode(json_encode([
            [
              "Id"=>1,
              "BalanceDate"=>"2019-01-02T05:02:04.59",
              "LocationId"=>1,
              "StockId"=>56,
              "Name"=>"chicken spicy curry",
              "OpeningBalance"=>100.00000,
              "CurrentBalance"=>100.00000
            ],
            [
              "Id"=>2,
              "BalanceDate"=>"2019-01-02T05:02:04.59",
              "LocationId"=>1,
              "StockId"=>56,
              "Name"=>"pig spicy curry",
              "OpeningBalance"=>100.00000,
              "CurrentBalance"=>50.00000
            ],
            [
              "Id"=>3,
              "BalanceDate"=>"2019-01-02T05:02:04.59",
              "LocationId"=>1,
              "StockId"=>56,
              "Name"=>"Potato",
              "OpeningBalance"=>100.00000,
              "CurrentBalance"=>10.00000
            ],
            [
              "Id"=>4,
              "BalanceDate"=>"2019-01-02T05:02:04.59",
              "LocationId"=>1,
              "StockId"=>56,
              "Name"=>"Tomato",
              "OpeningBalance"=>100.00000,
              "CurrentBalance"=>30.00000
            ],
            [
              "Id"=>5,
              "BalanceDate"=>"2019-01-02T05:02:04.59",
              "LocationId"=>1,
              "StockId"=>56,
              "Name"=>"Apple",
              "OpeningBalance"=>100.00000,
              "CurrentBalance"=>12.00000
            ],
            [
              "Id"=>6,
              "BalanceDate"=>"2019-01-02T05:02:04.59",
              "LocationId"=>1,
              "StockId"=>56,
              "Name"=>"water",
              "OpeningBalance"=>100.00000,
              "CurrentBalance"=>70.00000
            ]
        ]));

        return view('kitchen/StockReview', compact('remain_stocks'));
    }
}
