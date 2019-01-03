<?php
namespace App\RMS\Invoice;
use App\RMS\Orderdetail\Orderdetail;
use App\RMS\Order\Order;
use App\RMS\OrderTable\OrderTable;
use App\RMS\OrderRoom\OrderRoom;
use App\RMS\Table\Table;
use App\RMS\Room\Room;
use App\RMS\Transactiontender\Postender;
use App\RMS\Transactiontender\Transactiontender;
use App\RMS\Utility;
use App\Status\StatusConstance;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Input;
use App\RMS\Category\Category;
use App\RMS\OrderExtra\OrderExtra;
use App\RMS\Payment\Payment;
use App\RMS\Item\Continent;
use App\RMS\DayStart\DayStart;
use App\RMS\ReturnMessage;


class InvoiceRepository implements InvoiceRepositoryInterface
{

	public function getinvoice( )
	{
		// dd("GetInvoice");
		$restaurant 		  = Utility::getCurrentRestaurant();
        $branch     		  = Utility::getCurrentBranch();

		$order_status         = StatusConstance::ORDER_CREATE_STATUS;
		$order_paid_status    = StatusConstance::ORDER_PAID_STATUS;
		$session_status       = StatusConstance::DAY_STARTING_STATUS;
        $daystart             = DayStart::select('id')
                              ->where('status',$session_status)
                              ->whereNull('deleted_at')
                              ->where('restaurant_id',$restaurant)
                              ->where('branch_id',$branch)                              
                              ->first();
        // dd($daystart,"aew");
        $day_id 			  = '';
        if (count($daystart) > 0) {
        	$day_id 			  = $daystart->id;
        }
		// $orders = DB::select("select `id`, `total_price`,`member_discount`,`service_amount`,`tax_amount`,`all_total_amount`, `refund`,`created_at`,`total_discount_amount`,`payment_amount`,`status`,`room_charge`
		// from `order` where `deleted_at` is null AND status = $order_status OR status = $order_paid_status order by `order_time` desc");
		$orders 	= Order::whereIn('status',[$order_status,$order_paid_status])
					->orderBy('id', 'desc')
					->where('day_id','=',$day_id)
					->whereNull('deleted_at')
					->where('restaurant_id',$restaurant)
                    ->where('branch_id',$branch)  
					->get();
		return $orders;
	}

	public function getinvoiceTimeIncrease()
	{
		$order_status         = StatusConstance::ORDER_CREATE_STATUS;
		$order_paid_status    = StatusConstance::ORDER_PAID_STATUS;
		$orders 	= Order::whereIn('status',[$order_status,$order_paid_status])
					->orderBy('created_at', 'desc')
					->whereDate('created_at','=',date('Y-m-d'))
					->whereNull('deleted_at')
					->get();
		return $orders;
	}

	public function getinvoiceTimeDecrease()
	{
		$order_status         = StatusConstance::ORDER_CREATE_STATUS;
		$order_paid_status    = StatusConstance::ORDER_PAID_STATUS;
		$orders 	= Order::whereIn('status',[$order_status,$order_paid_status])
					->orderBy('created_at', 'asc')
					->whereDate('created_at','=',date('Y-m-d'))
					->whereNull('deleted_at')
					->get();
		return $orders;
	}

	public function getinvoicePriceIncrease()
	{
		$order_status         = StatusConstance::ORDER_CREATE_STATUS;
		$order_paid_status    = StatusConstance::ORDER_PAID_STATUS;
		$orders 	= Order::whereIn('status',[$order_status,$order_paid_status])
					->orderBy('all_total_amount', 'desc')
					->whereDate('created_at','=',date('Y-m-d'))
					->whereNull('deleted_at')
					->get();
		return $orders;
	}

	public function getinvoicePriceDecrease()
	{
		$order_status         = StatusConstance::ORDER_CREATE_STATUS;
		$order_paid_status    = StatusConstance::ORDER_PAID_STATUS;
		$orders 	= Order::whereIn('status',[$order_status,$order_paid_status])
					->orderBy('all_total_amount', 'asc')
					->whereDate('created_at','=',date('Y-m-d'))
					->whereNull('deleted_at')
					->get();
		return $orders;
	}

	public function getinvoiceOrderIncrease()
	{
		$order_status         = StatusConstance::ORDER_CREATE_STATUS;
		$order_paid_status    = StatusConstance::ORDER_PAID_STATUS;
		$orders 	= Order::whereIn('status',[$order_status,$order_paid_status])
					->orderBy('id', 'desc')
					->whereNull('deleted_at')
					->get();
		return $orders;
	}

