<?php
namespace App\Http\Controllers\Backend\Invoice;
use Faker\Provider\DateTime;
use Illuminate\Http\Request;
use App\RMS\InvoiceBackend\InvoiceBackendRepositoryInterface;
use App\RMS\Infrastructure\Forms\InvoiceRequest;
use App\Http\Requests;
use Auth;
use App\Http\Controllers\Controller;
use App\RMS\Order\Order;
use App\RMS\OrderTable\OrderTable;
use App\RMS\OrderRoom\OrderRoom;
use App\RMS\Orderdetail\Orderdetail;
use App\RMS\Item\Item;

use App\RMS\Config\Config;
use App\Status\StatusConstance;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use PDF;
use Excel;
use App;
use App\RMS\Utility;
use Response;
use Hash;
use App\User;
use App\RMS\FormatGenerator As FormatGenerator;
use App\RMS\ReturnMessage As ReturnMessage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection as Collection;


class InvoiceController extends Controller
{
    private $InvoiceRepository;

    public function __construct(InvoiceBackendRepositoryInterface $InvoiceRepository)
    {
        $this->InvoiceRepository = $InvoiceRepository;
    }
    
    public function invoiceList(Request $request)
    {
        $page       = $request->get('page');
    	$today      = Carbon::now();
    	$cur_date   = Carbon::parse($today)->format('Y-m-d');
        $orderRepo 	= $this->InvoiceRepository->getinvoice();
        $continent  = $this->InvoiceRepository->getContinent();
        //Get Order with table and room
        $orders     = array();
        foreach($orderRepo as $key => $order) {
            $orderID        = $order->id;
            $orderTable     = OrderTable::leftjoin('tables','order_tables.table_id','=','tables.id')
                                ->select('tables.table_no as table_name')
                                ->where('order_tables.order_id','=',$orderID)
                                ->first();
            $orderRoom      = OrderRoom::leftjoin('rooms','order_room.room_id','=','rooms.id')
                                ->select('rooms.room_name as room_name')
                                ->where('order_room.order_id','=',$orderID)
                                ->first();
            //Get Order Detail 
            $order_detail   = $this->InvoiceRepository->getdetail($orderID);
            $order->order_detail        = $order_detail;
            //Get Add On 
            $add_on         = $this->InvoiceRepository->getaddon($orderID);
            $order->addon   = $add_on;
            if (count($orderTable) > 0) {
                $order->table   = $orderTable->table_name;
            }

            if (count($orderRoom) > 0) {
                $order->room    = $orderRoom->room_name;
            }
            //Payment
            $payment       = $this->InvoiceRepository->getPayment($orderID);
            
            $order->paid = $payment;
            $orders[$key]   = $order;
        }
        if (Auth::guard('Cashier')->check()) {
            $role_id      = Auth::guard('Cashier')->user()->role_id;
        }
        $roleArr['role'][]    = $role_id;
        $config         = Config::select('restaurant_name','email','logo','website','address','phone','tax','service')->first();
         
        return view('Backend.invoice.index',compact('orders','config','orderRepo','continent','page'));
      
    } 

    public function invoiceTimeIncrease(Request $request) {
        $page       = $request->get('page');
    	$today      = Carbon::now();
    	$cur_date   = Carbon::parse($today)->format('Y-m-d');
        $orderRepo 	= $this->InvoiceRepository->getinvoiceTimeIncrease();
        $continent  = $this->InvoiceRepository->getContinent();
        //Get Order with table and room
        $orders     = array();
        foreach($orderRepo as $key => $order) {
            $orderID        = $order->id;
            $orderTable     = OrderTable::leftjoin('tables','order_tables.table_id','=','tables.id')
                                ->select('tables.table_no as table_name')
                                ->where('order_tables.order_id','=',$orderID)
                                ->first();
            $orderRoom      = OrderRoom::leftjoin('rooms','order_room.room_id','=','rooms.id')
                                ->select('rooms.room_name as room_name')
                                ->where('order_room.order_id','=',$orderID)
                                ->first();
            //Get Order Detail 
            $order_detail   = $this->InvoiceRepository->getdetail($orderID);
            $order->order_detail        = $order_detail;
            //Get Add On 
            $add_on         = $this->InvoiceRepository->getaddon($orderID);
            $order->addon   = $add_on;
            if (count($orderTable) > 0) {
                $order->table   = $orderTable->table_name;
            }

            if (count($orderRoom) > 0) {
                $order->room    = $orderRoom->room_name;
            }
            //Payment
            $payment       = $this->InvoiceRepository->getPayment($orderID);
            
            $order->paid = $payment;
            $orders[$key]   = $order;
        }
        if (Auth::guard('Cashier')->check()) {
            $role_id      = Auth::guard('Cashier')->user()->role_id;
        }
        $roleArr['role'][]    = $role_id;
        $config         = Config::select('restaurant_name','email','logo','website','address','phone','tax','service')->first();
        //Flag For Sorting
        $sortBy         = "time";
        $amount         = "increase";
        return view('Backend.invoice.index',compact('orders','config','orderRepo','sortBy','amount','continent','page'));
    }

    public function invoiceTimeDecrease(Request $request) {
        $page       = $request->get('page');
    	$today      = Carbon::now();
    	$cur_date   = Carbon::parse($today)->format('Y-m-d');
        $orderRepo 	= $this->InvoiceRepository->getinvoiceTimeDecrease();
        $continent  = $this->InvoiceRepository->getContinent();
        //Get Order with table and room
        $orders     = array();
        foreach($orderRepo as $key => $order) {
            $orderID        = $order->id;
            $orderTable     = OrderTable::leftjoin('tables','order_tables.table_id','=','tables.id')
                                ->select('tables.table_no as table_name')
                                ->where('order_tables.order_id','=',$orderID)
                                ->first();
            $orderRoom      = OrderRoom::leftjoin('rooms','order_room.room_id','=','rooms.id')
                                ->select('rooms.room_name as room_name')
                                ->where('order_room.order_id','=',$orderID)
                                ->first();
            //Get Order Detail 
            $order_detail   = $this->InvoiceRepository->getdetail($orderID);
            $order->order_detail        = $order_detail;
            //Get Add On 
            $add_on         = $this->InvoiceRepository->getaddon($orderID);
            $order->addon   = $add_on;
            if (count($orderTable) > 0) {
                $order->table   = $orderTable->table_name;
            }

            if (count($orderRoom) > 0) {
                $order->room    = $orderRoom->room_name;
            }
            //Payment
            $payment       = $this->InvoiceRepository->getPayment($orderID);
            
            $order->paid = $payment;
            $orders[$key]   = $order;
        }
        if (Auth::guard('Cashier')->check()) {
            $role_id      = Auth::guard('Cashier')->user()->role_id;
        }
        $roleArr['role'][]    = $role_id;
        $config         = Config::select('restaurant_name','email','logo','website','address','phone','tax','service')->first();
        //Flag For Sorting
        $sortBy         = "time";
        $amount         = "decrease";
        return view('Backend.invoice.index',compact('orders','config','orderRepo','sortBy','amount','continent','page'));
    }

