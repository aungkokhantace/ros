<?php
namespace App\RMS\Report;
use App\RMS\Category\Category;
use App\RMS\Favourite\Favourite;
use App\RMS\MemberType\MemberType;
use Illuminate\Support\Facades\DB;
use App\RMS\Orderdetail\Orderdetail;
use App\RMS\Order\Order;
class ReportRepository implements ReportRepositoryInterface
{
    public function getStartDate(){
        $start_date=DB::table('order')->select(DB::raw('min(order_time) as min'))->first();
        return $start_date;

    }

    public function getEndDate(){
        $end_date=DB::table('order')->select(DB::raw('max(order_time) as max'))->first();
        return $end_date;
    }

    
    //Item Report
    public function getItemReport($start_date, $end_date)
    {
        $orders = DB::table('order_details')
            ->leftjoin('items', 'items.id', '=', 'order_details.item_id')
            ->leftjoin('order', 'order.id', '=', 'order_details.order_id')

            ->select('items.name as name','order_details.discount_amount','order_details.amount',DB::raw('SUM(order_details.quantity) as total'),
                DB::raw('(order_details.amount)-(order_details.discount_amount) as price'),DB::raw('(SUM(order_details.quantity))*((order_details.amount)-(order_details.discount_amount)) as total_amt'))
            ->whereBetween('order.order_time', [$start_date->min,$end_date->max])
            ->where('order_details.item_id','!=','null')
            ->where('order.status','=','1')
            ->where('order.deleted_at',NULL)
            ->whereNotNull('order_details.item_id')
            ->groupBy('order_details.item_id')
            ->orderBy('total','desc')
            ->get();

        return $orders;
    }

    public function getExcel($start, $end){
        $orders = Orderdetail::
            leftjoin('items', 'items.id', '=', 'order_details.item_id')
            ->leftjoin('order', 'order.id', '=', 'order_details.order_id')
            ->leftjoin('status','status.id','=','order_details.status_id')
            ->select('items.name as Item_Name',DB::raw('SUM(order_details.quantity) as Quantity'),
                 'order_details.discount_amount as DiscountAmount','order_details.amount as Price',DB::raw('(order_details.amount)-(order_details.discount_amount) as Amount'),DB::raw('(SUM(order_details.quantity))*((order_details.amount)-(order_details.discount_amount)) as TotalAmount'))
            ->whereBetween('order.order_time', [$start->min, $end->max])
            ->where('order_details.item_id','!=','null')
            ->where('order.status','=','1')
            ->where('order.deleted_at',NULL)
            ->whereNotNull('order_details.item_id')
            ->groupBy('order_details.item_id')
            ->orderBy('Quantity','desc')
            ->get();

        return $orders;
    }