	public function getinvoiceOrderDecrease()
	{
		$order_status         = StatusConstance::ORDER_CREATE_STATUS;
		$order_paid_status    = StatusConstance::ORDER_PAID_STATUS;
		$orders 	= Order::whereIn('status',[$order_status,$order_paid_status])
					->orderBy('id', 'asc')
					->whereDate('created_at','=',date('Y-m-d'))
					->whereNull('deleted_at')
					->get();
		return $orders;
	}

	public function getinvoicesort($sortBy,$sortTo)
	{
		$order_status         = StatusConstance::ORDER_CREATE_STATUS;
		$order_paid_status    = StatusConstance::ORDER_PAID_STATUS;
		$orders = DB::select("select `id`, `total_price`,`member_discount`,`service_amount`,`tax_amount`,`all_total_amount`, `refund`,`created_at`,`total_discount_amount`,`payment_amount`,`status`,`room_charge`
		from `order` where `deleted_at` is null AND status = $order_status OR status = $order_paid_status order by `$sortBy` $sortTo");
		$orders 	= Order::whereIn('status',[$order_status,$order_paid_status])
					->orderBy($sortBy,$sortTo)
					->whereDate('created_at','=',date('Y-m-d'))
					->whereNull('deleted_at')
					->get();
		return $orders;
	}

	public function getinvoiceCancel() {
		$order_cancel_status    = StatusConstance::ORDER_CANCEL_STATUS;
		// $orders = DB::select("select `id`, `total_price`,`member_discount`,`service_amount`,`tax_amount`,`all_total_amount`, `created_at`,`total_discount_amount`,`payment_amount`,`status`
		// from `order` where `deleted_at` is null AND status = $order_cancel_status order by `order_time` desc");
		$orders 	= Order::where('status',$order_cancel_status)
					->orderBy('id', 'desc')
					->whereDate('created_at','=',date('Y-m-d'))
					->whereNull('deleted_at')
					->get();
		return $orders;
	}

	public function getCard() {
		$cards 	= DB::select("SELECT id,name FROM card WHERE `deleted_at` is null order by id DESC");

		return $cards;
	}

	public function getPayment($id) {
		// $payment 	= Payment::join('card','payment.payment_type','=','card.id')
		// 			  ->select('payment.paid_amount as paid_amount','payment.payment_type as payment_type',
		// 			    'payment.payment_card_id as payment_card_id','payment.uuid as uuid','card.name as name')
		// 			  ->where('payment.order_id','=',$id)
		// 			  ->whereNull('payment.deleted_at')
		// 			  ->get()
		// 			  ->toArray();
		$status         = StatusConstance::TRANCTION_PAID_STATUS;
		$payment 		= Transactiontender::leftjoin('pos_tenders','transaction_tenders.tender_id','=','pos_tenders.id')
						  ->leftjoin('card_tenders','pos_tenders.card_type','=','card_tenders.id')
						  ->select(DB::raw("SUM(transaction_tenders.paid_amount * transaction_tenders.qty) as paid_amount"),'card_tenders.code as name')
						  ->groupBy('card_tenders.code')
						  ->where('transaction_tenders.order_id',$id)
						  ->where('transaction_tenders.status',$status)
						  ->whereNull('transaction_tenders.deleted_at')
						  ->get()
						  ->toArray();
		// dd($payment);
		return $payment;
	}

	public function getorder($id)
	{
		$orders = Order::select('id as order_id','service_amount','foc_amount','tax_amount','order_time','member_discount','member_discount_amount','member_id','total_price','total_extra_price','all_total_amount','payment_amount','total_discount_amount','refund','total_price_foc','room_charge','status','restaurant_id','branch_id')->where('id',$id)->first();
		
		return $orders;
	}

	public function getdetail($id){
		$order_kitchen_cancel_status    = StatusConstance::ORDER_DETAIL_KITCHEN_CANCEL_STATUS;
        $order_customer_cancel_status   = StatusConstance::ORDER_DETAIL_CUSTOMER_CANCEL_STATUS;

		$order_details = Orderdetail::leftjoin('order','order_details.order_id','=','order.id')
		->leftjoin('items','items.id','=','order_details.item_id')
		->leftjoin('set_menu','set_menu.id','=','order_details.setmenu_id')
		->leftjoin('users','users.id','=','order.user_id')
		->select('items.name as item_name','items.has_continent','items.continent_id','set_menu.set_menus_name as set_name','order_details.quantity',
				'order_details.discount_amount','order_details.amount','order_details.id as order_detail_id',
				'users.user_name','order.id',
			'order_details.amount_with_discount')->where('order_id','=',$id)
		->whereNotIn('status_id',[$order_kitchen_cancel_status,$order_customer_cancel_status])->get();
		return $order_details;
		
	}

	public function cashier($id){
		$cashier = Order::where('id','=',$id)->first();

		return $cashier;
	}

	 public function orderTable($id){
        $tables = OrderTable::leftjoin('tables','order_tables.table_id','=','tables.id')
        ->select('order_tables.table_id','order_tables.order_id','tables.table_no')->where('order_tables.order_id','=',$id)->get();

        return $tables;
    }

    public function orderRoom($id){
        $rooms = OrderRoom::leftjoin('rooms','rooms.id','=','order_room.room_id')
        ->select('order_room.room_id','order_room.order_id','rooms.room_name')->where('order_room.order_id','=',$id)->get();
      
        return $rooms;
    }

	public function getaddon($id){
		$status 		= StatusConstance::ORDER_EXTRA_AVAILABLE_STATUS;
		$order_details 	= Orderdetail::where('order_id','=', $id)->where('deleted_at','=',NULL)->get();
		// dd($order_details);
		$addon = array();
		foreach($order_details as $order){
			$tempAddon = OrderExtra::leftjoin('add_on','add_on.id','=','order_extra.extra_id')
						->select('order_extra.*','add_on.food_name')
						->where('order_extra.order_detail_id','=',$order->id)
						->where('order_extra.status','=',$status)
						->where('order_extra.deleted_at','=',NULL)
						->get()->toArray();
			array_push($addon, $tempAddon);
			
		}
		
		return $addon;
	}

	public function getaddonAmount($id){
		$status 		= StatusConstance::ORDER_EXTRA_AVAILABLE_STATUS;
		$order_details = Orderdetail::where('order_id','=', $id)->where('deleted_at','=',NULL)->get();
		$addon = array();
		foreach($order_details as $order){
			$tempAddon = OrderExtra::leftjoin('add_on','add_on.id','=','order_extra.extra_id')->select('order_extra.*',DB::raw('SUM(order_extra.amount) as amount'),'add_on.food_name')->where('order_extra.order_detail_id','=',$order->id)->where('order_extra.status','=',$status)->where('order_extra.deleted_at','=',NULL)->groupBy('order_extra.order_detail_id')->get()->toArray();
			array_push($addon, $tempAddon);
			
		}
		
		return $addon;
	}

	public function getTenders($id) {
		$status         = StatusConstance::TRANCTION_PAID_STATUS;
		$orderRepo 		= $this->getorder($id);
		$order_foc 		= $orderRepo->foc_amount;
		$order_payment 	= $orderRepo->all_total_amount - $order_foc;
		$transactions 	= Transactiontender::leftjoin('pos_tenders','pos_tenders.id','=','transaction_tenders.tender_id')
							->select('transaction_tenders.id','transaction_tenders.paid_amount','transaction_tenders.changed_amount','transaction_tenders.qty','pos_tenders.description','pos_tenders.card_type')
							->where('transaction_tenders.status','=',$status)
							->where('transaction_tenders.order_id','=',$id)
							->get();
		$balance 		= DB::table('transaction_tenders')
						  ->select(DB::raw("SUM(paid_amount * qty) as count"))
						  ->where('status',$status)
						  ->where('order_id',$id)
						  ->whereNull('deleted_at')
						  ->first();
		$change 		= Transactiontender::select('changed_amount')
						  ->where('status',$status)
						  ->where('order_id',$id)
						  ->whereNotNull('changed_amount')
						  ->first();
		$tenders 		= array();
		$invoice 		= array();
		foreach ($transactions as $key => $transaction) {
			$t['id'] 	= $transaction->id;
			$t['paid'] 	= $transaction->paid_amount;
			$t['card'] 	= $transaction->card_type;
			$t['description'] 	= $transaction->description;
			$t['qty'] 			= $transaction->qty;
			$t['total'] 		= $t['paid'] * $t['qty'];
			array_push($tenders, $t);
		}
		$invoice['pay'] 	=  $tenders;
		$invoice['balance'] =  $order_payment - $balance->count;
		if ($invoice['balance'] < 0) {
            $invoice['balance']     = 0;
        }
		if (count($change) > 0) {
			$invoice['change'] 	=  $change->changed_amount;
		} else {
			$invoice['change'] 	=  0;
		}
		return $invoice;
	}

	public function addpaid($id) {
		DB::table('order')
				->where('id',$id)
				->update(['status'=>5,'payment_amount']);
	}

	public function update($paramObj,$input,$refund){
		$table_available_status        = StatusConstance::TABLE_AVAILABLE_STATUS;
		$room_available_status         = StatusConstance::ROOM_AVAILABLE_STATUS;
		$returnedObj = array();
		$returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

		try {
			$tempObj        = Utility::addUpdatedBy($paramObj);
			$tempObj->save();

			$order_id = $tempObj->id;
			$table_id = Utility::getTableId($order_id);
			if (count($table_id) > 0) {
				foreach($table_id as $table) {
					$id  				= $table->table_id;
					$tempObj 			= Table::find($id);
					$tempObj->status 	= $table_available_status;
					$tempObj->save();
				};
			}

			$room_id = Utility::getRoomId($order_id);
			if (count($room_id) > 0) {
				foreach($room_id as $room) {
					$id = $room->room_id;
					$tempObj = Room::find($id);
					$tempObj->status = $room_available_status;
					$tempObj->save();
				};
			}
			
			$paidAmount 	= $input['amount'];
			$changeAmount 	= $refund;
			$cardType 		= $input['cardtype'];
			$cardId 		= $input['card_id'];
			$uuid 			= $this->randomChar();
			$count 			= 0;
			$paymentCount 	= count($paidAmount);
			foreach($paidAmount as $key => $pay) {
				$count 					= $count + 1;
				$paymentObj 					= new Payment();
				$paymentObj->paid_amount 		= $pay;
				if ($count == $paymentCount) {
					$paymentObj->change_amount 	= $changeAmount;
				}
				$paymentObj->order_id 			= $order_id;
				$paymentObj->payment_type 		= $cardType[$key];
				$paymentObj->payment_card_id 	= $cardId[$key];
				$paymentObj->uuid 				= $uuid;
				$tempObj        		= Utility::addCreatedBy($paymentObj);
				$tempObj->save();
			}
			

			$returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
			return $returnedObj;
		}
		catch(Exception $e){

			$returnedObj['aceplusStatusMessage'] = $e->getMessage();
			return $returnedObj;
		}
	}

	private function randomChar() {
		$db_count 	= Payment::whereNull('deleted_at')->get()->count();
		if ($db_count <= 0) {
			$ran_char 	= sprintf("%06d", mt_rand(1, 999999));
		} else {
			$maxIdAttr 	= DB::table('payment')->where('uuid', DB::raw("(select max(`uuid`) from payment)"))->get();
			foreach($maxIdAttr as $value) {
				$max_id 	= $value->uuid;
			}
			$random 	= sprintf("%02d", mt_rand(1, 99));
			$ran_char 	= $max_id + $random;
		}
		
		return $ran_char;
	}

	public function updateOrder($paramObj){
		$table_available_status        = StatusConstance::TABLE_AVAILABLE_STATUS;
		$room_available_status         = StatusConstance::ROOM_AVAILABLE_STATUS;
		$returnedObj = array();
		$returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

		try {
			$tempObj        = Utility::addUpdatedBy($paramObj);
			$tempObj->save();

			$order_id = $tempObj->id;
			$table_id = Utility::getTableId($order_id);
			if (count($table_id) > 0) {
				foreach($table_id as $table) {
					$id = $table->table_id;
				};
				$tempObj = Table::find($id);
				$tempObj->status = $table_available_status;
				$tempObj->save();
			}

			$room_id = Utility::getRoomId($order_id);
			if (count($room_id) > 0) {
				foreach($room_id as $room) {
					$id = $room->room_id;
				};
				$tempObj = Room::find($id);
				$tempObj->status = $room_available_status;
				$tempObj->save();
			}
			

			$returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
			return $returnedObj;
		}
		catch(Exception $e){

			$returnedObj['aceplusStatusMessage'] = $e->getMessage();
			return $returnedObj;
		}
	}
	
	public function getContinent() {
		$restaurant = Utility::getCurrentRestaurant();
		$continent  = Continent::select('id','name')->get();
		return $continent;
	}
}