    public function invoicePriceIncrease(Request $request) {
        $page       = $request->get('page');
    	$today      = Carbon::now();
    	$cur_date   = Carbon::parse($today)->format('Y-m-d');
        $orderRepo 	= $this->InvoiceRepository->getinvoicePriceIncrease();
        $continent  = $this->InvoiceRepository->getContinent();
        //Get Order with table and room
        $orders     = array();
        foreach($orderRepo as $key => $order) {
            $orderID        = $order->id;
            $orderTable     = OrderTable::leftjoin('tables','order_tables.table_id','=','tables.id')
                                ->select('tables.table_no as table_name')
                                ->where('order_tables.order_id','=',$orderID)
                                ->first();
            $orderRoom      = OrderRoom::leftjoin('rooms','order_room.room_id','=','rooms.id')
                                ->select('rooms.room_name as room_name')
                                ->where('order_room.order_id','=',$orderID)
                                ->first();
            //Get Order Detail 
            $order_detail   = $this->InvoiceRepository->getdetail($orderID);
            $order->order_detail        = $order_detail;
            //Get Add On 
            $add_on         = $this->InvoiceRepository->getaddon($orderID);
            $order->addon   = $add_on;
            if (count($orderTable) > 0) {
                $order->table   = $orderTable->table_name;
            }

            if (count($orderRoom) > 0) {
                $order->room    = $orderRoom->room_name;
            }
            //Payment
            $payment       = $this->InvoiceRepository->getPayment($orderID);
            
            $order->paid = $payment;
            $orders[$key]   = $order;
        }
        if (Auth::guard('Cashier')->check()) {
            $role_id      = Auth::guard('Cashier')->user()->role_id;
        }
        $roleArr['role'][]    = $role_id;
        $config         = Config::select('restaurant_name','email','logo','website','address','phone','tax','service')->first();
        //Flag For Sorting
        $sortBy         = "price";
        $amount         = "increase";
        return view('Backend.invoice.index',compact('orders','config','orderRepo','sortBy','amount','continent','page'));
    }

    public function invoicePriceDecrease(Request $request) {
        $page       = $request->get('page');
    	$today      = Carbon::now();
    	$cur_date   = Carbon::parse($today)->format('Y-m-d');
        $orderRepo 	= $this->InvoiceRepository->getinvoicePriceDecrease();
        $continent  = $this->InvoiceRepository->getContinent();
        //Get Order with table and room
        $orders     = array();
        foreach($orderRepo as $key => $order) {
            $orderID        = $order->id;
            $orderTable     = OrderTable::leftjoin('tables','order_tables.table_id','=','tables.id')
                                ->select('tables.table_no as table_name')
                                ->where('order_tables.order_id','=',$orderID)
                                ->first();
            $orderRoom      = OrderRoom::leftjoin('rooms','order_room.room_id','=','rooms.id')
                                ->select('rooms.room_name as room_name')
                                ->where('order_room.order_id','=',$orderID)
                                ->first();
            //Get Order Detail 
            $order_detail   = $this->InvoiceRepository->getdetail($orderID);
            $order->order_detail        = $order_detail;
            //Get Add On 
            $add_on         = $this->InvoiceRepository->getaddon($orderID);
            $order->addon   = $add_on;
            if (count($orderTable) > 0) {
                $order->table   = $orderTable->table_name;
            }

            if (count($orderRoom) > 0) {
                $order->room    = $orderRoom->room_name;
            }
            //Payment
            $payment       = $this->InvoiceRepository->getPayment($orderID);
            
            $order->paid = $payment;
            $orders[$key]   = $order;
        }
        if (Auth::guard('Cashier')->check()) {
            $role_id      = Auth::guard('Cashier')->user()->role_id;
        }
        $roleArr['role'][]    = $role_id;
        $config         = Config::select('restaurant_name','email','logo','website','address','phone','tax','service')->first();
        //Flag For Sorting
        $sortBy         = "price";
        $amount         = "decrease";
        return view('Backend.invoice.index',compact('orders','config','orderRepo','sortBy','amount','continent','page'));
    }

    public function invoiceOrderIncrease(Request $request) {
        $page       = $request->get('page');
    	$today      = Carbon::now();
    	$cur_date   = Carbon::parse($today)->format('Y-m-d');
        $orderRepo 	= $this->InvoiceRepository->getinvoiceOrderIncrease();
        $continent  = $this->InvoiceRepository->getContinent();
        //Get Order with table and room
        $orders     = array();
        foreach($orderRepo as $key => $order) {
            $orderID        = $order->id;
            $orderTable     = OrderTable::leftjoin('tables','order_tables.table_id','=','tables.id')
                                ->select('tables.table_no as table_name')
                                ->where('order_tables.order_id','=',$orderID)
                                ->first();
            $orderRoom      = OrderRoom::leftjoin('rooms','order_room.room_id','=','rooms.id')
                                ->select('rooms.room_name as room_name')
                                ->where('order_room.order_id','=',$orderID)
                                ->first();
            //Get Order Detail 
            $order_detail   = $this->InvoiceRepository->getdetail($orderID);
            $order->order_detail        = $order_detail;
            //Get Add On 
            $add_on         = $this->InvoiceRepository->getaddon($orderID);
            $order->addon   = $add_on;
            if (count($orderTable) > 0) {
                $order->table   = $orderTable->table_name;
            }

            if (count($orderRoom) > 0) {
                $order->room    = $orderRoom->room_name;
            }
            //Payment
            $payment       = $this->InvoiceRepository->getPayment($orderID);
            
            $order->paid = $payment;
            $orders[$key]   = $order;
        }
        if (Auth::guard('Cashier')->check()) {
            $role_id      = Auth::guard('Cashier')->user()->role_id;
        }
        $roleArr['role'][]    = $role_id;
        $config         = Config::select('restaurant_name','email','logo','website','address','phone','tax','service')->first();
        //Flag For Sorting
        $sortBy         = "order";
        $amount         = "increase";
        return view('Backend.invoice.index',compact('orders','config','orderRepo','sortBy','amount','continent','page'));
    }

    public function invoiceOrderDecrease(Request $request) 
    {
        $page       = $request->get('page');
    	$today      = Carbon::now();
    	$cur_date   = Carbon::parse($today)->format('Y-m-d');
        $orderRepo 	= $this->InvoiceRepository->getinvoiceOrderDecrease();
        $continent  = $this->InvoiceRepository->getContinent();
        //Get Order with table and room
        $orders     = array();
        foreach($orderRepo as $key => $order) {
            $orderID        = $order->id;
            $orderTable     = OrderTable::leftjoin('tables','order_tables.table_id','=','tables.id')
                                ->select('tables.table_no as table_name')
                                ->where('order_tables.order_id','=',$orderID)
                                ->first();
            $orderRoom      = OrderRoom::leftjoin('rooms','order_room.room_id','=','rooms.id')
                                ->select('rooms.room_name as room_name')
                                ->where('order_room.order_id','=',$orderID)
                                ->first();
            //Get Order Detail 
            $order_detail   = $this->InvoiceRepository->getdetail($orderID);
            $order->order_detail        = $order_detail;
            //Get Add On 
            $add_on         = $this->InvoiceRepository->getaddon($orderID);
            $order->addon   = $add_on;
            if (count($orderTable) > 0) {
                $order->table   = $orderTable->table_name;
            }

            if (count($orderRoom) > 0) {
                $order->room    = $orderRoom->room_name;
            }
            //Payment
            $payment       = $this->InvoiceRepository->getPayment($orderID);
            
            $order->paid = $payment;
            $orders[$key]   = $order;
        }
        if (Auth::guard('Cashier')->check()) {
            $role_id      = Auth::guard('Cashier')->user()->role_id;
        }
        $roleArr['role'][]    = $role_id;
        $config         = Config::select('restaurant_name','email','logo','website','address','phone','tax','service')->first();
        //Flag For Sorting
        $sortBy         = "order";
        $amount         = "decrease";
        return view('Backend.invoice.index',compact('orders','config','orderRepo','sortBy','amount','continent','page'));
    }

