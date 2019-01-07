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
        $remain_stocks   = json_decode($client->get($review_url)->getBody());

        return view('kitchen/StockReview', compact('remain_stocks'));
    }
}