    public function getItemReportWithDate($start_date,$end_date,$number,$from_amount,$to_amount){
        $start_date     = $start_date.' 00:00:00';
        $end_date       = $end_date.' 23:00:00';
        if($number == "" && $from_amount == "" && $to_amount == ""){
            $orders = DB::table('order_details')
                ->leftjoin('items', 'items.id', '=', 'order_details.item_id')
                ->leftjoin('order', 'order.id', '=', 'order_details.order_id')
                ->leftjoin('status','status.id','=','order_details.status_id')
                ->select('items.name as name','order_details.discount_amount','order_details.amount',DB::raw('SUM(order_details.quantity) as total'),
                DB::raw('(order_details.amount)-(order_details.discount_amount) as price'),DB::raw('(SUM(order_details.quantity))*((order_details.amount)-(order_details.discount_amount)) as total_amt'),DB::raw('SUM(order_details.amount_with_discount) as net_price') )
                ->whereBetween('order.order_time', [$start_date, $end_date])
                ->where('order.status','=','1')
                ->where('order.deleted_at',NULL)
                ->where('order_details.item_id','!=','null')
                ->whereNotNull('order_details.item_id')
                ->groupBy('order_details.item_id')
                ->orderBy('total','desc')
                ->get();
        }
        elseif($number == "" && $from_amount != "" && $to_amount != ""){
            $orders = DB::table('order_details')
                ->leftjoin('items', 'items.id', '=', 'order_details.item_id')
                ->leftjoin('order', 'order.id', '=', 'order_details.order_id')
                ->leftjoin('status','status.id','=','order_details.status_id')
                ->select('items.name as name','order_details.discount_amount','order_details.amount',DB::raw('SUM(order_details.quantity) as total'),
                    DB::raw('(order_details.amount)-(order_details.discount_amount) as price'),DB::raw('(SUM(order_details.quantity))*((order_details.amount)-(order_details.discount_amount)) as total_amt'), DB::raw('SUM(order_details.amount_with_discount) as net_price'))
                ->whereBetween('order.order_time', [$start_date, $end_date])
                ->where('order.status','=','1')
                ->where('order.deleted_at',NULL)
                ->where('order_details.item_id','!=','null')
                ->whereNotNull('order_details.item_id')
                ->groupBy('order_details.item_id')
                ->having('total_amt','>=',$from_amount)
                ->having('total_amt','<=',$to_amount)
                ->orderBy('total','desc')
                ->get();
        }
        elseif($number != "" && $from_amount == "" && $to_amount == ""){
            $orders = DB::table('order_details')
                ->leftjoin('items', 'items.id', '=', 'order_details.item_id')
                ->leftjoin('order', 'order.id', '=', 'order_details.order_id')
                ->leftjoin('status','status.id','=','order_details.status_id')
                ->select('items.name as name','order_details.discount_amount','order_details.amount',DB::raw('SUM(order_details.quantity) as total'),
                    DB::raw('(order_details.amount)-(order_details.discount_amount) as price'),DB::raw('(SUM(order_details.quantity))*((order_details.amount)-(order_details.discount_amount)) as total_amt'), DB::raw('SUM(order_details.amount_with_discount) as net_price'))
                ->whereBetween('order.order_time', [$start_date, $end_date])
                ->where('order.status','=','1')
                ->where('order.deleted_at',NULL)
                ->where('order_details.item_id','!=','null')
                ->whereNotNull('order_details.item_id')
                ->groupBy('order_details.item_id')
                ->orderBy('total','desc')
                ->take($number)
                ->get();
        }
        else{
            $orders = DB::table('order_details')
                ->leftjoin('items', 'items.id', '=', 'order_details.item_id')
                ->leftjoin('order', 'order.id', '=', 'order_details.order_id')
                ->leftjoin('status','status.id','=','order_details.status_id')
                ->select('items.name as name','order_details.discount_amount','order_details.amount',DB::raw('SUM(order_details.quantity) as total'),
                DB::raw('(order_details.amount)-(order_details.discount_amount) as price'),DB::raw('(SUM(order_details.quantity))*((order_details.amount)-(order_details.discount_amount)) as total_amt'), DB::raw('SUM(order_details.amount_with_discount) as net_price'))
                ->whereBetween('order.order_time', [$start_date, $end_date])
                ->where('order.status','=','1')
                ->where('order.deleted_at',NULL)
                ->where('order_details.item_id','!=','null')
                ->whereNotNull('order_details.item_id')
                ->groupBy('order_details.item_id')
                ->having('total_amt','>=',$from_amount)
                ->having('total_amt','<=',$to_amount)
                ->orderBy('total','desc')
                ->take($number)
                ->get();
        }

        return $orders;
    }
    //END

    public function getExcelWithDateAndNumber($start_date, $end_date,$number){
        $orders = Orderdetail::
        leftjoin('items', 'items.id', '=', 'order_details.item_id')
            ->leftjoin('order', 'order.id', '=', 'order_details.order_id')
            ->leftjoin('status','status.id','=','order_details.status_id')
            ->leftjoin('users','users.id','=','order.user_id')
            ->leftjoin('order_extra','order_details.id','=','order_extra.order_detail_id')
            ->leftjoin('add_on','add_on.id','=','order_extra.extra_id')
            ->select('items.name as Item_Name',DB::raw('SUM(order_details.quantity) as Quantity'),
                'order_details.discount_amount as DiscountAmount','order_details.amount as Price',DB::raw('(order_details.amount)-(order_details.discount_amount) as Amount'),DB::raw('(SUM(order_details.quantity))*((order_details.amount)-(order_details.discount_amount)) as TotalAmount'))
            ->whereBetween('order.order_time', [$start_date, $end_date])
            ->where('order_details.item_id','!=','null')
            ->where('order.status','=','1')
            ->where('order.deleted_at',NULL)
            ->whereNotNull('order_details.item_id')
            ->groupBy('order_details.item_id')
            ->orderBy('Quantity','desc')
            ->take($number)
            ->get();
        return $orders;
    }