    public function ajaxInvoiceTimeIncrease(Request $request)
    {
        $page       = $request->get('page');
        $today      = Carbon::now();
    	$cur_date   = Carbon::parse($today)->format('Y-m-d');
        $orderRepo 	= $this->InvoiceRepository->getinvoiceTimeIncrease();
        $orderRepo  = $orderRepo->setPath('increase');
        $continent  = $this->InvoiceRepository->getContinent();
        //Get Order with table and room
        $orders     = array();
        foreach($orderRepo as $key => $order) {
            $orderID        = $order->id;
            $orderTable     = OrderTable::leftjoin('tables','order_tables.table_id','=','tables.id')
                                ->select('tables.table_no as table_name')
                                ->where('order_tables.order_id','=',$orderID)
                                ->first();
            $orderRoom      = OrderRoom::leftjoin('rooms','order_room.room_id','=','rooms.id')
                                ->select('rooms.room_name as room_name')
                                ->where('order_room.order_id','=',$orderID)
                                ->first();
            //Get Order Detail 
            $order_detail   = $this->InvoiceRepository->getdetail($orderID);
            $order->order_detail        = $order_detail;

            //Get Add On 
            $add_on         = $this->InvoiceRepository->getaddon($orderID);
            $order->addon   = $add_on;
            if (count($orderTable) > 0) {
                $order->table   = $orderTable->table_name;
            }

            if (count($orderRoom) > 0) {
                $order->room    = $orderRoom->room_name;
            }
            //Payment
            $payment       = $this->InvoiceRepository->getPayment($orderID);
            
            $order->paid = $payment;
            $orders[$key]   = $order;
        }
        if (Auth::guard('Cashier')->check()) {
            $role_id      = Auth::guard('Cashier')->user()->role_id;
        }
        $roleArr['role'][]    = $role_id;
        $config         = Config::select('restaurant_name','email','logo','website','address','phone','tax','service')->first();
        //Flag For Sorting
        $sortBy         = "time";
        $amount         = "increase";
        return view('Backend.invoice.real_time_invoice',compact('orders','config','orderRepo','sortBy','amount','continent','page'));   
    }

    public function ajaxInvoiceTimeDecrease(Request $request)
    {
        $page       = $request->get('page');
        $today      = Carbon::now();
    	$cur_date   = Carbon::parse($today)->format('Y-m-d');
        $orderRepo 	= $this->InvoiceRepository->getinvoiceTimeDecrease();
        $orderRepo  = $orderRepo->setPath('decrease');
        $continent  = $this->InvoiceRepository->getContinent();
        //Get Order with table and room
        $orders     = array();
        foreach($orderRepo as $key => $order) {
            $orderID        = $order->id;
            $orderTable     = OrderTable::leftjoin('tables','order_tables.table_id','=','tables.id')
                                ->select('tables.table_no as table_name')
                                ->where('order_tables.order_id','=',$orderID)
                                ->first();
            $orderRoom      = OrderRoom::leftjoin('rooms','order_room.room_id','=','rooms.id')
                                ->select('rooms.room_name as room_name')
                                ->where('order_room.order_id','=',$orderID)
                                ->first();
            //Get Order Detail 
            $order_detail   = $this->InvoiceRepository->getdetail($orderID);
            $order->order_detail        = $order_detail;

            //Get Add On 
            $add_on         = $this->InvoiceRepository->getaddon($orderID);
            $order->addon   = $add_on;
            if (count($orderTable) > 0) {
                $order->table   = $orderTable->table_name;
            }

            if (count($orderRoom) > 0) {
                $order->room    = $orderRoom->room_name;
            }
            //Payment
            $payment       = $this->InvoiceRepository->getPayment($orderID);
            
            $order->paid = $payment;
            $orders[$key]   = $order;
        }
        if (Auth::guard('Cashier')->check()) {
            $role_id      = Auth::guard('Cashier')->user()->role_id;
        }
        $roleArr['role'][]    = $role_id;
        $config         = Config::select('restaurant_name','email','logo','website','address','phone','tax','service')->first();
        //Flag For Sorting
        $sortBy         = "time";
        $amount         = "decrease";
        return view('Backend.invoice.real_time_invoice',compact('orders','config','orderRepo','sortBy','amount','continent','page'));   
    }

    public function ajaxInvoicePriceIncrease(Request $request)
    {
        $page       = $request->get('page');
        $today      = Carbon::now();
    	$cur_date   = Carbon::parse($today)->format('Y-m-d');
        $orderRepo 	= $this->InvoiceRepository->getinvoicePriceIncrease();
        $orderRepo  = $orderRepo->setPath('increase');
        $continent  = $this->InvoiceRepository->getContinent();
        //Get Order with table and room
        $orders     = array();
        foreach($orderRepo as $key => $order) {
            $orderID        = $order->id;
            $orderTable     = OrderTable::leftjoin('tables','order_tables.table_id','=','tables.id')
                                ->select('tables.table_no as table_name')
                                ->where('order_tables.order_id','=',$orderID)
                                ->first();
            $orderRoom      = OrderRoom::leftjoin('rooms','order_room.room_id','=','rooms.id')
                                ->select('rooms.room_name as room_name')
                                ->where('order_room.order_id','=',$orderID)
                                ->first();
            //Get Order Detail 
            $order_detail   = $this->InvoiceRepository->getdetail($orderID);
            $order->order_detail        = $order_detail;

            //Get Add On 
            $add_on         = $this->InvoiceRepository->getaddon($orderID);
            $order->addon   = $add_on;
            if (count($orderTable) > 0) {
                $order->table   = $orderTable->table_name;
            }

            if (count($orderRoom) > 0) {
                $order->room    = $orderRoom->room_name;
            }
            //Payment
            $payment       = $this->InvoiceRepository->getPayment($orderID);
            
            $order->paid = $payment;
            $orders[$key]   = $order;
        }
        if (Auth::guard('Cashier')->check()) {
            $role_id      = Auth::guard('Cashier')->user()->role_id;
        }
        $roleArr['role'][]    = $role_id;
        $config         = Config::select('restaurant_name','email','logo','website','address','phone','tax','service')->first();
        //Flag For Sorting
        $sortBy         = "price";
        $amount         = "increase";
        return view('Backend.invoice.real_time_invoice',compact('orders','config','orderRepo','page','sortBy','amount','continent','page'));   
    }

    public function ajaxInvoicePriceDecrease(Request $request) {
        $page       = $request->get('page');
        $today      = Carbon::now();
    	$cur_date   = Carbon::parse($today)->format('Y-m-d');
        $orderRepo 	= $this->InvoiceRepository->getinvoicePriceDecrease();
        $orderRepo  = $orderRepo->setPath('decrease');
        $continent  = $this->InvoiceRepository->getContinent();
        //Get Order with table and room
        $orders     = array();
        foreach($orderRepo as $key => $order) {
            $orderID        = $order->id;
            $orderTable     = OrderTable::leftjoin('tables','order_tables.table_id','=','tables.id')
                                ->select('tables.table_no as table_name')
                                ->where('order_tables.order_id','=',$orderID)
                                ->first();
            $orderRoom      = OrderRoom::leftjoin('rooms','order_room.room_id','=','rooms.id')
                                ->select('rooms.room_name as room_name')
                                ->where('order_room.order_id','=',$orderID)
                                ->first();
            //Get Order Detail 
            $order_detail   = $this->InvoiceRepository->getdetail($orderID);
            $order->order_detail        = $order_detail;

            //Get Add On 
            $add_on         = $this->InvoiceRepository->getaddon($orderID);
            $order->addon   = $add_on;
            if (count($orderTable) > 0) {
                $order->table   = $orderTable->table_name;
            }

            if (count($orderRoom) > 0) {
                $order->room    = $orderRoom->room_name;
            }
            //Payment
            $payment       = $this->InvoiceRepository->getPayment($orderID);
            
            $order->paid = $payment;
            $orders[$key]   = $order;
        }
        if (Auth::guard('Cashier')->check()) {
            $role_id      = Auth::guard('Cashier')->user()->role_id;
        }
        $roleArr['role'][]    = $role_id;
        $config         = Config::select('restaurant_name','email','logo','website','address','phone','tax','service')->first();
        //Flag For Sorting
        $sortBy         = "price";
        $amount         = "decrease";
        return view('Backend.invoice.real_time_invoice',compact('orders','config','orderRepo','sortBy','amount','continent','page'));   
    }

