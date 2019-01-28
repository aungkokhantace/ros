<?php
namespace App\RMS\Orderdetail;
use App\RMS\Order\Order;
use App\RMS\Orderdetail\Orderdetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\RMS\Category\Category;
use App\RMS\Item\Item;
use App\RMS\OrderTable\OrderTable;
use App\RMS\OrderRoom\OrderRoom;
use App\RMS\OrderExtra\OrderExtra;
use App\RMS\OrderSetMenuDetail\OrderSetMenuDetail;
use App\RMS\SetItem\SetItem;
use App\RMS\Kitchen\Kitchen;
use App\RMS\SetMenu\SetMenu;
use App\RMS\Item\Continent;
use App\Status\StatusConstance;
use App\RMS\Utility;
use App\RMS\ReturnMessage;

class OrderdetailRepository implements OrderdetailRepositoryInterface
{
    public function store($paramObj){
        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

        try {
            $tempObj        = Utility::addCreatedBy($paramObj);
            $tempObj->save();
            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            return $returnedObj;
        }
        catch(Exception $e){

            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }

    }

    public function getCategoriesByParent($parent_id,$shift_id) {
      // dd("repo",$parent_id,$shift_id);
        $restaurant         = Utility::getCurrentRestaurant();
        $branch             = Utility::getCurrentBranch();

        $status             = StatusConstance::CATEGORY_AVAILABLE_STATUS;

        // $categories         = Category::where('parent_id',$parent_id)
        //                       ->where('status',$status)
        //                       ->where('deleted_at',NULL)
        //                       ->where('restaurant_id',$restaurant)
        //                       ->where('branch_id',$branch)
        //                       ->get();
        $categories         = Category::join('shift_category','shift_category.category_id','=','category.id')
                              ->where('category.parent_id',$parent_id)
                              ->where('category.status',$status)
                              ->whereNull('category.deleted_at')
                              ->whereNull('shift_category.deleted_at')
                              ->where('category.restaurant_id',$restaurant)
                              ->where('category.branch_id',$branch)
                              ->where('shift_category.shift_id',$shift_id)
                              ->select('category.*')
                              ->get();
       //dd('mm0',$categories);
        return $categories;
    }

    public function getSetMenu($shift_id) {
      $restaurant   = Utility::getCurrentRestaurant();
      $branch       = Utility::getCurrentBranch();

      $status       = StatusConstance::SETMENU_AVAILABLE_STATUS;
      // $setmenu      = SetMenu::select('id','set_menus_name','image')
      //                 ->where('status',$status)
      //                 ->whereNull('deleted_at')
      //                 ->where('restaurant_id',$restaurant)
      //                 ->where('branch_id',$branch)
      //                 ->get();
      $setmenu         = SetMenu::join('shift_setmenu','shift_setmenu.setmenu_id','=','set_menu.id')                              
                              ->where('set_menu.status',$status)
                              ->whereNull('set_menu.deleted_at')
                              ->whereNull('shift_setmenu.deleted_at')
                              ->where('set_menu.restaurant_id',$restaurant)
                              ->where('set_menu.branch_id',$branch)
                              ->where('shift_setmenu.shift_id',$shift_id)
                              ->select('set_menu.id','set_menu.set_menus_name','set_menu.image')
                              ->get();
      //dd('set menu',$setmenu);
      return $setmenu;
    }

    public function getSetItemBySetID($id) {
        $status        = StatusConstance::SETMENU_AVAILABLE_STATUS;
        $set_items      = SetItem::select('id','item_id')
                          ->where('set_menu_id',$id)
                          ->whereNull('deleted_at')
                          ->get();
        return $set_items;
    }

    public function getItemsByCategory($categoryID) {
        $status             = StatusConstance::ITEM_AVAILABLE_STATUS;
        $items              = Item::where('category_id',$categoryID)
                              ->where('status',$status)
                              ->where('deleted_at',NULL)
                              ->get();
        return $items;
    }