    public function getExcelWithDateAndAmount($start_date,$end_date,$from_amount,$to_amount){
        $orders = Orderdetail::
        leftjoin('items', 'items.id', '=', 'order_details.item_id')
            ->leftjoin('order', 'order.id', '=', 'order_details.order_id')
            ->leftjoin('status','status.id','=','order_details.status_id')
            ->leftjoin('users','users.id','=','order.user_id')
            ->leftjoin('order_extra','order_details.id','=','order_extra.order_detail_id')
            ->leftjoin('add_on','add_on.id','=','order_extra.extra_id')
            ->select('items.name as Item_Name',DB::raw('SUM(order_details.quantity) as Quantity'),
                'order_details.discount_amount as DiscountAmount','order_details.amount as Price',DB::raw('(order_details.amount)-(order_details.discount_amount) as Amount'),DB::raw('(SUM(order_details.quantity))*((order_details.amount)-(order_details.discount_amount)) as TotalAmount'))
            ->whereBetween('order.order_time', [$start_date, $end_date])
            ->where('order_details.item_id','!=','null')
            ->where('order.status','=','1')
            ->where('order.deleted_at',NULL)
            ->whereNotNull('order_details.item_id')
            ->groupBy('order_details.item_id')
            ->having('TotalAmount','>=',$from_amount)
            ->having('TotalAmount','<=',$to_amount)
            ->orderBy('Quantity','desc')
            ->get();

        return $orders;
    }

    public function getExcelWithDate($start_date, $end_date,$number,$from_amount,$to_amount){
            $orders = Orderdetail::
            leftjoin('items', 'items.id', '=', 'order_details.item_id')
                ->leftjoin('order', 'order.id', '=', 'order_details.order_id')
                ->leftjoin('status','status.id','=','order_details.status_id')
                ->leftjoin('users','users.id','=','order.user_id')
                ->leftjoin('order_extra','order_details.id','=','order_extra.order_detail_id')
                ->leftjoin('add_on','add_on.id','=','order_extra.extra_id')
                ->select('items.name as Item_Name',DB::raw('SUM(order_details.quantity) as Quantity'),
                 'order_details.discount_amount as DiscountAmount','order_details.amount as Price',DB::raw('(order_details.amount)-(order_details.discount_amount) as Amount'),DB::raw('(SUM(order_details.quantity))*((order_details.amount)-(order_details.discount_amount)) as TotalAmount'))
                ->whereBetween('order.order_time', [$start_date, $end_date])
                ->where('order_details.item_id','!=','null')
                ->where('order.status','=','1')
                ->where('order.deleted_at',NULL)
                ->whereNotNull('order_details.item_id')
                ->groupBy('order_details.item_id')
                ->having('TotalAmount','>=',$from_amount)
                ->having('TotalAmount','<=',$to_amount)
                ->orderBy('Quantity','desc')
                ->take($number)
                ->get();

        return $orders;
    }

    public function getExcelWithDateWithNull($start_date, $end_date){
        
        $orders = Orderdetail::
            leftjoin('items', 'items.id', '=', 'order_details.item_id')
                ->leftjoin('order', 'order.id', '=', 'order_details.order_id')
                ->leftjoin('status','status.id','=','order_details.status_id')
                ->leftjoin('users','users.id','=','order.user_id')
                ->leftjoin('order_extra','order_details.id','=','order_extra.order_detail_id')
                ->leftjoin('add_on','add_on.id','=','order_extra.extra_id')
                ->select('items.name as Item_Name',DB::raw('SUM(order_details.quantity) as Quantity'),
                 'order_details.discount_amount as DiscountAmount','order_details.amount as Price',DB::raw('(order_details.amount)-(order_details.discount_amount) as Amount'),DB::raw('(SUM(order_details.quantity))*((order_details.amount)-(order_details.discount_amount)) as TotalAmount'))
                ->whereBetween('order.order_time', [$start_date, $end_date])
                ->where('order_details.item_id','!=','null')
                ->where('order.status','=','1')
                ->where('order.deleted_at',NULL)
                ->whereNotNull('order_details.item_id')
                ->groupBy('order_details.item_id')
                ->orderBy('Quantity','desc')
//                ->take($number)
                ->get();
            return $orders;
    }

    //Set Menu
    public function getset($start,$end)
    {
        $sub_orders = Orderdetail::
            leftjoin('set_menu', 'set_menu.id', '=', 'order_details.setmenu_id')
            ->leftjoin('order', 'order.id', '=', 'order_details.order_id')
            ->select('set_menu.set_menus_name as Name',DB::raw('SUM(order_details.quantity) as Quantity'),'order_details.discount_amount as DiscountAmount','order_details.amount as Price',DB::raw('(order_details.amount_with_discount) As Amount'),
                DB::raw('(SUM(order_details.quantity))*(order_details.amount_with_discount) as TotalAmount'))
            ->where('order_details.setmenu_id','!=','null')
            ->where('order.status','=','1')
            ->where('order.deleted_at',NULL)
            ->whereNotNUll('order_details.setmenu_id')
            ->groupBy('order_details.setmenu_id')
            ->orderBy('Quantity','desc')
            ->get();
        
        return ($sub_orders);
    }

