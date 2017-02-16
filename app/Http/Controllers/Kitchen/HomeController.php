<?php

namespace App\Http\Controllers\Kitchen;

use App\RMS\Order\OrderRepositoryInterface;
use App\RMS\Orderdetail\Orderdetail;
use App\RMS\Table\Table;
use App\RMS\Addon\Addon;
use App\RMS\SetMenu\SetMenu;
use App\RMS\OrderExtra\OrderExtra;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use Illuminate\Support\Collection as Collection;
use Illuminate\Support\Facades\View;


class HomeController extends Controller
{
	private $orderRepository;
    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->OrderRepository = $orderRepository;
    }

    public function pricesPage(){
    	 $id         = Auth::guard('Cashier')->user()->kitchen_id;

        $orders          = $this->OrderRepository->getKitchenInvoice($id);
        $tables          = $this->OrderRepository->orderTable();
        $rooms           = $this->OrderRepository->orderRoom();
        $extra           = $this->OrderRepository->orderExtra();
        
        $groupedOrders = Collection::make( $orders )->groupBy("order_id" );

    	return view('kitchen.test')->with('groupedOrders',$groupedOrders)->with('tables',$tables)->with('rooms',$rooms)->with('extra',$extra);
    }

    public function pricesValues(){
    	$response = new Symfony\Component\HttpFoundation\StreamedResponse(function(){
    		$old_prices = array();
    		while(true){
    			$new_prices = $this->getKitchenInvoice($id);
    			//$changed_data = $this->getChangedPrices($old_prices,$new_prices);
    			if(count($new_prices)){
    				echo 'data:'.json_encode($new_prices)."\n\n";
    				ob_flush();
    				flush();
    			}
    			sleep(3);
    			$old_prices = $new_prices;
    		}
    	});
    	$response->headers->set('Content-Type','text/event-stream');
    	return $response;
    }

}
