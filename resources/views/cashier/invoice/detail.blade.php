@extends('cashier.layouts.master')
@section('title','Invoice Listing')
@section('content')
    <div class="row">
        <div class="container">

            @if(count(Session::get('message')) != 0)
                <div>
                </div>
            @endif
        </div>
    </div>
    <div class="container">
        <div class="row">
            {{--heading title--}}


        </div>
    </div>
    {{--tables--}}
    <div class="container">
        <div class="row">
            <div class="col-md-12 tbl-container">
                <div class="invoice-wrapper">
                <div class=""><p class="text-center">Invoice Detail</p></div>
                    <div class="invoice-table-wrapper">
                        <div id="{{$order->order_id}}-print-table" style="font-family:'Courier New',Times New Roman;font-weight: bold;">
                        <table class="print-invoice" style="border-collapse: collapse;width:83mm;margin:0 auto;table-layout: fixed;word-wrap: break-word;background:none;">
                            <col width="80">
                            <col width="40">
                            <col width="40">
                            <col width="50">
                            <thead>
                                <tr>
                                    <td colspan="4" style="text-align:center;font-size:13px;line-height:25px;padding:5px 7px;">
                                        {{ $config->restaurant_name}}<br/>
                                        Website: {{ $config->website}}<br/>
                                        Email: {{ $config->email }}<br/>
                                        Tel: {{ $config->phone}}<br/>
                                        Addr: {{ $config->address}}<br /><br />
                                        <span style="float:left">Invoice No: {{ $order->order_id}}</span><br/>
                                        <span style="float:left">Invoice Date:{{$order->order_time}}</span><br/>
                                        @if(count($tables)>0)
                                            Table No :
                                            @foreach($tables as $table)
                                                {{ $table->table_no . "," }}
                                            @endforeach
                                        @elseif(count($rooms)>0)
                                            Room No :
                                            @foreach($rooms as $room)
                                                {{ $room->room_name  }}
                                            @endforeach
                                        @else
                                            {{ "Take Away "}}
                                        @endif
                                    </td>
                                </tr>
                                <tr style="border-bottom:1px dashed black;font-size:13px;line-height:25px;">
                                    <td>Item</th>
                                    <td>Price</th>
                                    <td>Qty</th>
                                    <td align="right">Amount</th>
                                </tr>
                            </thead>
                            
                            <tbody style="font-size:13px;line-height:25px;">
                                @php $v = '' @endphp
                                @foreach($details as $detail)
                                    <tr>
        
                                            @php 
                                            $qty = App\RMS\Orderdetail\Orderdetail::where('order_id',$detail['order_id'])
                                                                                ->where('item_id',$detail['item_id'])
                                                                                ->count() ; 
    
                                            $qty2 = App\RMS\Orderdetail\Orderdetail::where('order_id',$detail['order_id'])
                                            ->where('item_id',$detail['item_id'])
                                            ->sum('quantity');                         
    
                                            @endphp
                                            @if($qty > 1)
                                                @if($v != $detail['item_id'])
                                                @php $v = $detail['item_id'] @endphp
                                                    <td class="no-border" style="">{{ $detail['item_name'] }}</td>
                                                    <td class="no-border">{{ $detail['amount'] }}</td>
                                                    <td class="no-border">{{ $qty2 }}</td>
                                                    <td class="no-border" align="right">{{ $detail['amount']* $qty2 }} </td>
                                                @endif
                                            @else
        
                                                <td class="no-border">{{ $detail['item_name'] }}</td>
                                                <td class="no-border">{{ $detail['amount'] }}</td>
                                                <td class="no-border">{{ $qty2 }}</td>
                                                <td class="no-border" align="right">{{ $detail['amount']* $qty2 }} </td>
                                            @endif                                                                                            
                                    </tr>
                                @endforeach
    
                                @foreach($addon as $add)
                                            
                                <tr>
                                    <td class="no-border">{{ $add['food_name']}} (addon)</td>
                                    <td class="no-border">{{ $add['amount'] }}</td>
                                    <td class="no-border">{{ $add['quantity'] }} </td>
                                    <td class="no-border" align="right">{{ $add['amount'] * $add['quantity'] }}</td>
                                </tr>
    
                                @endforeach
    
                                <tr style="border-bottom:1px dashed black;">
                                    <td colspan="4" style="height:5px;"></td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="height:25px;padding:5px 7px;">Net Amount</td>
                                    <td align="right">{{ number_format($order->total_price) }}</td>
                                </tr>
    
                                <tr>
                                    <td colspan="3" style="height:25px;padding:5px 7px;">Discount</td>
                                    <td align="right">{{ number_format($order->over_all_discount) }}</td>
                                </tr>
    
                                <tr style="border-bottom:1px dashed black;">
                                    <td colspan="4" style="height:5px;"></td>
                                </tr>
    
                                <tr>
                                    <td colspan="3" style="height:25px;padding:5px 7px;">Sub Total</td>
                                    <td align="right">{{ number_format($order->sub_total) }}</td>
                                </tr>
    
                                <tr>
                                    <td colspan="3" style="height:25px;padding:5px 7px;">Service Charge</td>
                                    <td align="right">{{ $order->service_amount }}</td>
                                </tr>
    
                                <tr>
                                    <td colspan="3" style="height:25px;padding:5px 7px;">Tax</td>
                                    <td align="right">{{ $order->tax_amount }}</td>
                                </tr>
                                
                                <tr style="border-bottom:1px dashed black;">
                                    <td colspan="4" style="height:5px;"></td>
                                </tr>
    
                                @if(count($rooms) > 0)
                                    <tr style="border-bottom:1px dashed black;">
                                        <td colspan="3" style="">Room Charge</td>
                                        <td align="right">{{ number_format($order->room_charge) }} </td>
                                    </tr>
                                @endif
                                <tr style="border-bottom:1px dashed black;" class="net-amount">
                                    <td colspan="3" style="height:25px;padding:5px 7px;">Total Amount</td>
                                    <td align="right">{{ number_format($order->all_total_amount) }} </td>
                                </tr>
    
    
                                @foreach($payments as $payment)
                                <tr class="tr-bottom-dashed i-title payment-amount">
                                    <td colspan="3" style="padding:5px 7px;">Paid {{ $payment['name'] }}</td>
                                    <td class="text-right" style="padding:5px 7px;">{{ number_format($payment['paid_amount']) }}</td>
                                </tr>
                                @endforeach
    
                                <tr>
                                    <td colspan="3" style="height:25px;padding:5px 7px;">Change</td>
                                    <td align="right">{{ number_format($order->refund) }}</td>
                                </tr>
    
                                <tr style="text-align:center;">
                                    <td colspan="4" style="height:25px;padding:5px 7px;">Thank You</td>
                                </tr>
                            </tbody>
                        </table> 
                    </div>
                    <div class="text-center mt-2">
                        <a href="{{ url()->previous() }}" class="btn btn-primary">Back</a>
                        @if($order->status == 2)
                        <button class="btn btn-success" id ="{{$order->order_id}}" onClick="print_click(this.id)">Print</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    
            function printElement(e) {
                var ifr = document.createElement('iframe');
                ifr.style='height: 0; width: 0px; position: absolute'
    
                document.body.appendChild(ifr);
    
                $(e).clone().appendTo(ifr.contentDocument.body);
                ifr.contentWindow.print();
    
                ifr.parentElement.removeChild(ifr);
            }
    
            function print_click(clicked_id)
            {
                var clickID     = clicked_id;
                var printID     = clickID + "-print-table";
                var test        = document.getElementById(printID);
                printElement(document.getElementById(printID));
            }
    
        </script>
@endsection
