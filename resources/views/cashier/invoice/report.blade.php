@extends('cashier.layouts.master')
@section('title','Report Listing')
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
                <div class=""><p class="text-center">{{$day}} Report</p></div>
                    <div class="invoice-table-wrapper">
                        <div id="-print-table" style="font-family:'Courier New',Times New Roman;font-weight: bold;">
                        <table class="print-invoice" style="border-collapse: collapse;width:83mm;margin:0 auto;table-layout: fixed;word-wrap: break-word;background:none;">
                            <thead>
                                <col width="100">
                                <col width="100">
                                <col width="60">
                                <col width="40">
                                <col width="70">
                                <tr style="border-bottom:1px dashed black;font-size:13px;line-height:25px;">
                                    <td>Order No</td>
                                    <td>Item</th>
                                    <td>Price</th>
                                    <td>Qty</th>
                                    <td align="right">Amount</th>
                                </tr>
                            </thead>
                           
                            <tbody style="font-size:13px;line-height:25px;">
                                @php $v = '' ;@endphp
                                @foreach($orders as $order)
                                
                                    @php  $order_details = App\RMS\Orderdetail\Orderdetail::where('order_id',$order->id)
                                                        ->orderBy('item_id','asc')
                                                        ->get() 
                                       
                                    @endphp
                                       
                                    <tr>
                                        @foreach($order_details as $order_detail)
                                            
                                                @if($v != $order_detail->order_id)
                                                @php $v = $order_detail->order_id @endphp
                                                <tr>   
                                                        <td>{{ $order_detail->order_id }}</td>
                                                        <td>{{ $order_detail->item->name }}</td>
                                                        <td>{{ $order_detail->item->price }}</td>
                                                        <td>{{ $order_detail->quantity }}</td>
                                                        <td align="right">{{ $order_detail->item->price * $order_detail->quantity }}</td>
                                                </tr>

                                                @else
                                               
                                                <tr>
                                                    <td></td>
                                                    <td>{{ $order_detail->item->name }}</td>
                                                    <td>{{ $order_detail->item->price }}</td>
                                                    <td>{{ $order_detail->quantity }}</td>
                                                    <td align="right">{{  $order_detail->item->price * $order_detail->quantity }}</td>
                                                </tr>
                                                @endif
                                        @endforeach
                                    </tr>
                                @endforeach
                
                                <tr>
                                    <td colspan="3">Total Add on </td>
                                   <td>{{$order_extra_quantity }}</td>
                                   <td align="right">{{ $order_extra_sum }}</td
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
