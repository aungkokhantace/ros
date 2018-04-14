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
use App\RMS\Addon\Addon;
use App\RMS\Table\Table;
use App\RMS\Discount\DiscountModel;
use App\RMS\Item\Continent;
use App\RMS\Category\Category;
use App\RMS\Config\Config;
use App\RMS\DayStart\DayStart;
use App\RMS\Shift\ShiftCategory;
use App\Status\StatusConstance;
use Auth;
use Session;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
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

    public function takeAway() {
        $day_status     = StatusConstance::DAY_STARTING_STATUS;
        $shift_status   = StatusConstance::ORDER_SHIFT_START_STATUS;
        $dayStart = DayStart::leftjoin('order_shift','order_day.id','=','order_shift.day_id')
                    ->select('order_day.id as day_id','order_shift.shift_id')
                    ->where('order_day.status','=',$day_status)
                    ->where('order_shift.status','=',$shift_status)
                    ->first();
        $config             = Config::select('tax','service','room_charge')->first();
        $take_id            = 1;//1 For 
        if (count($dayStart) > 0) {
            $day_id     = $dayStart->day_id;
            $shift_id   = $dayStart->shift_id;
            return view('cashier.orderlist.order')
                    ->with('config',$config)
                    ->with('day_id',$day_id)
                    ->with('take_id',$take_id)
                    ->with('shift_id',$shift_id);
        } else {
            return redirect()->back()
                ->withMessage(FormatGenerator::message('Fail', 'Day and shift does not start ...'));
        }
    }

    public function tables(){
        $take_id            = 0;//1 For Take away 0 for tables and room
        $status             = StatusConstance::TABLE_AVAILABLE_STATUS;
        $tables             = Table::select('id','table_no')
                              ->where('status',$status)
                              ->whereNull('deleted_at')
                              ->get();
        return view('cashier.orderlist.tables')
                ->with('tables',$tables)
                ->with('take_id',$take_id);
    }

    public function getCategories($parent) {
        $itemRepo           = array();
        $itemArr            = array();
        $categories         = $this->detailRepository->getCategoriesByParent($parent);
        if (count($categories) <= 0) {
            $items          = $this->detailRepository->getItemsByCategory($parent);

            foreach($items as $key=>$item) {
                $itemRepo['id']       = $item->id;
                $itemRepo['name']     = $item->name;
                $itemRepo['image']    = $item->image;
                if ($item->group_id !== '' AND $item->isdefault == 0) {
                    //Do Nothing
                } else {
                    array_push($itemArr, $itemRepo);
                }
            }
        }
        return view('cashier.orderlist.category')
                ->with('parent',$parent)
                ->with('itemArr',$itemArr)
                ->with('categories',$categories);
    }

    public function getSetMenu() {
        $setmenu         = $this->detailRepository->getSetMenu();
        return view('cashier.orderlist.setmenu')
                ->with('setmenu',$setmenu);
    }
    public function item($id) {
        $uniqid     = uniqid();
        $today      = Carbon::now();
        $cur_date   = Carbon::parse($today)->format('Y-m-d');
        $status     = StatusConstance::ITEM_AVAILABLE_STATUS;
        $itemRepo   = Item::select('id','name','price','category_id','standard_cooking_time','group_id','continent_id','has_continent')
                      ->where('id',$id)
                      ->where('status',$status)
                      ->whereNull('deleted_at')
                      ->first();
        //Set Default Price with discount
        $itemRepo->discount_type       = '';
        $itemRepo->discount            = 0;
        $itemRepo->price_with_discount = 0;
        $itemRepo->uniqid              = $uniqid;
        //Check Discount
        $discount       = DiscountModel::select('id','amount','type')
                          ->where('item_id',$id)
                          ->whereDate('start_date','<=',$cur_date)
                          ->whereDate('end_date','>=',$cur_date)
                          ->whereNull('deleted_at')
                          ->first();
        //if discount has
        if(count($discount) > 0) {
            $priecOrigin        = $itemRepo->price;
            $discount_amount    = $discount->amount;
            if ($discount->type == '%') {
                $discount_price     = ($priecOrigin * $discount_amount)/100;
                $price_with_discount = $priecOrigin - $discount_price;
            } else {
                $discount_price      = $discount_amount;
                $price_with_discount = $priecOrigin - $discount_amount;
            }
            //Change amount with discount
            $itemRepo->discount_type        = $discount->type;
            $itemRepo->discount             = $discount_amount;
            $itemRepo->discount_price       = $discount_price;
            $itemRepo->price_with_discount  = $price_with_discount;
        }
        //Check Add on
        $categories         = $this->getCategoriesListArray($itemRepo->category_id);
        $status_addon       = StatusConstance::ADDON_AVAILABLE_STATUS;
        $addOn              = Addon::select('id','food_name','price')
                              ->whereIn('category_id',$categories)
                              ->where('status',$status_addon)
                              ->whereNull('deleted_at')
                              ->get()->toArray();
        if (count($addOn) > 0) {
            $itemRepo->add_on   = $addOn;
        }
        //Check Continent
        if ($itemRepo->has_continent == 1) {
            $continents     = Item::leftjoin('continent','items.continent_id','=','continent.id')
                              ->select('items.price as iprice','continent.id as cid','continent.name as cname')
                              ->where('items.status',$status)
                              ->where('items.group_id',$itemRepo->group_id)
                              ->whereNull('items.deleted_at')
                              ->get()->toArray();
            $itemRepo->continent = $continents;
        }
        return view('cashier.orderlist.item')->with('itemRepo',$itemRepo);
    }

    public function setMenu($id) {
        $uniqid         = uniqid();
        $today          = Carbon::now();
        $cur_date       = Carbon::parse($today)->format('Y-m-d');
        $status         = StatusConstance::SETMENU_AVAILABLE_STATUS;
        $setmenuRepo    = SetMenu::select('id','set_menus_name','set_menus_price','image')
                        ->where('id',$id)
                        ->where('status',$status)
                        ->whereNull('deleted_at')
                        ->first();
        $setmenuRepo->uniqid   = $uniqid;
        return view('cashier.orderlist.set')->with('setmenuRepo',$setmenuRepo);
    }
    
    public function continent($itemID,$continentID) {
        $status     = StatusConstance::ITEM_AVAILABLE_STATUS;
        $today      = Carbon::now();
        $cur_date   = Carbon::parse($today)->format('Y-m-d');
        $itemRepo   = Item::select('group_id')
                      ->where('id',$itemID)
                      ->where('status',$status)
                      ->whereNull('deleted_at')
                      ->first();
        $group_id   = $itemRepo->group_id;

        //Get Item By group id and continent ID
        $item               = Item::leftjoin('continent','items.continent_id','=','continent.id')
                                  ->select('items.id','items.name','items.price','continent.name as cname')
                                  ->where('group_id',$group_id)
                                  ->where('continent_id',$continentID)
                                  ->first();
        //Check Discount
        $discount       = DiscountModel::select('id','amount','type')
                          ->where('item_id',$itemID)
                          ->whereDate('start_date','<=',$cur_date)
                          ->whereDate('end_date','>=',$cur_date)
                          ->whereNull('deleted_at')
                          ->first();
        //if discount has
        if(count($discount) > 0) {
            $priecOrigin        = $item->price;
            $discount_amount    = $discount->amount;
            if ($discount->type == '%') {
                $discount_price     = ($priecOrigin * $discount_amount)/100;
                $price_with_discount = $priecOrigin - $discount_price;
            } else {
                $discount_price      = $discount_amount;
                $price_with_discount = $priecOrigin - $discount_amount;
            }
            //Change amount with discount
            $item->discount_type        = $discount->type;
            $item->discount             = $discount_amount;
            $item->discount_price       = $discount_price;
            $item->price_with_discount  = $price_with_discount;
        } else {
            $item->discount_type        = '';
            $item->discount             = '';
            $item->price_with_discount  = '';
            $item->discount_price       = 0;
        }
        return \Response::json($item);
    }

    public function backCategory($id) {
        $categories       = $this->detailRepository->getBackCategoryByID($id);
        return view('cashier.orderlist.category')
                ->with('categories',$categories);        
    }

    public function store(Request $request) {
        // dd(Input::all());

        //Create Order ID
        $order_id       = $this->generateOrderID();
        $user_id        = Auth::guard('Cashier')->id();
        $quantity       = Input::get('quantity');
        $item           = Input::get('item');
        $type           = Input::get('type');
        $continent      = Input::get('continent');
        $addon          = Input::get('addon');
        $originamount   = Input::get('originamount');
        $price          = Input::get('price');
        $discount_type  = Input::get('discount_type');
        $discount       = Input::get('discount');
        $take_id        = Input::get('take_id');
        $quantity       = Input::get('quantity');
        $extra_prices   = Input::get('extra');
        $service        = Input::get('service');
        $tax            = Input::get('tax');
        $room_charge    = Input::get('room');
        $all_total_prie = Input::get('price_total');
        $status         = StatusConstance::ORDER_CREATE_STATUS;
        $day_id         = Input::get('day_id');
        $shift_id       = Input::get('shift_id');
        $uniqid         = Input::get('uniqid');

        $row_count      = count($quantity);
        $today          = Carbon::now();
        $cur_date       = Carbon::parse($today)->format('Y-m-d H:i:s');

        $extra_array    = array();
        $discount_array = array();
        $price_array    = array();
        for($count = 0; $count < $row_count; $count++) {
            $qty                      = $quantity[$count];
            $extra                    = $extra_prices[$count];
            $discount_amount          = $discount[$count];

            $extra_array[$count]      = $qty * $extra;
            $discount_array[$count]   = $qty * $discount_amount;
        }
        //Total Extra Price
        $total_extra_price          = array_sum($extra_array);
        $total_discount_price       = array_sum($discount_array);
        $total_price                = array_sum($price);//Price already multipy with quantity
        try {
            DB::beginTransaction();
            //Insert Into Order
            $paramObj                          = new Order();
            $paramObj->id                      = $order_id;
            $paramObj->user_id                 = $user_id;
            $paramObj->take_id                 = $take_id;
            $paramObj->order_time              = $cur_date;
            $paramObj->total_extra_price       = $total_extra_price;
            $paramObj->total_discount_amount   = $total_discount_price;
            $paramObj->total_price             = $total_price;
            $paramObj->service_amount          = $service;
            $paramObj->tax_amount              = $tax;
            $paramObj->all_total_amount        = $all_total_prie;
            $paramObj->day_id                  = $day_id;
            $paramObj->shift_id                = $shift_id;
            $paramObj->status                  = $status;
            $paramObj->created_by              = $user_id;
            $paramObj->created_at              = $cur_date;
            $paramObj->save();
            // $this->detailRepository->store($paramObj);

            //Insert Into Order Detail
            $detailCount            = count($item);
            for ($itemCount = 0; $itemCount < $detailCount; $itemCount++) {
                $order_detail_id            = $this->generateOrderDetailID();
                //Check if take away is checked
                $uniqid_key                 = $uniqid[$itemCount];
                $checked                    = Input::get('take_' . $uniqid_key);//If checked take_it = 1: else 0
                $order_type                 = ($checked == '0' ? 1 : 2);
                //If item 0, set menu 1
                $itemID                     = ($type[$itemCount] == '0' ? $item[$itemCount] : 0);
                $setID                      = ($type[$itemCount] == '1' ? $item[$itemCount] : 0);

                $detailObj                  = new Orderdetail();
                $detailObj->order_id        = $order_id;
                $detailObj->order_detail_id = $order_detail_id;
                $detailObj->item_id         = $itemID;
                $detailObj->setmenu_id      = $setID;
                $detailObj->order_type_id   = $order_type;
                $detailObj->take_item       = $checked;
                $detailObj->quantity        = $quantity[$itemCount];
                $detailObj->discount_amount = $discount[$itemCount];
                $detailObj->amount          = $originamount[$itemCount];
                $detailObj->amount_with_discount = $price[$itemCount];
                $detailObj->order_time      = $cur_date;
                $detailObj->status_id       = StatusConstance::ORDER_DETAIL_COOKING_STATUS;
                $detailObj->created_by      = $user_id;
                $detailObj->created_at      = $cur_date;
                $detailObj->save();

                //Get Insert Order Detail ID
                $detailID                   = $detailObj->id;
                // $this->detailRepository->store($detailObj);
                $addon_detail               = $addon[$itemCount];
                $addon_array                = explode(",", $addon_detail);
                foreach($addon_array as $add) {
                    if ($add !== '') {
                        $itemQty            = $quantity[$itemCount];
                        $addonPrice         = $this->getAddonPriceByID($add);

                        $extraObj                   = new OrderExtra();
                        $extraObj->order_detail_id  = $detailID;
                        $extraObj->extra_id         = $add;
                        $extraObj->quantity         = $itemQty;
                        $extraObj->amount           = $addonPrice;
                        $extraObj->created_by       = $user_id;
                        $extraObj->created_at       = $cur_date;
                        $extraObj->save();
                    }
                }
            }
            DB::commit();
            
            return redirect('/Cashier/MakeOrder')->withMessage(FormatGenerator::message('Success', 'Order created ...'));;
        } catch (\Exception $e){
            DB::rollback();
            echo $e->getMessage();
        }
    }

    private function getCategoriesListArray($categoryID) {
        $group_id       = Category::select('group_id')->where('id',$categoryID)->first();
        $categories     = Category::select('id')->where('group_id',$group_id->group_id)->get()->toArray();
        return $categories;
    }

    private function generateOrderID() {
        $order_key      = "10-";
        $key_count      = Order::where('id','like','%' . $order_key . '%')
                        ->get()->count();
        $zero_fill      = "0000000000";
        if ($key_count == 0) {
            $order_key2     = "0000000001";
        } else {
            $increase_count     = $key_count + 1;
            $length             = strlen($increase_count);
            $substring_count    = "-" . $length;
            $zero_count         = substr($zero_fill,0,$substring_count);  
            $order_key2         = $zero_count . $increase_count; 
        }
        $key        = $order_key . $order_key2;
        return $key;
    }

    private function generateOrderDetailID() {
        $order_key      = "10-";
        $key_count      = Orderdetail::where('order_detail_id','like','%' . $order_key . '%')
                        ->get()->count();
        $zero_fill      = "00000000000";
        if ($key_count == 0) {
            $order_key2     = "00000000001";
        } else {
            $increase_count     = $key_count + 1;
            $length             = strlen($increase_count);
            $substring_count    = "-" . $length;
            $zero_count         = substr($zero_fill,0,$substring_count);  
            $order_key2         = $zero_count . $increase_count;   
        }
        $key        = $order_key . $order_key2;
        return $key;
    }

    private function getAddonPriceByID($addonID) {
        $status         = StatusConstance::ADDON_AVAILABLE_STATUS;
        $priceObj       = Addon::select('price')
                        ->where('status',$status)
                        ->where('id',$addonID)
                        ->whereNull('deleted_at')
                        ->first();
        $price          = $priceObj->price;
        return $price;
    }
    // public function category(){
    //     $items = $this->detailRepository->getCategories();

    //     return view('cashier.orderlist.category')->with('items',$items);
    // }
    // public function setmenu(){
    //     $setmenus = $this->detailRepository->getsetmenu();
    //     return view('cashier.orderlist.setmenu')->with('setmenus',$setmenus);
    // }
    // public function categoryDetail($id){
    // 	$items = $this->detailRepository->categoryDetail($id);
        
    //     $table      = $items[0];
    //     $t          = $table['table'];
    //     //dd($t);
    //     if($t == 'category'){
    //         return view('cashier.orderlist.categorydetail')->with('items',$items)->with('table',$t);
    //     }else{
    //         return view('cashier.orderlist.item')->with('items',$items)->with('table',$t);
    //     }
    	
    // }
    // public function searchItem($id){
    // 	$items = $this->detailRepository->searchItem($id);
    	
    // 	return view('cashier.orderList.item')->with('items',$items);
    // }

    // public function add($id, $type){
    //     switch ($type) {
    //         case 'sm':
    //             //do set menu things
    //             $setmenus = $this->detailRepository->getsetmenu();
    //             $setmenu = SetMenu::find($id);
    //             $item = array();
    //             $item['set_id']         = $setmenu->id;
    //             $item['item_id']        = 0;
    //             $item['status_id']      = 1;
    //             $item['set_discount_amount']= 0;
    //             $item['set_menu_name']  = $setmenu->set_menus_name;
    //             $item['set_menu_price'] = $setmenu->set_menus_price;
    //             $item['quantity']       = 1;
    //             $item['set_amount']     = ($setmenu->set_menus_price) - 0;
    //             $item['type']           = 'setmenu'; //use to distinguish between setmenu or item
              
    //             $chosen_item = array();

    //             if (session('chosen_item')) {
                   
    //                 $chosen_item = session('chosen_item');
    //             }

    //             $chosen_item[]= $item;
    //             session(['chosen_item'=>$chosen_item]);
                
    //             return view('cashier.orderlist.setmenu')            
    //                 ->with('setmenus',$setmenus);
    //             break;
            
    //         case 'item':
    //             //do item things
    //             $items    = $this->detailRepository->getitem($id);
    //             $product  = Item::find($id);
    //             $discount = DiscountModel::where('item_id',$id)->where('deleted_at',NULL)->first();
    //             $discount_amount = 0;
    //             if(isset($discount)){
    //                 $amount             = $discount->amount;
    //                 $type               = $discount->type;
    //                 $start              = $discount->start_date;
    //                 $end                = $discount->end_date;
    //                 $today              = Carbon::now();
    //                 $date               = Carbon::parse($today)->format('Y-m-d');

    //                 if($date > $start && $date < $end){
    //                     if($type == "%"){
    //                         $discount_amount = (($product->price)*$type/100);
    //                     }else{
    //                         $discount_amount = ($product->price) - ($amount);
    //                     }
    //                 }else{
    //                     $discount_amount = 0;
    //                 }
    //             }else{
    //                 $discount_amount = 0;
    //             }
    //             //find item detail here
    //             $item = array();
    //             $item['item_id']        = $product->id;
    //             $item['set_id']         = 0;
    //             $item['item_name']      = $product->name;
    //             $item['item_price']     = $product->price;
    //             $item['item_discount_amount'] = $discount_amount;
    //             $item['item_quantity']  = 1;
    //             $item['item_amount']    = ($product->price)-($discount_amount);
    //             $item['type'] = 'item'; //use to distinguish between setmenu or item

    //             $chosen_item = array();

    //             if (session('chosen_item')) {
                   
    //                 $chosen_item = session('chosen_item');
    //             }

    //             $chosen_item[]= $item;

    //             session(['chosen_item'=>$chosen_item]);
    //             //dd(session('chosen_item'));
    //             return view('cashier.orderlist.item')            
    //                 ->with('items',$items);
    //             //return your view here
    //             break;

    //         default:
    //             //return error view or raise exception
    //             break;
    //     }


        
        
    // }
}