    public function ajaxInvoiceOrderIncrease(Request $request) {
        $page       = $request->get('page');
        $today      = Carbon::now();
    	$cur_date   = Carbon::parse($today)->format('Y-m-d');
        $orderRepo 	= $this->InvoiceRepository->getinvoiceOrderIncrease();
        $orderRepo  = $orderRepo->setPath('increase');
        $continent  = $this->InvoiceRepository->getContinent();
        //Get Order with table and room
        $orders     = array();
        foreach($orderRepo as $key => $order) {
            $orderID        = $order->id;
            $orderTable     = OrderTable::leftjoin('tables','order_tables.table_id','=','tables.id')
                                ->select('tables.table_no as table_name')
                                ->where('order_tables.order_id','=',$orderID)
                                ->first();
            $orderRoom      = OrderRoom::leftjoin('rooms','order_room.room_id','=','rooms.id')
                                ->select('rooms.room_name as room_name')
                                ->where('order_room.order_id','=',$orderID)
                                ->first();
            //Get Order Detail 
            $order_detail   = $this->InvoiceRepository->getdetail($orderID);
            $order->order_detail        = $order_detail;

            //Get Add On 
            $add_on         = $this->InvoiceRepository->getaddon($orderID);
            $order->addon   = $add_on;
            if (count($orderTable) > 0) {
                $order->table   = $orderTable->table_name;
            }

            if (count($orderRoom) > 0) {
                $order->room    = $orderRoom->room_name;
            }
            //Payment
            $payment       = $this->InvoiceRepository->getPayment($orderID);
            
            $order->paid = $payment;
            $orders[$key]   = $order;
        }
        if (Auth::guard('Cashier')->check()) {
            $role_id      = Auth::guard('Cashier')->user()->role_id;
        }
        $roleArr['role'][]    = $role_id;
        $config         = Config::select('restaurant_name','email','logo','website','address','phone','tax','service')->first();
        //Flag For Sorting
        $sortBy         = "order";
        $amount         = "increase";
        return view('Backend.invoice.real_time_invoice',compact('orders','config','orderRepo','sortBy','amount','continent','page'));
    }

    public function ajaxInvoiceOrderDecrease(Request $request) {
        $page       = $request->get('page');
        $today      = Carbon::now();
    	$cur_date   = Carbon::parse($today)->format('Y-m-d');
        $orderRepo 	= $this->InvoiceRepository->getinvoiceOrderDecrease();
        $orderRepo  = $orderRepo->setPath('increase');
        $continent  = $this->InvoiceRepository->getContinent();
        //Get Order with table and room
        $orders     = array();
        foreach($orderRepo as $key => $order) {
            $orderID        = $order->id;
            $orderTable     = OrderTable::leftjoin('tables','order_tables.table_id','=','tables.id')
                                ->select('tables.table_no as table_name')
                                ->where('order_tables.order_id','=',$orderID)
                                ->first();
            $orderRoom      = OrderRoom::leftjoin('rooms','order_room.room_id','=','rooms.id')
                                ->select('rooms.room_name as room_name')
                                ->where('order_room.order_id','=',$orderID)
                                ->first();
            //Get Order Detail 
            $order_detail   = $this->InvoiceRepository->getdetail($orderID);
            $order->order_detail        = $order_detail;

            //Get Add On 
            $add_on         = $this->InvoiceRepository->getaddon($orderID);
            $order->addon   = $add_on;
            if (count($orderTable) > 0) {
                $order->table   = $orderTable->table_name;
            }

            if (count($orderRoom) > 0) {
                $order->room    = $orderRoom->room_name;
            }
            //Payment
            $payment       = $this->InvoiceRepository->getPayment($orderID);
            
            $order->paid = $payment;
            $orders[$key]   = $order;
        }
        if (Auth::guard('Cashier')->check()) {
            $role_id      = Auth::guard('Cashier')->user()->role_id;
        }
        $roleArr['role'][]    = $role_id;
        $config         = Config::select('restaurant_name','email','logo','website','address','phone','tax','service')->first();
        //Flag For Sorting
        $sortBy         = "order";
        $amount         = "decrease";
        return view('Backend.invoice.real_time_invoice',compact('orders','config','orderRepo','sortBy','amount','continent','page'));
    }

    public function ajaxRequest(Request $request)
    {
        $page       = $request->get('page');
        $today      = Carbon::now();
    	$cur_date   = Carbon::parse($today)->format('Y-m-d');
        $orderRepo 	= $this->InvoiceRepository->getinvoice();
        $orderRepo  = $orderRepo->setPath('invoice');
        //Get Order with table and room
        $orders     = array();
        foreach($orderRepo as $key => $order) {
            $orderID        = $order->id;
            $orderTable     = OrderTable::leftjoin('tables','order_tables.table_id','=','tables.id')
                                ->select('tables.table_no as table_name')
                                ->where('order_tables.order_id','=',$orderID)
                                ->first();
            $orderRoom      = OrderRoom::leftjoin('rooms','order_room.room_id','=','rooms.id')
                                ->select('rooms.room_name as room_name')
                                ->where('order_room.order_id','=',$orderID)
                                ->first();
            //Get Order Detail 
            $order_detail   = $this->InvoiceRepository->getdetail($orderID);
            $order->order_detail        = $order_detail;

            //Get Add On 
            $add_on         = $this->InvoiceRepository->getaddon($orderID);
            $order->addon   = $add_on;
            if (count($orderTable) > 0) {
                $order->table   = $orderTable->table_name;
            }

            if (count($orderRoom) > 0) {
                $order->room    = $orderRoom->room_name;
            }
            //Payment
            $payment       = $this->InvoiceRepository->getPayment($orderID);
            
            $order->paid = $payment;
            $orders[$key]   = $order;
        }
        if (Auth::guard('Cashier')->check()) {
            $role_id      = Auth::guard('Cashier')->user()->role_id;
        }
        $roleArr['role'][]    = $role_id;
        $config         = Config::select('restaurant_name','email','logo','website','address','phone','tax','service')->first();
        return view('Backend.invoice.real_time_invoice',compact('orders','config','orderRepo','page'));

    }

    public function ajaxInvoiceRequest()
    {
        $today      = Carbon::now();
    	$cur_date   = Carbon::parse($today)->format('Y-m-d');
        $orders 	= $this->InvoiceRepository->getinvoice();

        return view('Backend.invoice.invoice',compact('orders'))->render();
    }

    public function invoicedetail($id){
        $orders = $this->InvoiceRepository->getorder($id);
        $add    = $this->InvoiceRepository->getaddon($id);
        $total  = $this->InvoiceRepository->getaddonAmount($id);
        $continent  = $this->InvoiceRepository->getContinent();
        $addon  = array();
        foreach($add as $dd){
            foreach($dd as $d){
                $addon[] = $d;
            }
        }
        $amount = array();
        foreach($total as $t){
            foreach($t as $tt){
                $amount[] = $tt;
            }
        }
        $order_detail   = $this->InvoiceRepository->getdetail($id);
        $tables         = $this->InvoiceRepository->orderTable($id);
        $rooms          = $this->InvoiceRepository->orderRoom($id);
        $cashier        = $this->InvoiceRepository->cashier($id);
        $config         = Config::select('restaurant_name','email','logo','website','address','phone','tax','service')->first();
        $payments        = $this->InvoiceRepository->getPayment($id);
        return view('Backend.invoice.detail',compact('orders','order_detail','addon','amount','config','tables','rooms','cashier','payments','continent'));
    }

    public function invoicePaid($id) {
        $order = $this->InvoiceRepository->getorder($id);
        $add    = $this->InvoiceRepository->getaddon($id);
        $total  = $this->InvoiceRepository->getaddonAmount($id);
        $continent  = $this->InvoiceRepository->getContinent();
        $addon  = array();
        foreach($add as $dd){
            foreach($dd as $d){
                $addon[] = $d;
            }
        }
        $amount = array();
        foreach($total as $t){
            foreach($t as $tt){
                $amount[] = $tt;
            }
        }
        $order_detail   = $this->InvoiceRepository->getdetail($id);
        $tables         = $this->InvoiceRepository->orderTable($id);
        $rooms          = $this->InvoiceRepository->orderRoom($id);
        $cashier        = $this->InvoiceRepository->cashier($id);
        $cards          = $this->InvoiceRepository->getCard();
        $payments        = $this->InvoiceRepository->getPayment($id);
        $tenders        = $this->InvoiceRepository->getTenders($id);
        $config         = Config::select('restaurant_name','logo','website','address','phone','tax','service','room_charge','email')->first();
    
        return view('Backend.invoice.payment',compact('order','order_detail','addon','amount','config','tables','rooms','cashier','cards','payments','continent','tenders'));
    }

