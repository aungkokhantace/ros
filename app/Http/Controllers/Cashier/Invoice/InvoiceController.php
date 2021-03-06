<?php
namespace App\Http\Controllers\Cashier\Invoice;
use Faker\Provider\DateTime;
use Illuminate\Http\Request;
use App\RMS\Invoice\InvoiceRepositoryInterface;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\RMS\Order\Order;
use App\RMS\Orderdetail\Orderdetail;
use App\RMS\Item\Item;
use App\RMS\Config\Config;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use PDF;
use Excel;
use App;
use App\RMS\Utility;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection as Collection;


class InvoiceController extends Controller
{
    private $InvoiceRepository;

    public function __construct(InvoiceRepositoryInterface $InvoiceRepository)
    {
        $this->InvoiceRepository = $InvoiceRepository;
    }
    
    public function invoiceList()
    {
    	$today      = Carbon::now();
    	$cur_date   = Carbon::parse($today)->format('Y-m-d');
        $orders 	= $this->InvoiceRepository->getinvoice();
        return view('cashier.invoice.index',compact('orders'));

    } 

    public function ajaxInvoiceRequest()
    {
        $today      = Carbon::now();
    	$cur_date   = Carbon::parse($today)->format('Y-m-d');
        $orders 	= $this->InvoiceRepository->getinvoice();

        return view('cashier.invoice.invoice',compact('orders'))->render();
    }

    public function invoicedetail($id){
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
        $cashier        = $this->InvoiceRepository->cashier($id);
        $config         = Config::select('restaurant_name','logo','website','address','phone')->first();
       
        return view('cashier.invoice.detail',compact('orders','order_detail','addon','amount','config','tables','rooms','cashier'));
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
        $config         = Config::select('restaurant_name','logo','website','address','phone')->first();

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

