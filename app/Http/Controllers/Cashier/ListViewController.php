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
use App\RMS\SetItem\SetItem;
use App\RMS\OrderSetMenuDetail\OrderSetMenuDetail;
use App\RMS\Item\Item;
use App\RMS\Addon\Addon;
use App\RMS\Table\Table;
use App\RMS\Room\Room;
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
        $tables             = '';
        $rooms              = '';
        if (count($dayStart) > 0) {
            $day_id     = $dayStart->day_id;
            $shift_id   = $dayStart->shift_id;
            return view('cashier.orderlist.order')
                    ->with('config',$config)
                    ->with('day_id',$day_id)
                    ->with('take_id',$take_id)
                    ->with('tables',$tables)
                    ->with('rooms',$rooms)
                    ->with('rooms',$rooms)
                    ->with('shift_id',$shift_id);
        } else {
            return redirect()->back()
                ->withMessage(FormatGenerator::message('Fail', 'Day and shift does not start ...'));
        }
    }

    public function tables(){
        $take_id            = 0;//1 For Take away 0 for tables and room
        $status             = StatusConstance::TABLE_AVAILABLE_STATUS;
        $order_status       = StatusConstance::ORDER_CREATE_STATUS;
        $unaviable_status   = StatusConstance::TABLE_UNAVAILABLE_STATUS;
        $tables             = Table::select('id','table_no')
                              ->where('status',$status)
                              ->whereNull('deleted_at')
                              ->get();
        $transfer_from      = Table::leftjoin('order_tables','tables.id','=','order_tables.table_id')
                              ->leftjoin('order','order_tables.order_id','=','order.id')
                              ->select('tables.id','tables.table_no','order_tables.order_id')
                              ->where('tables.status',$unaviable_status)
                              ->where('order.status',$order_status)
                              ->whereNull('tables.deleted_at')
                              ->whereNull('order_tables.deleted_at')
                              ->whereNull('order.deleted_at')
                              ->get();
                              // dd($transfer_from);
        return view('cashier.orderlist.tables')
                ->with('tables',$tables)
                ->with('transfer_from',$transfer_from)
                ->with('take_id',$take_id);
    }

    public function rooms() {
        $take_id        = 0;
        $status             = StatusConstance::ROOM_AVAILABLE_STATUS;
        $rooms              = Room::select('id','room_name')
                              ->where('status',$status)
                              ->whereNull('deleted_at')
                              ->get();
        return view('cashier.orderlist.rooms')
                ->with('rooms',$rooms)
                ->with('take_id',$take_id);

    }

    public function orderTable($id) {
        $day_status     = StatusConstance::DAY_STARTING_STATUS;
        $shift_status   = StatusConstance::ORDER_SHIFT_START_STATUS;
        $dayStart = DayStart::leftjoin('order_shift','order_day.id','=','order_shift.day_id')
                    ->select('order_day.id as day_id','order_shift.shift_id')
                    ->where('order_day.status','=',$day_status)
                    ->where('order_shift.status','=',$shift_status)
                    ->first();
        $config             = Config::select('tax','service','room_charge')->first();
        $take_id            = 0;//1 For 
        $tables             = $id;
        $rooms              = '';
        if (count($dayStart) > 0) {
            $day_id     = $dayStart->day_id;
            $shift_id   = $dayStart->shift_id;
            return view('cashier.orderlist.order')
                    ->with('config',$config)
                    ->with('day_id',$day_id)
                    ->with('take_id',$take_id)
                    ->with('tables',$tables)
                    ->with('rooms',$rooms)
                    ->with('shift_id',$shift_id);
        } else {
            return redirect()->back()
                ->withMessage(FormatGenerator::message('Fail', 'Day and shift does not start ...'));
        }   
    }

    public function orderRoom($id) {
        $day_status     = StatusConstance::DAY_STARTING_STATUS;
        $shift_status   = StatusConstance::ORDER_SHIFT_START_STATUS;
        $dayStart = DayStart::leftjoin('order_shift','order_day.id','=','order_shift.day_id')
                    ->select('order_day.id as day_id','order_shift.shift_id')
                    ->where('order_day.status','=',$day_status)
                    ->where('order_shift.status','=',$shift_status)
                    ->first();
        $config             = Config::select('tax','service','room_charge')->first();
        $take_id            = 0;//1 For 
        $tables             = '';
        $rooms              = $id;
        if (count($dayStart) > 0) {
            $day_id     = $dayStart->day_id;
            $shift_id   = $dayStart->shift_id;
            return view('cashier.orderlist.order')
                    ->with('config',$config)
                    ->with('day_id',$day_id)
                    ->with('take_id',$take_id)
                    ->with('tables',$tables)
                    ->with('rooms',$rooms)
                    ->with('shift_id',$shift_id);
        } else {
            return redirect()->back()
                ->withMessage(FormatGenerator::message('Fail', 'Day and shift does not start ...'));
        }   
    }

    public function transfer() {
        $from           = Input::get('from');
        $table_to       = Input::get('to');
        $aviable_status = StatusConstance::TABLE_AVAILABLE_STATUS;
        $unaviable_status = StatusConstance::TABLE_UNAVAILABLE_STATUS;
        if ($from == null || $table_to == null) {
            $return_array       = array("success"=>0,"message"=>"fail");
        } else {
            $from_explode       = explode("/", $from);
            $from_table         = $from_explode[0];
            $from_order         = $from_explode[1];
            try {
                DB::beginTransaction();
                    //Update Order Tables
                    $update_order_tables    = DB::table('order_tables')
                                              ->where('order_id', $from_order)
                                              ->where('table_id', $from_table)
                                              ->update(['table_id' => $table_to]);
                    //update aviable status from table
                    $update_from_tables     = DB::table('tables')
                                              ->where('id', $from_table)
                                              ->update(['status' => $aviable_status]);

                    //update unaviable status to table
                    $update_to_tables       = DB::table('tables')
                                              ->where('id', $table_to)
                                              ->update(['status' => $unaviable_status]);
                    $return_array           = array("success"=>1,"message"=>"Success");
                DB::commit();
            } catch (\Exception $e){
                DB::rollback();
                $message = $e->getMessage();
                $return_array       = array("success"=>0,"message"=>$message);
            }
        }

        return \Response::json($return_array);
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
    public function item($id,$take) {
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
        return view('cashier.orderlist.item')->with('itemRepo',$itemRepo)->with('take',$take);
    }

    public function setMenu($id,$take) {
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
        return view('cashier.orderlist.set')->with('setmenuRepo',$setmenuRepo)->with('take',$take);
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

    public function store() {
        // dd(Input::all());

        //Create Order ID
        $order_id       = $this->generateOrderID();
        $user_id        = Auth::guard('Cashier')->id();
        $quantity       = Input::get('quantity');
        $item           = Input::get('item');
        $type           = Input::get('type');
        $addon          = Input::get('addon');
        $originamount   = Input::get('originamount');
        $price          = Input::get('price');
        $discount       = Input::get('discount');
        $take_id        = Input::get('take_id');
        $quantity       = Input::get('quantity');
        $extra_prices   = Input::get('extra');
        $tables         = Input::get('tables');
        $rooms          = Input::get('rooms');
        $service        = Input::get('service');
        $tax            = Input::get('tax');
        $room_charge    = Input::get('room_charge');
        $all_total_prie = Input::get('price_total');
        $day_id         = Input::get('day_id');
        $shift_id       = Input::get('shift_id');
        $uniqid         = Input::get('uniqid');

        $row_count      = count($quantity);
        $today          = Carbon::now();
        $cur_date       = Carbon::parse($today)->format('Y-m-d H:i:s');
        $status         = StatusConstance::ORDER_CREATE_STATUS;
        $item_status    = StatusConstance::ORDER_DETAIL_COOKING_STATUS;
        $extra_array    = array();
        $discount_array = array();
        $price_array    = array();

        //Check If Empty Item
        if (count($item) <= 0) {
            alert()->warning('Please Choose item!')->persistent('Close');
//            return back();
            return redirect()->back();
        } else {
            for($count = 0; $count < $row_count; $count++) {
                $qty                      = (int)($quantity[$count]);
                $extra                    = (int)($extra_prices[$count]);
                $discount_amount          = (int)($discount[$count]);

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
                $paramObj->room_charge             = $room_charge;
                $paramObj->day_id                  = $day_id;
                $paramObj->shift_id                = $shift_id;
                $paramObj->status                  = $status;
                $paramObj->created_by              = $user_id;
                $paramObj->created_at              = $cur_date;
                $paramObj->save();

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
                    $order_detail_status        = StatusConstance::ORDER_DETAIL_COOKING_STATUS;
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
                    $detailObj->status_id       = $order_detail_status;
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
                    //Extract Setmenu to order_setmenu_detail
                    if ($itemID == 0) {
                        $set_items          = $this->detailRepository->getSetItemBySetID($setID);
                        foreach ($set_items as $key => $set) {
                            $orderSetObj                    = new OrderSetMenuDetail();  
                            $orderSetObj->order_detail_id   = $detailID;
                            $orderSetObj->setmenu_id        = $setID;
                            $orderSetObj->item_id           = $set->item_id;
                            $orderSetObj->order_type_id     = $order_type;
                            $orderSetObj->quantity          = $quantity[$itemCount];
                            $orderSetObj->status_id         = $item_status;
                            $orderSetObj->order_time        = $cur_date;
                            $orderSetObj->created_at        = $cur_date;
                            $orderSetObj->created_by        = $user_id;
                            $orderSetObj->save();
                        }
                    }
                }

                //If table exit
                if ($tables !== '') {
                    $table_array    = explode(",", $tables);
                    foreach($table_array as $key => $t) {
                        $order_table_id         = $this->genereateTableID();

                        $tableObj               = new OrderTable();
                        $tableObj->id           = $order_table_id;
                        $tableObj->order_id     = $order_id;
                        $tableObj->table_id     = $t;
                        $tableObj->created_at   = $cur_date;
                        $tableObj->save();
                        //Make Unaviable table
                        $table_status           = StatusConstance::TABLE_UNAVAILABLE_STATUS;
                        $tempTableObj           = Table::find($t);
                        $tempTableObj->status   = $table_status;
                        $tempTableObj->save();
                    }
                }

                //If Room exit
                if ($rooms !== '') {

                    $order_room_id         = $this->genereateRoomID();
                    $roomObj               = new OrderRoom();
                    $roomObj->id           = $order_room_id;
                    $roomObj->order_id     = $order_id;
                    $roomObj->room_id      = $rooms;
                    $roomObj->created_at   = $cur_date;
                    $roomObj->save();
                    //Make Unaviable room
                    $room_status            = StatusConstance::ROOM_UNAVAILABLE_STATUS;
                    $tempRoomObj            = Room::find($rooms);
                    $tempRoomObj->status    = $room_status;
                    $tempRoomObj->save();
                }
                DB::commit();
                
                return redirect('/Cashier/MakeOrder')
                ->withMessage(FormatGenerator::message('Success', 'Order created ...'))
                ->with('Sockect','Socket Order Send');
            } catch (\Exception $e){
                DB::rollback();
                echo $e->getMessage();
                echo $e->getLine();
            }
        }
    }

    public function edit($id) {
        $status_addon      = StatusConstance::ADDON_AVAILABLE_STATUS;
        $status_extra      = StatusConstance::ORDER_EXTRA_AVAILABLE_STATUS;
        $order             = $this->detailRepository->getorder($id);
        $order_details     = $this->detailRepository->getdetail($id);
        $od                = array();
        $addon             = array();
        $category_addon    = array();
        foreach($order_details as $detail) {
            $uniqid             = uniqid();
            $detailID           = $detail['order_detail_id'];
            $itemID             = $detail['item_id'];
            $categoryID         = $detail['category_id'];
            if ($itemID !== NULL) {
                //For Continent
                $continents         = $this->detailRepository->getContinent($itemID);
            } else {
                $continents         = array();
            }
            
            //Addon From Categories
            if ($categoryID !== NULL) {
                $categories         = $this->getCategoriesListArray($categoryID);
                $category_addon     = Addon::select('id','food_name','price')
                                      ->whereIn('category_id',$categories)
                                      ->where('status',$status_addon)
                                      ->whereNull('deleted_at')
                                      ->get()->toArray();
            } else {
                $category_addon     = array();
            }
            //Choosen Addon
            $addon              = OrderExtra::leftjoin('add_on','add_on.id','=','order_extra.extra_id')
                              ->select('order_extra.extra_id','add_on.food_name','add_on.price')
                              ->where('order_extra.order_detail_id',$detailID)
                              ->where('order_extra.status',$status_extra)
                              ->where('add_on.status',$status_addon)
                              ->whereNull('order_extra.deleted_at')
                              ->whereNull('add_on.deleted_at')
                              ->get()->toArray();
            $total_addon_price  = 0;
            $addon_id       = array();
            if (count($addon) > 0) {
                foreach($addon as $add) {
                    $addon_id[]         = $add['extra_id'];
                    $add_amount         = $add['price'];
                    $total_addon_price  += $add_amount;
                }
            }
            $detail['continents'] = $continents;
            $detail['category_addon']  = $category_addon;
            $detail['addon']           = $addon_id;
            /*** Unset Array ***/ 
            unset($addon_id);
            /*** Unset Array ***/

            $detail['total_addon_price']  = $total_addon_price;
            $detail['uniqid']          = $uniqid;
            array_push($od,$detail);
        }

        $order['detail']   = $od;
        $tables         = $this->detailRepository->orderTable($id);
        $rooms          = $this->detailRepository->orderRoom($id);
        $config         = Config::select('restaurant_name','email','logo','website','address','phone','tax','service')->first();
        // dd($order);
        return view('cashier.orderlist.order')
                    ->with('config',$config)
                    ->with('order',$order)
                    // ->with('continents',$continents)
                    ->with('tables',$tables)
                    ->with('rooms',$rooms);
        
    }

    public function delete(Request $request) {
        $order_detail_id        = $request->order_detail_id;
        // $order_detail_id        = $id;
        $status                 = StatusConstance::ORDER_DETAIL_CUSTOMER_CANCEL_STATUS;
        $today                  = Carbon::now();
        $cur_date               = Carbon::parse($today)->format('Y-m-d H:i:s');
        $od                     = Orderdetail::find($order_detail_id);
        $user_id                = Auth::guard('Cashier')->id();
        //If old order edit and response success, new order response success
        if (count($od) >= 1) {
            try {
                DB::beginTransaction();
                //Update Order
                //Calculate Total Discount
                $detailRepo             = DB::table('order_details')
                                         ->leftjoin('order', 'order.id', '=', 'order_details.order_id')
                                         ->leftjoin('order_extra', 'order_extra.order_detail_id', '=', 'order_details.id')
                                         ->select('order_details.amount_with_discount','order.id as order_id','order.total_price','order.room_charge','order.total_price as order_price','order.total_discount_amount as order_discount','order.total_extra_price as order_extra',
                                        DB::raw('SUM(order_details.discount_amount * order_details.quantity) as total_discount'),
                                        DB::raw('SUM(order_extra.amount * order_extra.quantity) as extra_amount')
                                            )
                                         ->where('order_details.id',$order_detail_id)
                                         ->first();
                $config                 = Config::select('tax','service')->first();
                //Get Origin Prices
                $order_id               = $detailRepo->order_id;
                $origin_extra           = $detailRepo->total_price;
                $origin_discount        = $detailRepo->order_discount;
                $origin_price           = $detailRepo->order_price;
                $room_charge            = $detailRepo->room_charge;
                //Get Delete Prices
                $delete_extra           = (int)($detailRepo->extra_amount);
                $delete_discount        = $detailRepo->total_discount;
                $delete_price           = $detailRepo->amount_with_discount;
                //Update Price
                $update_extra           = $origin_extra - $delete_extra;
                $update_discount        = $origin_discount - $delete_discount;
                $update_price           = $origin_price - $delete_price;
                $update_tax             = ($config->tax * $update_price)/100;
                $update_service         = ($config->service * $update_price)/100;
                $all_total_amount       = $update_price + $update_tax + $update_service + $room_charge;

                $orderObj                        = Order::find($order_id);
                $orderObj->order_time            = $cur_date;
                $orderObj->total_extra_price     = $update_extra;
                $orderObj->total_discount_amount = $update_discount;
                $orderObj->total_price           = $update_price;
                $orderObj->service_amount        = $update_service;
                $orderObj->tax_amount            = $update_tax;
                $orderObj->all_total_amount      = $all_total_amount;
                $orderObj->updated_by            = $user_id;
                $orderObj->updated_at            = $cur_date;
                $orderObj->save();

                $detailObj              = Orderdetail::find($order_detail_id);
                $setmenu_id             = $detailObj->setmenu_id;
                $detailObj->status_id   = $status;
                $detailObj->save();
                //Delete Extra
                $extraObj               = OrderExtra::where('order_detail_id',$order_detail_id)->get();
                foreach ($extraObj as $key => $extra) {
                    $extra_id       = $extra->extra_id;
                    $update_extra   = DB::table('order_extra')
                                    ->where('order_detail_id', $order_detail_id)
                                    ->where('extra_id', $extra_id)
                                    ->update(['deleted_at' => $cur_date]);
                }

                if ($setmenu_id !== 0) {
                    $update_order_set   = DB::table('order_setmenu_detail')
                                        ->where('order_detail_id', $order_detail_id)
                                        ->where('setmenu_id', $setmenu_id)
                                        ->update(['deleted_at' => $cur_date]);
                }
                DB::commit();
                $success_msg            = array("success"=>"success");
                return \Response::json($success_msg);
            } catch (\Exception $e){
                    DB::rollback();
                    echo $e->getMessage();
                    echo $e->getLine();
            }
        } else {
            $success_msg            = array("success"=>"success");
            return \Response::json($success_msg);   
        }
    }

    public function update() {
        // dd(Input::all());
        //Create Order ID
        $order_id       = Input::get('order_id');
        $order_detail_id= (Input::get('order_detail_id') == null ? array() : Input::get('order_detail_id'));
        $user_id        = Auth::guard('Cashier')->id();
        $quantity       = Input::get('quantity');
        $item           = Input::get('item');
        $type           = Input::get('type');
        $addon          = Input::get('addon');
        $originamount   = Input::get('originamount');
        $price          = Input::get('price');
        $discount       = Input::get('discount');
        $take_id        = Input::get('take_id');
        $quantity       = Input::get('quantity');
        $extra_prices   = Input::get('extra');
        $service        = Input::get('service');
        $tax            = Input::get('tax');
        $room_charge    = Input::get('room_charge');
        $all_total_prie = Input::get('price_total');
        $day_id         = Input::get('day_id');
        $shift_id       = Input::get('shift_id');
        $uniqid         = Input::get('uniqid');

        $row_count      = count($quantity);
        $today          = Carbon::now();
        $cur_date       = Carbon::parse($today)->format('Y-m-d H:i:s');

        $extra_array    = array();
        $discount_array = array();
        $price_array    = array();
        $status         = StatusConstance::ORDER_CREATE_STATUS;
        $cancel_status  = StatusConstance::ORDER_DETAIL_CUSTOMER_CANCEL_STATUS;
        $cancel_extra   = StatusConstance::ORDER_EXTRA_UNAVAILABLE_STATUS;
        $extra_status   = StatusConstance::ORDER_EXTRA_AVAILABLE_STATUS;
        $order_kitchen_cancel_status    = StatusConstance::ORDER_DETAIL_KITCHEN_CANCEL_STATUS;
        $order_customer_cancel_status   = StatusConstance::ORDER_DETAIL_CUSTOMER_CANCEL_STATUS;

        for($count = 0; $count < $row_count; $count++) {
            $qty                      = (int)($quantity[$count]);
            $extra                    = (int)($extra_prices[$count]);
            $discount_amount          = (int)($discount[$count]);
            $extra_array[$count]      = (int)($qty * $extra);
            $discount_array[$count]   = (int)($qty * $discount_amount);
        }
        //Total Extra Price
        $total_extra_price          = array_sum($extra_array);
        $total_discount_price       = array_sum($discount_array);
        $total_price                = array_sum($price);//Price already multipy with quantity
        try {
            DB::beginTransaction();
            //Insert Into Order
            $paramObj                          = Order::find($order_id);
            $paramObj->user_id                 = $user_id;
            $paramObj->take_id                 = $take_id;
            $paramObj->order_time              = $cur_date;
            $paramObj->total_extra_price       = $total_extra_price;
            $paramObj->total_discount_amount   = $total_discount_price;
            $paramObj->total_price             = $total_price;
            $paramObj->service_amount          = $service;
            $paramObj->tax_amount              = $tax;
            $paramObj->all_total_amount        = $all_total_prie;
            $paramObj->room_charge             = $room_charge;
            $paramObj->day_id                  = $day_id;
            $paramObj->shift_id                = $shift_id;
            $paramObj->status                  = $status;
            $paramObj->updated_by              = $user_id;
            $paramObj->updated_at              = $cur_date;
            $paramObj->save();

            $new_order_detail                   = array();
            //Insert Into Order Detail
            $detailCount            = count($item);
            for ($itemCount = 0; $itemCount < $detailCount; $itemCount++) {
                //Check if take away is checked
                $uniqid_key                 = $uniqid[$itemCount];
                $checked                    = Input::get('take_' . $uniqid_key);//If checked take_it = 1: else 0
                $order_type                 = ($checked == '0' ? 1 : 2);
                //If item 0, set menu 1
                $itemID                     = ($type[$itemCount] == '0' ? $item[$itemCount] : 0);
                $setID                      = ($type[$itemCount] == '1' ? $item[$itemCount] : 0);

                if (isset($order_detail_id[$itemCount])) {
                    $detailObj                  = Orderdetail::find($order_detail_id[$itemCount]);
                    $detailObj->order_id        = $order_id;
                    $detailObj->item_id         = $itemID;
                    $detailObj->setmenu_id      = $setID;
                    $detailObj->order_type_id   = $order_type;
                    $detailObj->take_item       = $checked;
                    $detailObj->quantity        = $quantity[$itemCount];
                    $detailObj->discount_amount = $discount[$itemCount];
                    $detailObj->amount          = $originamount[$itemCount];
                    $detailObj->amount_with_discount = $price[$itemCount];
                    $detailObj->order_time      = $cur_date;
                    $detailObj->updated_by      = $user_id;
                    $detailObj->updated_at      = $cur_date;
                    $detailObj->save();

                    //Get Insert Order Detail ID
                    $detailID                   = $order_detail_id[$itemCount];
                    //Change ORDER_EXTRA_UNAVAILABLE_STATUS For Cancel Extra
                    $addon_detail               = $addon[$itemCount];

                    $addon_array                = explode(",", $addon_detail);

                    $cancel_addon      = OrderExtra::select('order_detail_id','extra_id')
                                      ->where('order_detail_id',$detailID)
                                      ->where('status',$extra_status)
                                      ->whereNull('deleted_at')
                                      ->whereNotIn('extra_id',$addon_array)
                                      ->get();
                    if (count($cancel_addon) > 0) {
                        foreach($cancel_addon as $cancel_add) {
                            DB::table('order_extra')
                            ->where('order_detail_id', $cancel_add->order_detail_id)
                            ->where('extra_id', $cancel_add->extra_id)
                            ->update(['status' => $cancel_extra]);
                        }
                    }

                    //If New addon insert into order_extra
                    foreach($addon_array as $key => $new_addon) {
                        if ($new_addon !== '') {
                            $old_addon      = OrderExtra::where('order_detail_id',$detailID)
                                              ->where('extra_id',$new_addon)
                                              ->where('status',$extra_status)
                                              ->get()->count();
                            if ($old_addon <= 0) {
                                $extra_amount               = $this->getAddonPriceByID($new_addon);
                                $extraObj                   = new OrderExtra();
                                $extraObj->order_detail_id  = $detailID;
                                $extraObj->extra_id         = $new_addon;
                                $extraObj->amount           = $extra_amount;
                                $extraObj->quantity         = $quantity[$itemCount];
                                $extraObj->status           = $extra_status;
                                $extraObj->created_by       = $user_id;
                                $extraObj->created_at       = $cur_date;
                                $extraObj->save();
                            }
                        }
                    }
                } else {
                    $od_id                      = $this->generateOrderDetailID();
                    //Not to change status_id 7 
                    $new_order_detail[]         = $od_id;
                    $detailObj                  = new Orderdetail();
                    $detailObj->order_id        = $order_id;
                    $detailObj->order_detail_id = $od_id;
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
                    $detailObj->updated_by      = $user_id;
                    $detailObj->updated_at      = $cur_date;
                    $detailObj->save();
                          
                    //Get Insert Order Detail ID
                    $detailID                   = $detailObj->id;

                    $addon_detail               = $addon[$itemCount];
                    $addon_array                = explode(",", $addon_detail);
                    foreach($addon_array as $add) {
                        if ($add !== '') {
                            //dd('hehehe');
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
            }
            DB::commit();
            
            return redirect('/Cashier/MakeOrder')
            ->withMessage(FormatGenerator::message('Success', 'Order created ...'))
            ->with('Sockect','Socket Order Send');
        } catch (\Exception $e){
            DB::rollback();
            echo $e->getMessage();
            echo $e->getLine();
        }
    }

    private function getCategoriesListArray($categoryID) {
        $categories     = array();
        $group_id       = Category::select('group_id')->where('id',$categoryID)->first();
        if (count($group_id) > 0) {
            $categories     = Category::select('id')->where('group_id',$group_id->group_id)->get()->toArray();
        }
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

    private function genereateTableID() {
        $max_id      = OrderTable::select('id')
                        ->max('id');
        if (count($max_id) <= 0) {
            $table_id       = 1;
        } else {
            $table_id       = $max_id + 1;
        }

        return $table_id;
    }

    private function genereateRoomID() {
        $max_id      = OrderRoom::select('id')
                        ->max('id');
        if (count($max_id) <= 0) {
            $room_id       = 1;
        } else {
            $room_id       = $max_id + 1;
        }

        return $room_id;
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

    private function findItem($id)
    {
        $item = Item::find($id);
        return $item ? $item : new Item;
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