    public function getBackCategoryByID($id,$shift_id) {
        $status             = StatusConstance::CATEGORY_AVAILABLE_STATUS;
        $restaurant         = Utility::getCurrentRestaurant();
        $branch             = Utility::getCurrentBranch();
        // $category           = Category::where('parent_id',$id)
        //                       ->where('status',$status)
        //                       ->where('deleted_at',NULL)
        //                       ->get();
        $category         = Category::join('shift_category','shift_category.category_id','=','category.id')
                              ->where('category.parent_id',$id)
                              ->where('category.status',$status)
                              ->whereNull('category.deleted_at')
                              ->where('category.restaurant_id',$restaurant)
                              ->where('category.branch_id',$branch)
                              ->where('shift_category.shift_id',$shift_id)
                              ->select('category.*')
                              ->get();
        // dd("get back cat", $category );
        return $category;
    }
   public function getCategories(){
    $categories = Category::where('parent_id',0)->where('deleted_at',NULL)->get();
    return $categories;
   }
   public function getitem($id){
      $category    = Item::find($id);
      $category_id = $category->category_id;

      $items = Item::where('category_id',$category_id)->where('deleted_at',NULL)->get();
      return $items;
   }
   public function categoryDetail($id){
     	$categories    = Category::where('parent_id',$id)->where('deleted_at',NULL)->get()->count();
      
      if($categories == 0){
         $items = Item::where('category_id',$id)->where('deleted_at',NULL)->get();

         return $items;
      }
      if($categories > 0){
         $categoryObj = Category::where('parent_id',$id)->where('deleted_at',NULL)->get();
         return $categoryObj;
      }
      
    
   }
   public function searchItem($id){
   	$category_id = $id;
   	$items = Item::all();
   	$products = array();
   	foreach ($items as $item){
   		$categories = Category::select('id')->where('id',$item->category_id)->get();
   		if(isset($categories)){
   			foreach($categories as $category){
   				if($category->id == $category_id){
   					array_push($products,$item);
   				}
   			}
   		}
   	}
   	return $products;
   	//dd($products);
   }

   public function getorder($id)
    {
        $status     = StatusConstance::ORDER_CREATE_STATUS;
        $orders = Order::select('id as order_id','take_id','service_amount','foc_amount','tax_amount','order_time','member_discount','member_discount_amount','member_id','total_price','total_extra_price','all_total_amount','payment_amount','total_discount_amount','refund','total_price_foc','room_charge','day_id','shift_id')
        ->where('status',$status)
        ->where('id',$id)->first()->toArray();
        
        return $orders;
    }

    public function getdetail($id){
        $order_kitchen_cancel_status    = StatusConstance::ORDER_DETAIL_KITCHEN_CANCEL_STATUS;
        $order_customer_cancel_status   = StatusConstance::ORDER_DETAIL_CUSTOMER_CANCEL_STATUS;

        $order_details = Orderdetail::leftjoin('order','order_details.order_id','=','order.id')
        ->leftjoin('items','items.id','=','order_details.item_id')
        ->leftjoin('set_menu','set_menu.id','=','order_details.setmenu_id')
        ->leftjoin('users','users.id','=','order.user_id')
        ->leftjoin('continent','continent.id','=','items.continent_id')
        ->select('items.name as item_name','items.has_continent','items.continent_id','items.id as item_id','items.category_id','set_menu.set_menus_name as set_name','set_menu.id as set_id','continent.name as continent_name','order_details.quantity','order_details.take_item',
                'order_details.discount_amount','order_details.amount','order_details.id as order_detail_id',
                'users.user_name','order.id',
            'order_details.amount_with_discount','order_details.status_id as detail_status')
        ->where('order_id','=',$id)
        ->whereNotIn('status_id',[$order_kitchen_cancel_status,$order_customer_cancel_status])->get()->toArray();
        return $order_details;
        
    }
   public function getsetmenudetail($orderdetailID){
        $order_setmenu_details = OrderSetMenuDetail::leftjoin('order_details','order_setmenu_details.order_detail_id','=','order_detail.id')
                  ->leftjoin('set_menu','set_menu_id','=','order_setmenu_details.setmenu_id')
                  ->leftjoin('items','items.id','=','order_setmenu_details.item_id')
                  ->select('item.name as item_name', 'item.id as item_id','setmenu.id as setmenu_id','setmenu.set_menus_name as setmenu_name','order_setmenu_details.quantity','order_setmenu_details.take_item','order_detail_id')
                  ->where('order_detail_id','=',$orderdetailID);
        return $order_setmenu_details;
    }