    public function fav_set_date_report($start_date,$end_date,$number)
    {
        $start_date = $start_date.' 00:00:00';
        $end_date   = $end_date.' 23:00:00';
        if($number == ""){
            $sub_orders = Orderdetail::
                leftjoin('set_menu', 'set_menu.id', '=', 'order_details.setmenu_id')
                ->leftjoin('order', 'order.id', '=', 'order_details.order_id')
                ->leftjoin('status','status.id','=','order_details.status_id')
                ->select('set_menu.set_menus_name as Name',DB::raw('SUM(order_details.quantity) as Quantity'),'order_details.discount_amount as DiscountAmount','order_details.amount as Price',DB::raw('(order_details.amount)-(order_details.discount_amount) As Amount'),
                      DB::raw('(SUM(order_details.quantity))*((order_details.amount)-(order_details.discount_amount)) as TotalAmount'))
                ->whereBetween('order.order_time', [$start_date, $end_date])
                ->where('order_details.setmenu_id','!=','null')
                ->where('order.status','=','1')
                ->where('order.deleted_at',NULL)
                ->whereNotNull('order_details.setmenu_id')
                ->groupBy('order_details.setmenu_id')
                ->orderBy('Quantity','desc')
                ->get();
        }
        else{
            $sub_orders = Orderdetail::
                leftjoin('set_menu', 'set_menu.id', '=', 'order_details.setmenu_id')
                ->leftjoin('order', 'order.id', '=', 'order_details.order_id')
                ->leftjoin('status','status.id','=','order_details.status_id')
               ->select('set_menu.set_menus_name as Name',DB::raw('SUM(order_details.quantity) as Quantity'),'order_details.discount_amount as DiscountAmount','order_details.amount as Price',DB::raw('(order_details.amount)-(order_details.discount_amount) As Amount'),
                      DB::raw('(SUM(order_details.quantity))*((order_details.amount)-(order_details.discount_amount)) as TotalAmount'))
                ->whereBetween('order.order_time', [$start_date, $end_date])
                ->where('order_details.setmenu_id','!=','null')
                ->where('order.status','=','1')
                ->where('order.deleted_at',NULL)
                ->whereNotNull('order_details.setmenu_id')
                ->groupBy('order_details.setmenu_id')
                ->orderBy('Quantity','desc')
                ->take($number)
                ->get();
        }

        return $sub_orders;

    }

    public function fav_set_date_report_with_null($start_date,$end_date)
    {
        $start_date = $start_date.' 00:00:00';
        $end_date   = $end_date.' 23:00:00';

            $sub_orders = Orderdetail::
            leftjoin('set_menu', 'set_menu.id', '=', 'order_details.setmenu_id')
                ->leftjoin('order', 'order.id', '=', 'order_details.order_id')
                ->leftjoin('status','status.id','=','order_details.status_id')
                 ->select('set_menu.set_menus_name as Name',DB::raw('SUM(order_details.quantity) as Quantity'),'order_details.discount_amount as DiscountAmount','order_details.amount as Price',DB::raw('(order_details.amount)-(order_details.discount_amount) As Amount'),
                      DB::raw('(SUM(order_details.quantity))*((order_details.amount)-(order_details.discount_amount)) as TotalAmount'))
                ->whereBetween('order.order_time', [$start_date, $end_date])
                ->where('order_details.item_id','!=','null')
                ->where('order.status','=','1')
                ->where('order.deleted_at',NULL)
                ->whereNotNull('order_details.setmenu_id')
                ->groupBy('order_details.setmenu_id')
                ->orderBy('Quantity','desc')
                ->get();

        return $sub_orders;

    }

    public function getMemberFavouriteFood($type){
        $favourites = Favourite::select('item_id', DB::raw('count(*) as total'))
            ->whereExists(function($query) use ($type){
                if($type != 0) {
                    $query->select()
                        ->from('members')
                        ->whereRaw('members.id = favourites.member_id')
                        ->where('members.member_type_id', $type);
                }
            })
            ->groupBy('item_id')
            ->orderBy('total','desc')
            ->get();

        return $favourites;
    }

    public function getCategories(){
        $categories = Category::get();

        return $categories;
    }

    public function getMemberTypes(){
        $memberTypes = MemberType::get();

        return $memberTypes;
    }

    public function getMemberFavouriteFoodWithJoin($typeId){
        $data = Favourite::leftjoin('items', 'items.id', '=', 'favourites.item_id')
            ->leftjoin('category', 'category.id', '=', 'items.category_id')
            ->whereExists(function($query) use ($typeId){
                if($typeId != 0) {
                    $query->select()
                        ->from('members')
                        ->whereRaw('members.id = favourites.member_id')
                        ->where('members.member_type_id', $typeId);
                }
            })
            ->select('items.name as Item Name', DB::raw('count(*) as Total'),'category.name as Category')
            ->groupBy('favourites.item_id')
            ->orderBy('Total','desc')
            ->get();

        return $data;
    }


     
}