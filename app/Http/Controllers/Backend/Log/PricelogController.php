<?php

namespace App\Http\Controllers\Backend\Log;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\RMS\Pricehistory\PriceLogRepositoryInterface;
use Illuminate\Support\Facades\DB;


class PricelogController extends Controller
{
    private $PriceLogRepository;
    public function __construct(PriceLogRepositoryInterface $PriceLogRepository){
        $this->PriceLogRepository = $PriceLogRepository;
    }

    public function search($type = 'all', $id = 0) {
        $pricehistories = $this->PriceLogRepository->getPricehistory($type,$id);
        return view('Backend.log.pricelog_listing')
            ->with('type',$type)
            ->with('pricehistories',$pricehistories);
    }
}
