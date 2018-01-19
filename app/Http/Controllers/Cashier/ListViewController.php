<?php

namespace App\Http\Controllers\Cashier;

use App\RMS\Infrastructure\Forms\InvoiceListEditRequest;
use App\RMS\Infrastructure\Forms\InvoiceListEntryRequest;
use App\RMS\Order\Order;
use App\RMS\Orderdetail\Orderdetail;
use App\RMS\Orderdetail\OrderdetailRepositoryInterface;
use App\RMS\OrderExtra\OrderExtra;
use App\RMS\OrderRoom\OrderRoom;
use App\RMS\OrderTable\OrderTable;
use App\RMS\SetMenu\SetMenu;
use App\RMS\Item\Item;
use App\RMS\Discount\DiscountModel;
use Session;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

use App\RMS\FormatGenerator As FormatGenerator;
use App\RMS\ReturnMessage As ReturnMessage;
//use App\Session;

class ListViewController extends Controller
{
    public function __construct(OrderdetailRepositoryInterface $detailRepository){
        $this->detailRepository = $detailRepository;

    }

    public function index(){//get all rooms from db
        
        return view('cashier.orderlist.index');
    }
    public function category(){
        $items = $this->detailRepository->getCategories();

        return view('cashier.orderlist.category')->with('items',$items);
    }
    public function setmenu(){
        $setmenus = $this->detailRepository->getsetmenu();
        return view('cashier.orderlist.setmenu')->with('setmenus',$setmenus);
    }
    public function categoryDetail($id){
    	$items = $this->detailRepository->categoryDetail($id);
        
        $table      = $items[0];
        $t          = $table['table'];
        //dd($t);
        if($t == 'category'){
            return view('cashier.orderlist.categorydetail')->with('items',$items)->with('table',$t);
        }else{
            return view('cashier.orderlist.item')->with('items',$items)->with('table',$t);
        }
    	
    }
    public function searchItem($id){
    	$items = $this->detailRepository->searchItem($id);
    	
    	return view('cashier.orderList.item')->with('items',$items);
    }

    public function add($id, $type){
        switch ($type) {
            case 'sm':
                //do set menu things
                $setmenus = $this->detailRepository->getsetmenu();
                $setmenu = SetMenu::find($id);
                $item = array();
                $item['set_id']         = $setmenu->id;
                $item['item_id']        = 0;
                $item['status_id']      = 1;
                $item['set_discount_amount']= 0;
                $item['set_menu_name']  = $setmenu->set_menus_name;
                $item['set_menu_price'] = $setmenu->set_menus_price;
                $item['quantity']       = 1;
                $item['set_amount']     = ($setmenu->set_menus_price) - 0;
                $item['type']           = 'setmenu'; //use to distinguish between setmenu or item
              
                $chosen_item = array();

                if (session('chosen_item')) {
                   
                    $chosen_item = session('chosen_item');
                }

                $chosen_item[]= $item;
                session(['chosen_item'=>$chosen_item]);
                
                return view('cashier.orderlist.setmenu')            
                    ->with('setmenus',$setmenus);
                break;
            
            case 'item':
                //do item things
                $items    = $this->detailRepository->getitem($id);
                $product  = Item::find($id);
                $discount = DiscountModel::where('item_id',$id)->where('deleted_at',NULL)->first();
                $discount_amount = 0;
                if(isset($discount)){
                    $amount             = $discount->amount;
                    $type               = $discount->type;
                    $start              = $discount->start_date;
                    $end                = $discount->end_date;
                    $today              = Carbon::now();
                    $date               = Carbon::parse($today)->format('Y-m-d');

                    if($date > $start && $date < $end){
                        if($type == "%"){
                            $discount_amount = (($product->price)*$type/100);
                        }else{
                            $discount_amount = ($product->price) - ($amount);
                        }
                    }else{
                        $discount_amount = 0;
                    }
                }else{
                    $discount_amount = 0;
                }
                //find item detail here
                $item = array();
                $item['item_id']        = $product->id;
                $item['set_id']         = 0;
                $item['item_name']      = $product->name;
                $item['item_price']     = $product->price;
                $item['item_discount_amount'] = $discount_amount;
                $item['item_quantity']  = 1;
                $item['item_amount']    = ($product->price)-($discount_amount);
                $item['type'] = 'item'; //use to distinguish between setmenu or item

                $chosen_item = array();

                if (session('chosen_item')) {
                   
                    $chosen_item = session('chosen_item');
                }

                $chosen_item[]= $item;

                session(['chosen_item'=>$chosen_item]);
                //dd(session('chosen_item'));
                return view('cashier.orderlist.item')            
                    ->with('items',$items);
                //return your view here
                break;

            default:
                //return error view or raise exception
                break;
        }


        
        
    }
}