    public function cashier($id){
        $cashier = Order::where('id','=',$id)->first();

        return $cashier;
    }

     public function orderTable($id){
        $tables = OrderTable::leftjoin('tables','order_tables.table_id','=','tables.id')
        ->select('tables.table_no')->where('order_tables.order_id','=',$id)->get()->toArray();

        return $tables;
    }

    public function orderRoom($id){
        $rooms = OrderRoom::leftjoin('rooms','rooms.id','=','order_room.room_id')
        ->select('rooms.room_name')->where('order_room.order_id','=',$id)->get()->toArray();
      
        return $rooms;
    }

    public function getaddon($id){
        $status         = StatusConstance::ORDER_EXTRA_AVAILABLE_STATUS;
        $addon = array();
        $addon = OrderExtra::select('extra_id','amount','quantity')
                        ->where('order_extra.order_detail_id','=',$id)
                        ->where('order_extra.status','=',$status)
                        ->where('order_extra.deleted_at','=',NULL)
                        ->get()->toArray();
        
        return $addon;
    }

    public function getaddonAmount($id){
        $status         = StatusConstance::ORDER_EXTRA_AVAILABLE_STATUS;
        $order_details = Orderdetail::where('order_id','=', $id)->where('deleted_at','=',NULL)->get();
        $addon = array();
        foreach($order_details as $order){
            $tempAddon = OrderExtra::leftjoin('add_on','add_on.id','=','order_extra.extra_id')->select('order_extra.*',DB::raw('SUM(order_extra.amount) as amount'),'add_on.food_name')->where('order_extra.order_detail_id','=',$order->id)->where('order_extra.status','=',$status)->where('order_extra.deleted_at','=',NULL)->groupBy('order_extra.order_detail_id')->get()->toArray();
            array_push($addon, $tempAddon);
            
        }
        
        return $addon;
    }

    public function getContinent($itemID) {
        $status        = StatusConstance::ITEM_AVAILABLE_STATUS;
        $continents    = array();
        $itemRepo      = Item::select('group_id')
                      ->where('id',$itemID)
                      ->whereNull('deleted_at')
                      ->first();
        $continents     = Item::leftjoin('continent','items.continent_id','=','continent.id')
                      ->select('items.price','continent.id','continent.name')
                      ->where('items.status',$status)
                      ->where('items.group_id',$itemRepo->group_id)
                      ->whereNull('items.deleted_at')
                      ->get()->toArray();
        return $continents;
    }
     public function getSetMenuByOrder($setmenuID){
         
        $status         = StatusConstance::SETMENU_AVAILABLE_STATUS;
        $addon = array();
        $addon = OrderSetMenuDetail::select('setmenu_id','quantity')
                        ->where('order_setmenu_detail.order_detail_id','=',$id)
                        ->where('order_setmenu_detail.status_id','=',$status)
                        ->where('order_setmenu_detail.deleted_at','=',NULL)
                        ->get()->toArray();
    }
     public function getSetMenuDetailById($orderID){
        $setmenu = Orderdetail::where('order_id',$orderID)->get();
        // select('order_detail.id','setmenu_id','item_id')
        //                 ->where('order_setmenu_detail.order_id','=',$orderID)
        //                 ->where('order_setmenu_detail.deleted_at','=',NULL)
        //                 ->where('set_menu_id','!=',0)
        //                 ->get()->toArray();
        return $setmenu;
     
    }
    public function deletsubmenu($id){
      $tempObj             = OrderSetMenuDetail::where('id',$id)->get();
              foreach ($tempObj as $key => $value) {
      $value               = Utility::addDeletedBy($value);
        $value->deleted_at = date('Y-m-d H:m:i');
             $value->save();
        }
    }
}