    public function ajaxPaymentRequest($id) {
        $order = $this->InvoiceRepository->getorder($id);
        $add    = $this->InvoiceRepository->getaddon($id);
        $total  = $this->InvoiceRepository->getaddonAmount($id);
        $addon  = array();
        foreach($add as $dd){
            foreach($dd as $d){
                $addon[] = $d;
            }
        }
        $amount = array();
        foreach($total as $t){
            foreach($t as $tt){
                $amount[] = $tt;
            }
        }
        $order_detail   = $this->InvoiceRepository->getdetail($id);
        $tables         = $this->InvoiceRepository->orderTable($id);
        $rooms          = $this->InvoiceRepository->orderRoom($id);
        $cashier        = $this->InvoiceRepository->cashier($id);
        $cards          = $this->InvoiceRepository->getCard();
        $payments        = $this->InvoiceRepository->getPayment($id);
        $config         = Config::select('restaurant_name','logo','website','address','phone','tax','service','room_charge','email')->first();

        return view('Backend.invoice.real_time_payment',compact('order','order_detail','addon','amount','config','tables','rooms','cashier','cards','payments'));
    }

    //InvoiceRequest
    public function invoiceAddpaid(Request $request)
    {
        $order_paid_status  = StatusConstance::ORDER_PAID_STATUS;
        // $request->validate();
        $input              = Input::all();
        $id                 = Input::get('id');
        $config         = Config::select('restaurant_name','email','logo','website','address','phone','tax','service')->first();
        $orders             = $this->InvoiceRepository->getorder($id);
        $tax_foc            = $orders->tax_amount;
        $services           = $orders->service_amount;
        $rooms              = $this->InvoiceRepository->orderRoom($id);
        $tables             = $this->InvoiceRepository->orderTable($id);
        $payment_arr        = Input::get('amount');
        $payment            = array_sum($payment_arr);
        $foc                = (int)(Input::get('foc'));
        $all_total          = $orders->all_total_amount;
        $paymentfoc         = $payment + $foc;
        $total_price_foc    = $all_total - $foc;
        $refund             = $paymentfoc - $all_total;
        $status             = $order_paid_status;

        if ($foc > 0) {
            $all_total_with_foc     = $all_total - $foc;
        } else {
            $all_total_with_foc     = $all_total;    
        }

        $paramObj                   = Order::find($id);
        $paramObj->status           = $status;
        $paramObj->payment_amount   = $payment;
        $paramObj->refund           = $refund;
        $paramObj->foc_amount       = $foc;
        $paramObj->all_total_amount = $all_total_with_foc;
        $result                     = $this->InvoiceRepository->update($paramObj,$input,$refund);
        //Get Update ID
        $param                      = $id;
        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
            if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
                return redirect('Cashier/invoice/paid/' . $param)->with('status', 'Payment Update');
            }
        }
        else{
            return redirect()->action('Cashier\Invoice\InvoiceController@invoiceList')
                ->withMessage(FormatGenerator::message('Fail', 'Table did not update ...'));
        }
    }

    public function invoiceCancel(Request $request) {
        $today          = Carbon::now();
    	$cur_date       = Carbon::parse($today)->format('Y-m-d');
        $ordersCancel 	= $this->InvoiceRepository->getinvoiceCancel();
        //Flag for Invoice Type
        $sortBy         = "cancel";
        $amount         = "";
        return view('Backend.invoice.index',compact('ordersCancel','sortBy','amount','page'));
    }
    public function orderCancel($id) {
        $order_cancel_status        = StatusConstance::ORDER_CANCEL_STATUS;
        $status                     = $order_cancel_status;
        $paramObj                   = Order::find($id);
        $paramObj->status           = $status;
        $result                     = $this->InvoiceRepository->updateOrder($paramObj);
        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
            $output     = array('message'=>'success');
            return \Response::json($output);
        }
        else{
            $output     = array('message'=>'faile');
            return \Response::json($output);
        }
    }

    public function redirectRequest($id)
    {
        return redirect()->action('Cashier\Invoice\InvoiceController@invoiceList')
                ->withMessage(FormatGenerator::message('Fail', 'Table did not update ...'));
    }

    public function SearchRequest(Request $request) {
        $status             = StatusConstance::ORDER_CANCEL_STATUS;
        $totalData          = Order::where('status','!=',StatusConstance::ORDER_CANCEL_STATUS)->count();
        $totalFiltered      = $totalData;
        $dir                = $request->input('order.0.dir');
        $limit              = (int)($request->input('length'));
        $start              = (int)($request->input('start'));
        $order_search       = $request->input('columns.0.search.value');
        $amount_search      = $request->input('columns.1.search.value');
        $date_search        = $request->input('columns.2.search.value');

        if(empty($order_search) || empty($amount_search) || empty($date_search)) {           
            $posts          = Order::where('status','!=',StatusConstance::ORDER_CANCEL_STATUS)
                            ->orderBy('id', 'desc')
                            ->offset($start)
                            ->limit($limit)
                            ->get();
        } 
        //Search From Order ID Field
        if (!empty($request->input('columns.0.search.value'))) {
            $search         = $request->input('columns.0.search.value');
            $posts          =  Order::where('status','!=',StatusConstance::ORDER_CANCEL_STATUS)
                            ->where('id','LIKE',"%{$search}%")
                            ->orderBy('id', 'desc')
                            ->offset($start)
                            ->limit($limit)
                            ->get();

            $totalFiltered = Order::where('status','!=',StatusConstance::ORDER_CANCEL_STATUS)
                             ->where('id','LIKE',"%{$search}%")
                             ->count();
        }
        //Search From Amount Field
        if (!empty($request->input('columns.1.search.value'))) {
            $search         = $request->input('columns.1.search.value');
            $posts          =  Order::where('status','!=',StatusConstance::ORDER_CANCEL_STATUS)
                            ->where('all_total_amount', 'LIKE',"%{$search}%")
                            ->orderBy('id', 'desc')
                            ->offset($start)
                            ->limit($limit)
                            ->get();

            $totalFiltered = Order::where('status','!=',StatusConstance::ORDER_CANCEL_STATUS)
                             ->Where('all_total_amount', 'LIKE',"%{$search}%")
                             ->count();
        }
        //Search From Date Field
        if (!empty($request->input('columns.2.search.value'))) {
            $search         = $request->input('columns.2.search.value');
            $posts          =  Order::where('status','!=',StatusConstance::ORDER_CANCEL_STATUS)
                            ->Where('created_at', 'LIKE',"%{$search}%")
                            ->orderBy('id', 'desc')
                            ->offset($start)
                            ->limit($limit)
                            ->get();

            $totalFiltered = Order::where('status','!=',StatusConstance::ORDER_CANCEL_STATUS)
                             ->Where('created_at', 'LIKE',"%{$search}%")
                             ->count();
        }


        $data = array();
        if(!empty($posts))
        {
            foreach ($posts as $post)
            {

                $nestedData[0] = $post->id;
                $nestedData[1] = $post->all_total_amount;
                $nestedData[2] = date('j M Y h:i a',strtotime($post->created_at));
                $post_view     = '/Backend/invoice/detail/' . $post->id;
                $nestedData[3] = "<a href='" . $post_view . "'>View Detail </a>";
                $status        = $post->status;
                if ($status == StatusConstance::ORDER_CREATE_STATUS) {
                    $nestedData[4] = "<lable class='text-warning'>Unpaid</lable>";
                } elseif($status == StatusConstance::ORDER_PAID_STATUS) {
                    $nestedData[4] = "<lable class='text-success'>paid</lable>";
                }
                $data[] = $nestedData;

            }
        }

        $array      = array(
                        "draw"            => intval($request->input('draw')),  
                        "recordsTotal"    => intval($totalData),  
                        "recordsFiltered" => intval($totalFiltered), 
                        "data"            => $data 
                        );
        return \Response::json($array);

    }

    public function TimeIncreaseRequest(Request $request) {
        $status             = StatusConstance::ORDER_CANCEL_STATUS;
        $totalData          = Order::where('status','!=',StatusConstance::ORDER_CANCEL_STATUS)->count();
        $totalFiltered      = $totalData;
        $dir                = $request->input('order.0.dir');
        $limit              = (int)($request->input('length'));
        $start              = (int)($request->input('start'));
        $order_search       = $request->input('columns.0.search.value');
        $amount_search      = $request->input('columns.1.search.value');
        $date_search        = $request->input('columns.2.search.value');

        if(empty($order_search) || empty($amount_search) || empty($date_search)) {           
            $posts          = Order::where('status','!=',StatusConstance::ORDER_CANCEL_STATUS)
                            ->orderBy('created_at', 'desc')
                            ->offset($start)
                            ->offset($start)
                            ->limit($limit)
                            ->get();
        } 
        //Search From Order ID Field
        if (!empty($request->input('columns.0.search.value'))) {
            $search         = $request->input('columns.0.search.value');
            $posts          =  Order::where('status','!=',StatusConstance::ORDER_CANCEL_STATUS)
                            ->where('id','LIKE',"%{$search}%")
                            ->orderBy('created_at', 'desc')
                            ->offset($start)
                            ->limit($limit)
                            ->get();

            $totalFiltered = Order::where('status','!=',StatusConstance::ORDER_CANCEL_STATUS)
                             ->where('id','LIKE',"%{$search}%")
                             ->count();
        }
        //Search From Amount Field
        if (!empty($request->input('columns.1.search.value'))) {
            $search         = $request->input('columns.1.search.value');
            $posts          =  Order::where('status','!=',StatusConstance::ORDER_CANCEL_STATUS)
                            ->where('all_total_amount', 'LIKE',"%{$search}%")
                            ->orderBy('created_at', 'desc')
                            ->offset($start)
                            ->limit($limit)
                            ->get();

            $totalFiltered = Order::where('status','!=',StatusConstance::ORDER_CANCEL_STATUS)
                             ->Where('all_total_amount', 'LIKE',"%{$search}%")
                             ->count();
        }
        //Search From Date Field
        if (!empty($request->input('columns.2.search.value'))) {
            $search         = $request->input('columns.2.search.value');
            $posts          =  Order::where('status','!=',StatusConstance::ORDER_CANCEL_STATUS)
                            ->Where('created_at', 'LIKE',"%{$search}%")
                            ->orderBy('created_at', 'desc')
                            ->offset($start)
                            ->limit($limit)
                            ->get();

            $totalFiltered = Order::where('status','!=',StatusConstance::ORDER_CANCEL_STATUS)
                             ->Where('created_at', 'LIKE',"%{$search}%")
                             ->count();
        }


        $data = array();
        if(!empty($posts))
        {
            foreach ($posts as $post)
            {

                $nestedData[0] = $post->id;
                $nestedData[1] = $post->all_total_amount;
                $nestedData[2] = date('j M Y h:i a',strtotime($post->created_at));
                $post_view     = '/Backend/invoice/detail/' . $post->id;
                $nestedData[3] = "<a href='" . $post_view . "'>View Detail </a>";
                $status        = $post->status;
                if ($status == StatusConstance::ORDER_CREATE_STATUS) {
                    $nestedData[4] = "<lable class='text-warning'>Unpaid</lable>";
                } elseif($status == StatusConstance::ORDER_PAID_STATUS) {
                    $nestedData[4] = "<lable class='text-success'>paid</lable>";
                }
                $data[] = $nestedData;

            }
        }

        $array      = array(
                        "draw"            => intval($request->input('draw')),  
                        "recordsTotal"    => intval($totalData),  
                        "recordsFiltered" => intval($totalFiltered), 
                        "data"            => $data 
                        );
        return \Response::json($array);

    }

    public function TimeDecreaseRequest(Request $request) {
        $status             = StatusConstance::ORDER_CANCEL_STATUS;
        $totalData          = Order::where('status','!=',StatusConstance::ORDER_CANCEL_STATUS)->count();
        $totalFiltered      = $totalData;
        $dir                = $request->input('order.0.dir');
        $limit              = (int)($request->input('length'));
        $start              = (int)($request->input('start'));
        $order_search       = $request->input('columns.0.search.value');
        $amount_search      = $request->input('columns.1.search.value');
        $date_search        = $request->input('columns.2.search.value');

        if(empty($order_search) || empty($amount_search) || empty($date_search)) {           
            $posts          = Order::where('status','!=',StatusConstance::ORDER_CANCEL_STATUS)
                            ->orderBy('created_at', 'asc')
                            ->offset($start)
                            ->offset($start)
                            ->limit($limit)
                            ->get();
        } 
        //Search From Order ID Field
        if (!empty($request->input('columns.0.search.value'))) {
            $search         = $request->input('columns.0.search.value');
            $posts          =  Order::where('status','!=',StatusConstance::ORDER_CANCEL_STATUS)
                            ->where('id','LIKE',"%{$search}%")
                            ->orderBy('created_at', 'asc')
                            ->offset($start)
                            ->limit($limit)
                            ->get();

            $totalFiltered = Order::where('status','!=',StatusConstance::ORDER_CANCEL_STATUS)
                             ->where('id','LIKE',"%{$search}%")
                             ->count();
        }
        //Search From Amount Field
        if (!empty($request->input('columns.1.search.value'))) {
            $search         = $request->input('columns.1.search.value');
            $posts          =  Order::where('status','!=',StatusConstance::ORDER_CANCEL_STATUS)
                            ->where('all_total_amount', 'LIKE',"%{$search}%")
                            ->orderBy('created_at', 'asc')
                            ->offset($start)
                            ->limit($limit)
                            ->get();

            $totalFiltered = Order::where('status','!=',StatusConstance::ORDER_CANCEL_STATUS)
                             ->Where('all_total_amount', 'LIKE',"%{$search}%")
                             ->count();
        }
        //Search From Date Field
        if (!empty($request->input('columns.2.search.value'))) {
            $search         = $request->input('columns.2.search.value');
            $posts          =  Order::where('status','!=',StatusConstance::ORDER_CANCEL_STATUS)
                            ->Where('created_at', 'LIKE',"%{$search}%")
                            ->orderBy('created_at', 'asc')
                            ->offset($start)
                            ->limit($limit)
                            ->get();

            $totalFiltered = Order::where('status','!=',StatusConstance::ORDER_CANCEL_STATUS)
                             ->Where('created_at', 'LIKE',"%{$search}%")
                             ->count();
        }


        $data = array();
        if(!empty($posts))
        {
            foreach ($posts as $post)
            {

                $nestedData[0] = $post->id;
                $nestedData[1] = $post->all_total_amount;
                $nestedData[2] = date('j M Y h:i a',strtotime($post->created_at));
                $post_view     = '/Backend/invoice/detail/' . $post->id;
                $nestedData[3] = "<a href='" . $post_view . "'>View Detail </a>";
                $status        = $post->status;
                if ($status == StatusConstance::ORDER_CREATE_STATUS) {
                    $nestedData[4] = "<lable class='text-warning'>Unpaid</lable>";
                } elseif($status == StatusConstance::ORDER_PAID_STATUS) {
                    $nestedData[4] = "<lable class='text-success'>paid</lable>";
                }
                $data[] = $nestedData;

            }
        }

        $array      = array(
                        "draw"            => intval($request->input('draw')),  
                        "recordsTotal"    => intval($totalData),  
                        "recordsFiltered" => intval($totalFiltered), 
                        "data"            => $data 
                        );
        return \Response::json($array);

    }

    public function PriceIncreaseRequest(Request $request) {
        $status             = StatusConstance::ORDER_CANCEL_STATUS;
        $totalData          = Order::where('status','!=',StatusConstance::ORDER_CANCEL_STATUS)->count();
        $totalFiltered      = $totalData;
        $dir                = $request->input('order.0.dir');
        $limit              = (int)($request->input('length'));
        $start              = (int)($request->input('start'));
        $order_search       = $request->input('columns.0.search.value');
        $amount_search      = $request->input('columns.1.search.value');
        $date_search        = $request->input('columns.2.search.value');

        if(empty($order_search) || empty($amount_search) || empty($date_search)) {           
            $posts          = Order::where('status','!=',StatusConstance::ORDER_CANCEL_STATUS)
                            ->orderBy('all_total_amount', 'desc')
                            ->offset($start)
                            ->offset($start)
                            ->limit($limit)
                            ->get();
        } 
        //Search From Order ID Field
        if (!empty($request->input('columns.0.search.value'))) {
            $search         = $request->input('columns.0.search.value');
            $posts          =  Order::where('status','!=',StatusConstance::ORDER_CANCEL_STATUS)
                            ->where('id','LIKE',"%{$search}%")
                            ->orderBy('all_total_amount', 'desc')
                            ->offset($start)
                            ->limit($limit)
                            ->get();

            $totalFiltered = Order::where('status','!=',StatusConstance::ORDER_CANCEL_STATUS)
                             ->where('id','LIKE',"%{$search}%")
                             ->count();
        }
        //Search From Amount Field
        if (!empty($request->input('columns.1.search.value'))) {
            $search         = $request->input('columns.1.search.value');
            $posts          =  Order::where('status','!=',StatusConstance::ORDER_CANCEL_STATUS)
                            ->where('all_total_amount', 'LIKE',"%{$search}%")
                            ->orderBy('all_total_amount', 'desc')
                            ->offset($start)
                            ->limit($limit)
                            ->get();

            $totalFiltered = Order::where('status','!=',StatusConstance::ORDER_CANCEL_STATUS)
                             ->Where('all_total_amount', 'LIKE',"%{$search}%")
                             ->count();
        }
        //Search From Date Field
        if (!empty($request->input('columns.2.search.value'))) {
            $search         = $request->input('columns.2.search.value');
            $posts          =  Order::where('status','!=',StatusConstance::ORDER_CANCEL_STATUS)
                            ->Where('created_at', 'LIKE',"%{$search}%")
                            ->orderBy('all_total_amount', 'desc')
                            ->offset($start)
                            ->limit($limit)
                            ->get();

            $totalFiltered = Order::where('status','!=',StatusConstance::ORDER_CANCEL_STATUS)
                             ->Where('all_total_amount', 'LIKE',"%{$search}%")
                             ->count();
        }


        $data = array();
        if(!empty($posts))
        {
            foreach ($posts as $post)
            {

                $nestedData[0] = $post->id;
                $nestedData[1] = $post->all_total_amount;
                $nestedData[2] = date('j M Y h:i a',strtotime($post->created_at));
                $post_view     = '/Backend/invoice/detail/' . $post->id;
                $nestedData[3] = "<a href='" . $post_view . "'>View Detail </a>";
                $status        = $post->status;
                if ($status == StatusConstance::ORDER_CREATE_STATUS) {
                    $nestedData[4] = "<lable class='text-warning'>Unpaid</lable>";
                } elseif($status == StatusConstance::ORDER_PAID_STATUS) {
                    $nestedData[4] = "<lable class='text-success'>paid</lable>";
                }
                $data[] = $nestedData;

            }
        }

        $array      = array(
                        "draw"            => intval($request->input('draw')),  
                        "recordsTotal"    => intval($totalData),  
                        "recordsFiltered" => intval($totalFiltered), 
                        "data"            => $data 
                        );
        return \Response::json($array);

    }

    public function PriceDecreaseRequest(Request $request) {
        $status             = StatusConstance::ORDER_CANCEL_STATUS;
        $totalData          = Order::where('status','!=',StatusConstance::ORDER_CANCEL_STATUS)->count();
        $totalFiltered      = $totalData;
        $dir                = $request->input('order.0.dir');
        $limit              = (int)($request->input('length'));
        $start              = (int)($request->input('start'));
        $order_search       = $request->input('columns.0.search.value');
        $amount_search      = $request->input('columns.1.search.value');
        $date_search        = $request->input('columns.2.search.value');

        if(empty($order_search) || empty($amount_search) || empty($date_search)) {           
            $posts          = Order::where('status','!=',StatusConstance::ORDER_CANCEL_STATUS)
                            ->orderBy('all_total_amount', 'asc')
                            ->offset($start)
                            ->offset($start)
                            ->limit($limit)
                            ->get();
        } 
        //Search From Order ID Field
        if (!empty($request->input('columns.0.search.value'))) {
            $search         = $request->input('columns.0.search.value');
            $posts          =  Order::where('status','!=',StatusConstance::ORDER_CANCEL_STATUS)
                            ->where('id','LIKE',"%{$search}%")
                            ->orderBy('all_total_amount', 'asc')
                            ->offset($start)
                            ->limit($limit)
                            ->get();

            $totalFiltered = Order::where('status','!=',StatusConstance::ORDER_CANCEL_STATUS)
                             ->where('id','LIKE',"%{$search}%")
                             ->count();
        }
        //Search From Amount Field
        if (!empty($request->input('columns.1.search.value'))) {
            $search         = $request->input('columns.1.search.value');
            $posts          =  Order::where('status','!=',StatusConstance::ORDER_CANCEL_STATUS)
                            ->where('all_total_amount', 'LIKE',"%{$search}%")
                            ->orderBy('all_total_amount', 'asc')
                            ->offset($start)
                            ->limit($limit)
                            ->get();

            $totalFiltered = Order::where('status','!=',StatusConstance::ORDER_CANCEL_STATUS)
                             ->Where('all_total_amount', 'LIKE',"%{$search}%")
                             ->count();
        }
        //Search From Date Field
        if (!empty($request->input('columns.2.search.value'))) {
            $search         = $request->input('columns.2.search.value');
            $posts          =  Order::where('status','!=',StatusConstance::ORDER_CANCEL_STATUS)
                            ->Where('created_at', 'LIKE',"%{$search}%")
                            ->orderBy('all_total_amount', 'asc')
                            ->offset($start)
                            ->limit($limit)
                            ->get();

            $totalFiltered = Order::where('status','!=',StatusConstance::ORDER_CANCEL_STATUS)
                             ->Where('all_total_amount', 'LIKE',"%{$search}%")
                             ->count();
        }


        $data = array();
        if(!empty($posts))
        {
            foreach ($posts as $post)
            {

                $nestedData[0] = $post->id;
                $nestedData[1] = $post->all_total_amount;
                $nestedData[2] = date('j M Y h:i a',strtotime($post->created_at));
                $post_view     = '/Backend/invoice/detail/' . $post->id;
                $nestedData[3] = "<a href='" . $post_view . "'>View Detail </a>";
                $status        = $post->status;
                if ($status == StatusConstance::ORDER_CREATE_STATUS) {
                    $nestedData[4] = "<lable class='text-warning'>Unpaid</lable>";
                } elseif($status == StatusConstance::ORDER_PAID_STATUS) {
                    $nestedData[4] = "<lable class='text-success'>paid</lable>";
                }
                $data[] = $nestedData;

            }
        }

        $array      = array(
                        "draw"            => intval($request->input('draw')),  
                        "recordsTotal"    => intval($totalData),  
                        "recordsFiltered" => intval($totalFiltered), 
                        "data"            => $data 
                        );
        return \Response::json($array);

    }

    public function CancelRequest(Request $request) {
        $status             = StatusConstance::ORDER_CANCEL_STATUS;
        $totalData          = Order::where('status','!=',StatusConstance::ORDER_CANCEL_STATUS)->count();
        $totalFiltered      = $totalData;
        $dir                = $request->input('order.0.dir');
        $limit              = (int)($request->input('length'));
        $start              = (int)($request->input('start'));
        $order_search       = $request->input('columns.0.search.value');
        $amount_search      = $request->input('columns.1.search.value');
        $date_search        = $request->input('columns.2.search.value');

        if(empty($order_search) || empty($amount_search) || empty($date_search)) {           
            $posts          = Order::where('status','=',StatusConstance::ORDER_CANCEL_STATUS)
                            ->offset($start)
                            ->offset($start)
                            ->limit($limit)
                            ->get();
        } 
        //Search From Order ID Field
        if (!empty($request->input('columns.0.search.value'))) {
            $search         = $request->input('columns.0.search.value');
            $posts          =  Order::where('status','=',StatusConstance::ORDER_CANCEL_STATUS)
                            ->where('id','LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->get();

            $totalFiltered = Order::where('status','=',StatusConstance::ORDER_CANCEL_STATUS)
                             ->where('id','LIKE',"%{$search}%")
                             ->count();
        }
        //Search From Amount Field
        if (!empty($request->input('columns.1.search.value'))) {
            $search         = $request->input('columns.1.search.value');
            $posts          =  Order::where('status','=',StatusConstance::ORDER_CANCEL_STATUS)
                            ->where('all_total_amount', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->get();

            $totalFiltered = Order::where('status','=',StatusConstance::ORDER_CANCEL_STATUS)
                             ->Where('all_total_amount', 'LIKE',"%{$search}%")
                             ->count();
        }
        //Search From Date Field
        if (!empty($request->input('columns.2.search.value'))) {
            $search         = $request->input('columns.2.search.value');
            $posts          =  Order::where('status','=',StatusConstance::ORDER_CANCEL_STATUS)
                            ->Where('created_at', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->get();

            $totalFiltered = Order::where('status','=',StatusConstance::ORDER_CANCEL_STATUS)
                            ->Where('created_at', 'LIKE',"%{$search}%")
                             ->count();
        }


        $data = array();
        if(!empty($posts))
        {
            foreach ($posts as $post)
            {

                $nestedData[0] = $post->id;
                $nestedData[1] = $post->all_total_amount;
                $nestedData[2] = date('j M Y h:i a',strtotime($post->created_at));
                $post_view     = '/Backend/invoice/detail/' . $post->id;
                $nestedData[3] = "<a href='" . $post_view . "'>View Detail </a>";
                $status        = $post->status;
                if ($status == StatusConstance::ORDER_CREATE_STATUS) {
                    $nestedData[4] = "<lable class='text-warning'>Unpaid</lable>";
                } elseif($status == StatusConstance::ORDER_PAID_STATUS) {
                    $nestedData[4] = "<lable class='text-success'>paid</lable>";
                }
                $data[] = $nestedData;

            }
        }

        $array      = array(
                        "draw"            => intval($request->input('draw')),  
                        "recordsTotal"    => intval($totalData),  
                        "recordsFiltered" => intval($totalFiltered), 
                        "data"            => $data 
                        );
        return \Response::json($array);

    }
    public function checkManager($managerLogin,$managerPass) {
        // $manager_raw    = DB::select("SELECT password FROM `users` WHERE user_name = '$managerLogin' AND deleted_at IS NULL");
        $manager_user      = User::select('password')
                            ->where('user_name','=',$managerLogin)
                            ->where('role_id','=','1')
                            ->orwhere('role_id','=','2')
                            ->orwhere('role_id','=','3')
                            ->whereNull('deleted_at')->first();
        if ($manager_user && Hash::check($managerPass, $manager_user->password)) {
            $output     = array('message'=>'success');
            return \Response::json($output);
        } else {
            $output     = array('message'=>'fail');
            return \Response::json($output);    
        }
        
    }
    public function invoiceprint($id){
        $orders = $this->InvoiceRepository->getorder($id);
        $add    = $this->InvoiceRepository->getaddon($id);
        $total  = $this->InvoiceRepository->getaddonAmount($id);
        $addon  = array();
        foreach($add as $dd){
            foreach($dd as $d){
                $addon[] = $d;
            }
        }
        
        $amount = array();
        foreach($total as $t){
            foreach($t as $tt){
                $amount[] = $tt;
            }
        }
        
        $order_detail   = $this->InvoiceRepository->getdetail($id);
        $tables         = $this->InvoiceRepository->orderTable($id);
        $rooms          = $this->InvoiceRepository->orderRoom($id);
        $cashier         = $this->InvoiceRepository->cashier($id);
        $config         = Config::select('restaurant_name','email','logo','website','address','phone','tax','service')->first();

        $html ='<h1>Invoice Detail</h1>
                <table >
                <tr>
                <th colspan="2"><img id="filename" class="bottom image header_logo" src="uploads/'.$config->logo.'" style="height: 60px; width:100px;">
                </th>
                <th height="80" colspan="4" style="font-size:10px;font-weight:bold;">
                    <br/>'.$config->restaurant_name.'<br/>
                    Website: '.$config->website.'<br/>
                     Email: '. $config->email.'<br/>
                     Tel: '.$config->phone.'<br/>
                     Addr: '.$config->address.'
                </th>
                <th colspan="2" style="font-size:10px;font-weight:bold;">
                    <br/> Invoice No: '.$orders->order_id.'<br/>
                     Invoice Date:'.$orders->order_time.'<br/>';
                if(isset($tables)){ 
                    foreach($tables as $table){                  
                        $html.= 'Table No: '.$table->table_no;
                    }
                }
                if(isset($rooms)){
                    foreach($rooms as $room){
                        $html.= 'Room No: '.$room->room_name;
                    }
                }
                $html.=  '<br/>';
                $html.= 'Waiter Name: '. $cashier->User->user_name;
                $html.= '</th>
                        </tr>
                        <tr  class="invoice_header"  style="font-size:10px;font-weight:bold;">
                        <th height="30" >Product Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Amount</th>
                        <th>Addon</th>
                        <th>Addon Price</th>
                        <th>Discount</th>
                        <th>Total Amount</th>
                        </tr>';
                $t=0; $tt=0; $sub_total=0;$add_qty=0;
                    foreach($order_detail as $detail){
                        $html.= '<tr class="invoice_body" style="font-size:9px;" >
                                <td height="20">';
                    if(isset($detail->item_name)){
                $html.=$detail->item_name;
                         }else{
                $html.= $detail->set_name;
                        }
                $html.= '</td>';
                $html.='<td>'.$detail->quantity.'</td>';
                $html.='<td>'.number_format($detail->amount).'</td>';
                $html.='<td>'.number_format($detail->quantity * $detail->amount).'</td>';
                $html.='<td>';
                    foreach($addon as $add){
                        if($detail->id == $add['order_detail_id']){
                            $add['food_name'];
                        }
                    }
                $html.='</td>';  
                $html.='<td>';
                        foreach($amount as $am){
                            if($detail->id == $am['order_detail_id']){
                                ($am['amount']) * ($detail->quantity) ;
                            }
                        }
                $html.='</td>';
                $html.='<td>'.$detail->discount_amount.'</td>';
                $html.='<td>'.number_format($detail->amount_with_discount).'</td>';
                $html.='</tr>';
                    $sub_total += $detail->amount_with_discount;
                            }
                $html.=' <tr class="invoice_body inv_head" style="font-size:10px;font-weight:bold;">
                    <td colspan="6" ></td>
                    <td>Sub Total</td>';
                $html.='<td height="20">'.number_format($sub_total) .'</td>';
                $html.='</tr>';
                $html.='<tr class="invoice_body inv_head" style="font-size:10px;font-weight:bold;">
                        <td colspan="5"></td><td colspan="2" style="text-align:center;">Service Amount</td>';
                $html.='<td height="20">'.$orders->service_amount.'</td>';
                $html.='</tr>
                        <tr class="invoice_body inv_head" style="font-size:10px;font-weight:bold;">
                        <td colspan="6"></td><td>Tax Amount</td>';
                $html.='<td height="20" >'.$orders->tax_amount.'</td>';
                $html.='</tr>
                        <tr class="invoice_body inv_head" style="font-size:10px;font-weight:bold;">
                        <td colspan="5"></td><td colspan="2">Member Discount Amount</td>';
                $html.='<td height="20">'.$orders->member_discount.'</td>';
                $html.='</tr>
                        <tr class="invoice_body inv_head" style="font-size:10px;font-weight:bold;">
                        <td colspan="6"></td><td>Net Amount</td>';
                $html.='<td height="20">'.number_format($orders->all_total_amount).'</td>';
                $html.='</tr></tbody></table>';
 
        ob_end_clean(); //solve for causing TCPDF ERROR: Some data has already been output, can't send PDF file

                Utility::exportPDF($html);
        return redirect('/');
    }

}
