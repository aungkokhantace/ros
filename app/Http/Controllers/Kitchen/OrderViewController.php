<?php

namespace App\Http\Controllers\Kitchen;

use App\RMS\Order\OrderRepositoryInterface;
use App\RMS\Order\Order;
use App\RMS\Orderdetail\Orderdetail;
use App\RMS\Table\Table;
use App\RMS\Addon\Addon;
use App\RMS\SetMenu\SetMenu;
use App\RMS\Kitchen\Kitchen;
use App\RMS\OrderExtra\OrderExtra;
use App\RMS\OrderSetMenuDetail\OrderSetMenuDetail;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Status\StatusConstance;
use App\RMS\Config\Config;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use Illuminate\Support\Collection as Collection;

class OrderViewController extends Controller

{
    private $orderRepository;
    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->OrderRepository = $orderRepository;
    }
    public function tableView()
    {
        $id                 = Auth::guard('Cashier')->user()->kitchen_id;
        $kitchen            = Kitchen::find($id);
        $tables             = $this->OrderRepository->orderTable();
        $rooms              = $this->OrderRepository->orderRoom();
        $extra              = $this->OrderRepository->orderExtra();

        //Status Lists
        $order_status                  = StatusConstance::ORDER_CREATE_STATUS;
        $order_paid_status             = StatusConstance::ORDER_PAID_STATUS;
        //Order Detail Status
        $order_details_cooking_status  = StatusConstance::ORDER_DETAIL_COOKING_STATUS;
        $order_details_cooked_status   = StatusConstance::ORDER_DETAIL_COOKED_STATUS;
        //Setmenu Status
        $order_setmenu_cooking_status  = StatusConstance::ORDER_SETMENU_COOKING_STATUS;
        $order_setmenu_cooked_status   = StatusConstance::ORDER_SETMENU_COOKED_STATUS;

        $ordersRaw          = DB::select("SELECT * FROM `order` WHERE status = '$order_status' OR status = '$order_paid_status' ORDER BY id DESC");
        $order_detailsRaw   = DB::select("SELECT order_details.*,items.name,items.category_id,items.image,items.has_continent,continent.name AS continent_name 
                                          FROM `order_details`
                                          LEFT JOIN `items` ON order_details.item_id=items.id
                                          LEFT JOIN `category` ON category.id = items.category_id
                                          LEFT JOIN `continent` ON continent.id = items.continent_id
                                          WHERE order_details.status_id IN ($order_details_cooking_status,$order_details_cooked_status) ");
        
        $set_menusRaw       = DB::select("SELECT order_setmenu_detail.*,items.name,items.category_id,items.image,items.has_continent,continent.name AS continent_name
                                          FROM `order_setmenu_detail`
                                          LEFT JOIN `items` ON order_setmenu_detail.item_id = items.id
                                          LEFT JOIN `category` ON category.id = items.category_id
                                          LEFT JOIN `continent` ON continent.id = items.continent_id
                                          WHERE order_setmenu_detail.status_id IN ($order_setmenu_cooking_status,$order_setmenu_cooked_status) ");
        
        $categoryRaw        = DB::select("SELECT id FROM category WHERE kitchen_id = $kitchen->id AND deleted_at is NULL");
        $categoryIdArr      = array();
        foreach($categoryRaw as $category){
            array_push($categoryIdArr,$category->id);
        }

        // looping for orders
        $results        = array();
        $orders         = array();
        $order_details  = array();
        $set_menus      = array();
        $categories     = array();

        foreach ($ordersRaw as $key => $order) {
            $orders[$order->id]   = $order;
        }
        foreach ($orders as $key => $order) {
            $order_id = $order->id;
            $orderItemList = array();

            foreach ($order_detailsRaw as $keyOD => $order_detail) {

                $order_detail_id            = $order_detail->id;
                $item_id                    = $order_detail->item_id;
                $setmenu_id                 = $order_detail->setmenu_id;
                $order_detail_order_id      = $order_detail->order_id;
                $order_detail_category_id   = $order_detail->category_id;

                if($order_detail_order_id == $order_id){
                    // Set Menu Case
                    if($item_id == 0){

                        foreach ($set_menusRaw as $keySM => $set_menu) {
                            
                            $setMenuOrderDetailId   = $set_menu->order_detail_id;
                            $setMenuSetMenuId       = $set_menu->setmenu_id;
                            $setMenuItemId          = $set_menu->item_id;
                            $setCategoryId          = $set_menu->category_id;
                            
                            if($order_detail_id == $setMenuOrderDetailId && $setmenu_id == $setMenuSetMenuId && in_array($setCategoryId,$categoryIdArr)){
                                // need to add the item array
                                array_push($orderItemList,$set_menu);
                            }
                        }
                    }
                    // normal item case
                    if($setmenu_id == 0 && in_array($order_detail_category_id,$categoryIdArr)){
                        array_push($orderItemList,$order_detail);
                    }
                }
            }
            $orders[$key]->items = $orderItemList;
        }
        
        return view('kitchen.kitchen')->with('orders',$orders)->with('tables',$tables)->with('rooms',$rooms)->with('extra',$extra);
    }
    
    public function tableViewDesign() {
        return view('kitchen.kitchen_design');
    }

    public function ajaxOrderRequest()
    {
        $id                 = Auth::guard('Cashier')->user()->kitchen_id;
        $kitchen            = Kitchen::find($id);
        $tables             = $this->OrderRepository->orderTable();
        $rooms              = $this->OrderRepository->orderRoom();
        $extra              = $this->OrderRepository->orderExtra();
        
        //Status Lists
        $order_status                  = StatusConstance::ORDER_CREATE_STATUS;
        $order_paid_status             = StatusConstance::ORDER_PAID_STATUS;
        //Setmenu Status
        $order_setmenu_cooking_status  = StatusConstance::ORDER_SETMENU_COOKING_STATUS;
        $order_setmenu_cooked_status   = StatusConstance::ORDER_SETMENU_COOKED_STATUS;
        //Order Detail Status
        $order_details_cooking_status  = StatusConstance::ORDER_DETAIL_COOKING_STATUS;
        $order_details_cooked_status   = StatusConstance::ORDER_DETAIL_COOKED_STATUS;
        

        $ordersRaw          = DB::select("SELECT * FROM `order` WHERE status = '$order_status' OR status = '$order_paid_status' ORDER BY id DESC");
        $order_detailsRaw   = DB::select("SELECT order_details.*,items.name,items.category_id,items.image,items.has_continent,continent.name AS continent_name
                                          FROM `order_details`
                                          LEFT JOIN `items` ON order_details.item_id=items.id
                                          LEFT JOIN `category` ON category.id = items.category_id
                                          LEFT JOIN `continent` ON continent.id = items.continent_id
                                          WHERE order_details.status_id IN ($order_details_cooking_status,$order_details_cooked_status) ");
        
        $set_menusRaw       = DB::select("SELECT order_setmenu_detail.*,items.name,items.category_id,items.image,items.has_continent,continent.name AS continent_name
                                          FROM `order_setmenu_detail`
                                          LEFT JOIN `items` ON order_setmenu_detail.item_id = items.id
                                          LEFT JOIN `category` ON category.id = items.category_id
                                          LEFT JOIN `continent` ON continent.id = items.continent_id
                                          WHERE order_setmenu_detail.status_id IN ($order_setmenu_cooking_status,$order_setmenu_cooked_status) ");

        $categoryRaw        = DB::select("SELECT id FROM category WHERE kitchen_id = $kitchen->id AND deleted_at is NULL");
        $categoryIdArr      = array();
        foreach($categoryRaw as $category){
            array_push($categoryIdArr,$category->id);
        }

        // looping for orders
        $results        = array();
        $orders         = array();
        $order_details  = array();
        $set_menus      = array();
        $categories     = array();

        foreach ($ordersRaw as $key => $order) {
            $orders[$order->id]   = $order;
        }

        foreach ($orders as $key => $order) {
            $order_id = $order->id;
            $orderItemList = array();

            foreach ($order_detailsRaw as $keyOD => $order_detail) {

                $order_detail_id            = $order_detail->id;
                $item_id                    = $order_detail->item_id;
                $setmenu_id                 = $order_detail->setmenu_id;
                $order_detail_order_id      = $order_detail->order_id;
                $order_detail_category_id   = $order_detail->category_id;

                if($order_detail_order_id == $order_id){
                    // Set Menu Case
                    if($item_id == 0){

                        foreach ($set_menusRaw as $keySM => $set_menu) {
                            
                            $setMenuOrderDetailId   = $set_menu->order_detail_id;
                            $setMenuSetMenuId       = $set_menu->setmenu_id;
                            $setMenuItemId          = $set_menu->item_id;
                            $setCategoryId          = $set_menu->category_id;
                            
                            if($order_detail_id == $setMenuOrderDetailId && $setmenu_id == $setMenuSetMenuId && in_array($setCategoryId,$categoryIdArr)){
                                // need to add the item array
                                array_push($orderItemList,$set_menu);
                            }
                        }
                    }
                    // normal item case
                    if($setmenu_id == 0 && in_array($order_detail_category_id,$categoryIdArr)){
                        array_push($orderItemList,$order_detail);
                    }
                }
            }
            $orders[$key]->items = $orderItemList;
        }
        foreach($orders as $orderKey=>$orderValue)
        {
            if(isset($orderValue->items) && count($orderValue->items) > 0)
            {
                $orderItem[$orderKey]  = $orderValue;
            }
        }
        return \Response::json(($orderItem));
    }

    public function ajaxRequest(Request $request)
    {
        $id                  = Auth::guard('Cashier')->user()->kitchen_id;
        $kitchen             = Kitchen::find($id);
        $tables              = $this->OrderRepository->orderTable();
        $rooms               = $this->OrderRepository->orderRoom();
        $extra               = $this->OrderRepository->orderExtra(); 
        
        //Status Lists
        $order_status                  = StatusConstance::ORDER_CREATE_STATUS;
        $order_paid_status             = StatusConstance::ORDER_PAID_STATUS;
        //Order Detail Status
        $order_details_cooking_status  = StatusConstance::ORDER_DETAIL_COOKING_STATUS;
        $order_details_cooked_status   = StatusConstance::ORDER_DETAIL_COOKED_STATUS;
        //Setmenu Status
        $order_setmenu_cooking_status  = StatusConstance::ORDER_SETMENU_COOKING_STATUS;
        $order_setmenu_cooked_status   = StatusConstance::ORDER_SETMENU_COOKED_STATUS;

        $ordersRaw           = DB::select("SELECT * FROM `order` WHERE status = '$order_status' OR status = '$order_paid_status' ORDER BY id DESC");
        
        $order_detailsRaw   = DB::select("SELECT order_details.*,items.name,items.category_id,items.image,items.has_continent,continent.name AS continent_name
                                          FROM `order_details`
                                          LEFT JOIN `items` ON order_details.item_id=items.id
                                          LEFT JOIN `category` ON category.id = items.category_id
                                          LEFT JOIN `continent` ON continent.id = items.continent_id
                                          WHERE order_details.status_id IN ($order_details_cooking_status,$order_details_cooked_status) ");

        $set_menusRaw       = DB::select("SELECT order_setmenu_detail.*,items.name,items.category_id,items.image,items.has_continent,continent.name AS continent_name
                                          FROM `order_setmenu_detail`
                                          LEFT JOIN `items` ON order_setmenu_detail.item_id = items.id
                                          LEFT JOIN `category` ON category.id = items.category_id
                                          LEFT JOIN `continent` ON continent.id = items.continent_id
                                          WHERE order_setmenu_detail.status_id IN ($order_setmenu_cooking_status,$order_setmenu_cooked_status) ");
        
        $categoryRaw        = DB::select("SELECT id FROM category WHERE kitchen_id = $kitchen->id AND deleted_at is NULL");
        $categoryIdArr      = array();
        foreach($categoryRaw as $category){
            array_push($categoryIdArr,$category->id);
        }

        // looping for orders
        $results        = array();
        $orders         = array();
        $order_details  = array();
        $set_menus      = array();
        $categories     = array();

        foreach ($ordersRaw as $key => $order) {
            $orders[$order->id]   = $order;
        }
        foreach($categoryRaw as $key => $category){
            $categories[$category->id] = $category;
        }

        foreach ($orders as $key => $order) {
            $order_id = $order->id;
            $orderItemList = array();

            foreach ($order_detailsRaw as $keyOD => $order_detail) {
                
                $order_detail_id            = $order_detail->id;
                $item_id                    = $order_detail->item_id;
                $setmenu_id                 = $order_detail->setmenu_id;
                $order_detail_order_id      = $order_detail->order_id;
                $order_detail_category_id   = $order_detail->category_id;
                
                if($order_detail_order_id == $order_id){
                    // Set Menu Case
                    if($item_id == 0){
                        foreach ($set_menusRaw as $keySM => $set_menu) {
                        
                            $setMenuOrderDetailId   = $set_menu->order_detail_id;
                            $setMenuSetMenuId       = $set_menu->setmenu_id;
                            $setMenuItemId          = $set_menu->item_id;
                            $setCategoryId          = $set_menu->category_id;
                            if($order_detail_id == $setMenuOrderDetailId && $setmenu_id == $setMenuSetMenuId && in_array($setCategoryId,$categoryIdArr)){
                                // need to add the item array
                                array_push($orderItemList,$set_menu);
                            }
                        }
                    }
                    // normal item case
                    if($setmenu_id == 0 && in_array($order_detail_category_id,$categoryIdArr)){
                        array_push($orderItemList,$order_detail);
                    }
                }
            }

            $orders[$key]->items = $orderItemList;
        }
        return view('kitchen.realtime_tableview')->with('tables',$tables)->with('orders',$orders)->with('rooms',$rooms)->with('extra',$extra)->render();

    }
    public function productView()
    {
        $id              = Auth::guard('Cashier')->user()->kitchen_id;
        $kitchen         = Kitchen::find($id);
        $tables          = $this->OrderRepository->orderTable();
        $rooms           = $this->OrderRepository->orderRoom();
        $extra           = $this->OrderRepository->orderExtra(); 
        $itemsMater      = DB::select("SELECT id,name,image,has_continent FROM `items`");

        //Status Lists
        $order_status                  = StatusConstance::ORDER_CREATE_STATUS;
        $order_paid_status             = StatusConstance::ORDER_PAID_STATUS;
        //Order Detail Status
        $order_details_cooking_status  = StatusConstance::ORDER_DETAIL_COOKING_STATUS;
        $order_details_cooked_status   = StatusConstance::ORDER_DETAIL_COOKED_STATUS;
        //Setmenu Status
        $order_setmenu_cooking_status  = StatusConstance::ORDER_SETMENU_COOKING_STATUS;
        $order_setmenu_cooked_status   = StatusConstance::ORDER_SETMENU_COOKED_STATUS;
        
        $product         = array();
        foreach($itemsMater as $item){
            $item_id        = $item->id;
            $has_continent  = $item->has_continent;

            $orderDetails = DB::select("SELECT i.id, i.name, i.has_continent, ct.name AS continent_name, c.kitchen_id,
            o.id as order_id, o.take_id, od1.order_time,od1.order_duration,od1.quantity,
            od1.remark,od1.setmenu_id,
            od1.id as order_detail_id, od1.exception,od1.status_id
            FROM items AS i
            INNER JOIN order_details AS od1 ON i.id = od1.item_id
            INNER JOIN  `order` AS o ON od1.order_id = o.id
            INNER JOIN category AS c ON i.category_id = c.id
            LEFT JOIN continent AS ct ON i.continent_id = ct.id
            WHERE o.status IN ($order_status,$order_paid_status) AND
            od1.item_id = $item_id AND c.kitchen_id = $kitchen->id AND od1.status_id IN ($order_details_cooking_status,$order_details_cooked_status)");
            
            $setMenus = DB::select("SELECT os.item_id,os.id,os.exception,os.remark,os.status_id,os.order_duration,
            c.kitchen_id,i.name,o.take_id,os.order_time,os.setmenu_id,
            os.order_type_id,os.quantity,od1.id as order_detail_id,
            od1.setmenu_id,od1.order_id
            FROM order_setmenu_detail AS os
            INNER JOIN order_details AS od1 ON os.order_detail_id = od1.id
            INNER JOIN `order` AS o ON od1.order_id = o.id
            -- LEFT JOIN order_tables AS ot ON ot.order_id = o.id
            -- LEFT JOIN tables AS t ON ot.table_id = t.id
            INNER JOIN items AS i ON i.id = os.item_id
            INNER JOIN category AS c ON i.category_id = c.id
            WHERE o.status IN ($order_status,$order_paid_status) AND
            os.item_id = $item_id AND c.kitchen_id = $kitchen->id AND os.status_id IN ($order_setmenu_cooking_status,$order_setmenu_cooked_status)");

            if($orderDetails != null || $setMenus != null){
                $tempItem                   = array();
                $tempItem['item_id']        = $item_id;
                $tempItem['item_name']      = $item->name;
                $tempItem['item_image']     = $item->image;
                $tempItem['has_continent']  = $has_continent;
                // If have Continent
                if ($has_continent == 1) {
                    foreach($orderDetails as $orderDetail) {
                        $continent      = $orderDetail->continent_name;
                    }
                    $tempItem['continent']  = $continent; 
                } else {
                    $tempItem['continent']  = '';
                }
                $tempItem['product_order']  = $orderDetails;   
                $tempItem['setmenu']        = $setMenus; 
                $product[]                  = $tempItem;

            }
        }
        return view('kitchen.productView')->with('product',$product)->with('tables',$tables)->with('rooms',$rooms)->with('extra',$extra);
    }
    public function ajaxRequestProduct(Request $request)
    {
        $id              = Auth::guard('Cashier')->user()->kitchen_id;
        $kitchen         = Kitchen::find($id);
        $tables          = $this->OrderRepository->orderTable();
        $rooms           = $this->OrderRepository->orderRoom();
        $extra           = $this->OrderRepository->orderExtra(); 

        $itemsMater      = DB::select("SELECT id,name,image,has_continent FROM `items`");
        $product         = array();

        //Status Lists
        $order_status                  = StatusConstance::ORDER_CREATE_STATUS;
        $order_paid_status             = StatusConstance::ORDER_PAID_STATUS;
        //Order Detail Status
        $order_details_cooking_status  = StatusConstance::ORDER_DETAIL_COOKING_STATUS;
        $order_details_cooked_status   = StatusConstance::ORDER_DETAIL_COOKED_STATUS;
        //Setmenu Status
        $order_setmenu_cooking_status  = StatusConstance::ORDER_SETMENU_COOKING_STATUS;
        $order_setmenu_cooked_status   = StatusConstance::ORDER_SETMENU_COOKED_STATUS;

        foreach($itemsMater as $item){
            $item_id = $item->id;
            $has_continent  = $item->has_continent;

            $orderDetails = DB::select("SELECT i.id, i.name, i.has_continent, ct.name AS continent_name, c.kitchen_id,
            o.id as order_id, o.take_id, od1.order_time,od1.order_duration,od1.quantity,
            od1.remark,od1.setmenu_id,
            od1.id as order_detail_id, od1.exception,od1.status_id
            FROM items AS i
            INNER JOIN order_details AS od1 ON i.id = od1.item_id
            INNER JOIN  `order` AS o ON od1.order_id = o.id
            INNER JOIN category AS c ON i.category_id = c.id
            LEFT JOIN continent AS ct ON i.continent_id = ct.id
            WHERE o.status IN ($order_status,$order_paid_status) AND 
            od1.item_id = $item_id AND c.kitchen_id = $kitchen->id AND od1.status_id IN ($order_details_cooking_status,$order_details_cooked_status)");
        
            $setMenus = DB::select(" SELECT os.item_id,os.id,os.exception,os.remark,os.status_id,os.order_duration,c.kitchen_id,i.name,o.take_id,os.order_time,os.setmenu_id,os.order_type_id,os.quantity,od1.id as order_detail_id,od1.setmenu_id,od1.order_id
            FROM order_setmenu_detail AS os
            INNER JOIN order_details AS od1 ON os.order_detail_id = od1.id
            INNER JOIN `order` AS o ON od1.order_id = o.id
            -- LEFT JOIN order_tables AS ot ON ot.order_id = o.id
            -- LEFT JOIN tables AS t ON ot.table_id = t.id
            INNER JOIN items AS i ON i.id = os.item_id
            INNER JOIN category AS c ON i.category_id = c.id
            WHERE o.status IN ($order_status,$order_paid_status) AND 
            os.item_id = $item_id AND c.kitchen_id = $kitchen->id AND os.status_id IN ($order_setmenu_cooking_status,$order_setmenu_cooked_status)");

            if($orderDetails != null || $setMenus != null){
                $tempItem                   = array();
                $tempItem['item_id']        = $item_id;
                $tempItem['item_name']      = $item->name;
                $tempItem['item_image']     = $item->image;
                $tempItem['has_continent']  = $has_continent;
                // If have Continent
                if ($has_continent == 1) {
                    foreach($orderDetails as $orderDetail) {
                        $continent      = $orderDetail->continent_name;
                    }
                    $tempItem['continent']  = $continent; 
                } else {
                    $tempItem['continent']  = '';
                }
                $tempItem['product_order']  = $orderDetails;   
                $tempItem['setmenu']        = $setMenus; 
                $product[]                  = $tempItem;

            }
        }
        return view('kitchen/realtime_product')->with('product',$product)->with('tables',$tables)->with('rooms',$rooms)->with('extra',$extra)->render();
    }

    public function start($id,$setmenu_id)
    {
        $carbon  = Carbon::now();
        $date    = $carbon->toDateTimeString();
        //Order Detail Status
        $order_details_cooked_status   = StatusConstance::ORDER_DETAIL_COOKED_STATUS;
        $order_setmenu_cooked_status   = StatusConstance::ORDER_SETMENU_COOKED_STATUS;

        if($id != 0 && $setmenu_id == 0){
            DB::statement('update order_details set status_id=?, order_duration=? where id=?',[$order_details_cooked_status,$date, $id]);
        }
        else{
            $setMenu                        = OrderSetMenuDetail::find($id);
            $orderDetail                    = OrderDetail::find($setMenu->order_detail_id);
            if($orderDetail->status_id == 1){
                $orderDetail->order_duration    = $date;
                $orderDetail->status_id         = $order_details_cooked_status;
                $orderDetail->save();
            }

            DB::statement('update order_setmenu_detail set status_id=?, order_duration=? where id=?',[$order_setmenu_cooked_status,$date, $id]);

            
        }
        return redirect()->action('Kitchen\OrderViewController@tableView');
    }

    public function itemStart($id,$setmenu_id)
    {
        $carbon  = Carbon::now();
        $date    = $carbon->toDateTimeString();
        //Order Detail Status
        $order_details_cooked_status   = StatusConstance::ORDER_DETAIL_COOKED_STATUS;
        //Setmenu Status
        $order_setmenu_cooked_status   = StatusConstance::ORDER_SETMENU_COOKED_STATUS;
        if($id != 0 && $setmenu_id == 0){
            DB::statement('update order_details set status_id=?, order_duration=? where id=?',[$order_details_cooked_status,$date, $id]);
            $orders     = Orderdetail::where('id','=',$id)->get()->toArray();
        }
        else{
            $setMenu                        = OrderSetMenuDetail::find($id);
            $orderDetail                    = OrderDetail::find($setMenu->order_detail_id);
            if($orderDetail->status_id == 1){
                $orderDetail->order_duration    = $date;
                $orderDetail->status_id         = $order_details_cooked_status;
                $orderDetail->save();
            }

            DB::statement('update order_setmenu_detail set status_id=?, order_duration=? where id=?',[$order_setmenu_cooked_status,$date, $id]);
            $orders     = Orderdetail::where('id','=',$setMenu->order_detail_id)->get()->toArray();;
        }

        foreach($orders as $key => $order) {
            $clickID            = $id . "/" . $setmenu_id;
            $output             = $order;
            $output['click_id'] = $clickID;
        }
        return \Response::json(($output));
    }

    public function update($item_id,$setmenu_id)
    {
        $carbon = Carbon::now();
        $date   = $carbon->toDateTimeString();

        //Order Detail Status
        $order_details_done_status     = StatusConstance::ORDER_DETAIL_COOKING_DONE_STATUS;
        //Setmenu Status
        $order_setmenu_done_status     = StatusConstance::ORDER_SETMENU_COOKING_DONE_STATUS;

        if($item_id != 0 && $setmenu_id == 0){
            DB::statement('update order_details set status_id=?, cooking_time=? where id=?', [$order_details_done_status,$date,$item_id]);
        }
        else{
            DB::statement('update order_setmenu_detail set status_id=?, cooking_time=? where id=?', [$order_setmenu_done_status,$date,$item_id]);

            $order_setmenu                  = DB::table('order_setmenu_detail')
                                              ->where('id',$item_id)
                                              ->where('setmenu_id',$setmenu_id)
                                              ->first();
            $order_detail_id                = $order_setmenu->order_detail_id;

            $order_setmenu_without_status   = DB::table('order_setmenu_detail')
                ->where('order_detail_id',$order_detail_id)
                ->where('setmenu_id',$setmenu_id)
                ->get();
            $count_without_status           = count($order_setmenu_without_status);

            $order_setmenu_with_status      = DB::table('order_setmenu_detail')
                ->where('order_detail_id',$order_detail_id)
                ->where('setmenu_id',$setmenu_id)
                ->where('status_id','=',$order_setmenu_done_status)
                ->get();
            $count_with_status              = count($order_setmenu_with_status);

            if($count_with_status == $count_without_status){
                DB::statement('update order_details set status_id =?, cooking_time=? where id=?',[$order_details_done_status,$date,$order_detail_id]);
            }
        }
        $output     = array('message'=>'success');
        return \Response::json($output);
        // return redirect()->action('Kitchen\OrderViewController@tableView');
    }

    public function CookingItemFromProductView($item_id)
    {
        $carbon  = Carbon::now();
        $date    = $carbon->toDateTimeString();
        $order_details_cooked_status   = StatusConstance::ORDER_DETAIL_COOKED_STATUS;

        DB::statement('update order_details set status_id=?, order_duration=? where id=?',[$order_details_cooked_status,$date, $item_id]);
        $output     = array('message'=>'success');
        return \Response::json($output);
        // return redirect()->action('Kitchen\OrderViewController@productView');
    }

    public function CookedItemFromProductView($item_id)
    {

        $carbon = Carbon::now();
        $date   = $carbon->toDateTimeString();
        //Order Detail Status
        $order_details_done_status     = StatusConstance::ORDER_DETAIL_COOKING_DONE_STATUS;

        $db = DB::statement('update order_details set status_id=?, cooking_time=? where id=?', [$order_details_done_status,$date,$item_id]);
        $output     = array('message'=>'success');
        return \Response::json($output);
        // return redirect()->action('Kitchen\OrderViewController@productView');
    }

    public function CookingSetMenuItemFromProductView($id){

        $carbon             = Carbon::now();
        $date               = $carbon->toDateTimeString();

        //Order Detail Status
        $order_details_cooked_status   = StatusConstance::ORDER_DETAIL_COOKED_STATUS;
        //Setmenu Status
        $order_setmenu_cooked_status   = StatusConstance::ORDER_SETMENU_COOKED_STATUS;

        DB::statement('update order_setmenu_detail set status_id =?, order_duration=? where id=?',[$order_setmenu_cooked_status,$date,$id]);
        $set_menu           = DB::table('order_setmenu_detail')->where('id',$id)->first();
        $order_detail_id    = $set_menu->order_detail_id;
        $order_detail       = Orderdetail::find($order_detail_id);
        if($order_detail->status == 1){
            DB::statement('update order_details set status_id =$order_details_cooked_status, order_duration=? where id=?',[$date,$order_detail_id]);
        }
        $output     = array('message'=>'success');
        return \Response::json($output);
        // return redirect()->action('Kitchen\OrderViewController@productView');
    }

    public function CookedSetMenuItemFromProductView($id){
        $carbon                         = Carbon::now();
        $date                           = $carbon->toDateTimeString();
        //Order Detail Status
        $order_details_done_status     = StatusConstance::ORDER_DETAIL_COOKING_DONE_STATUS;
        //Setmenu Status
        $order_setmenu_done_status     = StatusConstance::ORDER_SETMENU_COOKING_DONE_STATUS;

        DB::statement('update order_setmenu_detail set status_id =?, cooking_time=? where id=?',[$order_setmenu_done_status,$date,$id]);

        $order_setmenu                  = DB::table('order_setmenu_detail')->where('id',$id)->first();

        $order_detail_id                = $order_setmenu->order_detail_id;
        $setmenu_id                     = $order_setmenu->setmenu_id;

        $order_setmenu_without_status   = DB::table('order_setmenu_detail')
                                          ->where('order_detail_id',$order_detail_id)
                                          ->where('setmenu_id',$setmenu_id)
                                          ->get();
        $count_without_status           = count($order_setmenu_without_status);

        $order_setmenu_with_status      = DB::table('order_setmenu_detail')
                                          ->where('order_detail_id',$order_detail_id)
                                          ->where('setmenu_id',$setmenu_id)
                                          ->where('status_id','=',$order_setmenu_done_status)
                                          ->get();
        $count_with_status              = count($order_setmenu_with_status);

        if($count_with_status == $count_without_status){
            DB::statement('update order_details set status_id =?, cooking_time=? where id=?',[$order_details_done_status,$date,$order_detail_id]);
        }
        $output     = array('message'=>'success');
        return \Response::json($output);
        // return redirect()->action('Kitchen\OrderViewController@productView');
    }

    public function CancelUpdateFromTableView()
    {
        
        $id             = Input::get('order_details_id');
        $setmenu_id     = Input::get('setmenu_id');
        $date           = date('Y-m-d H:m:i');
        $message        = Input::get('message');
        $order_detail   = Orderdetail::find($id);
        $order_id       = $order_detail->order_id;
        $price          = $order_detail->amount_with_discount;
        $config         = Config::select('tax','service')->first();
        $tax            = $config->tax;
        $service        = $config->service;
        
        //Order Detail Status
        $order_details_cancel_status   = StatusConstance::ORDER_DETAIL_KITCHEN_CANCEL_STATUS;
        //Setmenu Status
        $order_setmenu_cancel_status   = StatusConstance::ORDER_SETMENU_KITCHEN_CANCEL_STATUS;

        if($setmenu_id != 0){
            $setObj = OrderSetMenuDetail::where('order_detail_id',$id)->where('setmenu_id','=',$setmenu_id)->get();
            foreach($setObj as $set){
                $set            = OrderSetMenuDetail::where('id','=',$set->id)->first();
                $set->status_id = $order_setmenu_cancel_status;
                $set->message   = $message;
                $set->save();
            }

            $order                      = Order::where('id','=',$order_id)->first();
            $total                      = (($order->total_price) - ($price));
            $service_amount             = ($total * $service)/(100);
            $tax_amount                 = ($total * $tax)/(100);
            $all_total_amount           = $total + $service_amount + $tax_amount;
            $order->total_price         = $total;
            $order->service_amount      = $service_amount;
            $order->tax_amount          = $tax_amount;
            $order->all_total_amount    = $all_total_amount;
            $order->save();

            $order_detail->status_id = $order_details_cancel_status;
            $order_detail->message   = $message;
            
            $order_detail->save();

        }else{
            $order_detail   = Orderdetail::find($id);

            $order_id = $order_detail->order_id;
            $price    = $order_detail->amount_with_discount;   

            $order                      = Order::where('id','=',$order_id)->first();
            $total                      = (($order->total_price) - ($price));
            $service_amount             = ($total * $service)/(100);
            $tax_amount                 = ($total * $tax)/(100);
            $all_total_amount           = $total + $service_amount + $tax_amount;
            $order->total_price         = $total;
            $order->service_amount      = $service_amount;
            $order->tax_amount          = $tax_amount;
            $order->all_total_amount    = $all_total_amount;
            $order->save();

            $order_detail->status_id = $order_details_cancel_status;
            $order_detail->message   = $message;
            
            $order_detail->save();
        }
        // return redirect()->action('Kitchen\OrderViewController@tableView');
        
        $output     = array('message'=>'success','order_id'=> $order_id);
        return \Response::json($output);
    }

    public function CancelUpdateFromProductView()
    {
        $id             = Input::get('order_details_id');
        $setmenu_id     = Input::get('setmenu_id');
        $date           = date('Y-m-d H:m:i');
        $message        = Input::get('message');
        $order_detail   = Orderdetail::find($id);
        $order_id       = $order_detail->order_id;
        $price          = $order_detail->amount_with_discount;
        $config         = Config::select('tax','service')->first();
        $tax            = $config->tax;
        $service        = $config->service;

        //Order Detail Status
        $order_details_cancel_status   = StatusConstance::ORDER_DETAIL_KITCHEN_CANCEL_STATUS;
        //Setmenu Status
        $order_setmenu_cancel_status   = StatusConstance::ORDER_SETMENU_KITCHEN_CANCEL_STATUS;//

        if($setmenu_id != 0){
            $setObj = OrderSetMenuDetail::where('order_detail_id',$id)->where('setmenu_id','=',$setmenu_id)->get();
            foreach($setObj as $set){
                $set            = OrderSetMenuDetail::where('id','=',$set->id)->first();
                $set->status_id = $order_setmenu_cancel_status;
                $set->message   = $message;
                $set->save();
            }

            $order                      = Order::where('id','=',$order_id)->first();
            $total                      = (($order->total_price) - ($price));
            $service_amount             = ($total * $service)/(100);
            $tax_amount                 = ($total * $tax)/(100);
            $all_total_amount           = $total + $service_amount + $tax_amount;
            $order->total_price         = $total;
            $order->service_amount      = $service_amount;
            $order->tax_amount          = $tax_amount;
            $order->all_total_amount    = $all_total_amount;
            $order->save();

            $order_detail->status_id = 6;
            $order_detail->message   = $message;

            $order_detail->save();
        }else{
            $order_detail   = Orderdetail::find($id);

            $order_id = $order_detail->order_id;
            $price    = $order_detail->amount_with_discount;

            $order                      = Order::where('id','=',$order_id)->first();
            $total                      = (($order->total_price) - ($price));
            $service_amount             = ($total * $service)/(100);
            $tax_amount                 = ($total * $tax)/(100);
            $all_total_amount           = $total + $service_amount + $tax_amount;
            $order->total_price         = $total;
            $order->service_amount      = $service_amount;
            $order->tax_amount          = $tax_amount;
            $order->all_total_amount    = $all_total_amount;
            $order->save();

            $order_detail->status_id = $order_details_cancel_status;
            $order_detail->message   = $message;

            $order_detail->save();
        }
        $output     = array('message'=>'success','order_id'=> $order_id);
        return \Response::json($output);
        // return redirect()->action('Kitchen\OrderViewController@productView');
    }
}
