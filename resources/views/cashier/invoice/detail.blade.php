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
            <a  href="print/{{$orders->order_id}}" role="button"><button type="button" class="btn btn-primary">Print</button></a><br/><br/>
                <table class="invoice_table">
                    <thead>
                        <tr class="invoice_header inv_head">
                            <th colspan="2">
                                <img id="filename" class="bottom image header_logo" src="../../../uploads/{{$config->logo}}" style="height: 60px; width:200px;">
                            </th>
                            <th colspan="3">
                                {{ $config->restaurant_name}}<br/>
                                Website: {{ $config->website}}<br/>
                                Email: {{ $config->email }}<br/>
                                Tel: {{ $config->phone}}<br/>
                                Addr: {{ $config->address}}
                            </th>
                            <th colspan="3">
                                Invoice No: {{ $orders->order_id}}<br/>
                                Invoice Date:{{$orders->order_time}}<br/>
                               
                                @if(isset($tables))
                                    @foreach($tables as $table)
                                        Table No : {{ $table->table_no }} 
                                    @endforeach
                                @endif
                                @if(isset($rooms))
                                    @foreach($rooms as $room)
                                        Room No : {{ $room->room_name }}
                                    @endforeach
                                @endif
                                <br/>
                               Cashier Name: {{ $cashier->User->user_name}}
                            </th>
                        </tr>
                        <tr class="invoice_header" >
                            <th >Product Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Amount</th>
                            <th>Addon</th>
                            <th>Addon Price</th>
                            <th>Discount</th>
                            <th>Total Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $t=0; $tt=0; $sub_total=0;$add_qty=0; ?>
                        @foreach($order_detail as $detail)
                            <tr class="invoice_body" >
                                <td >
                                    @if(isset($detail->item_name))
                                        {{$detail->item_name}}
                                    @else
                                        {{ $detail->set_name }}
                                    @endif
                                </td>
                                <td>{{$detail->quantity}}</td>
                                <td > {{ number_format($detail->amount)  }} </td>
                                <td>{{number_format($detail->quantity * $detail->amount)}}</td>
                                <td>
                                    @foreach($addon as $add)
                                        @if($detail->order_detail_id == $add['order_detail_id'])
                                            {{ $add['food_name']}}

                                        @endif

                                    @endforeach

                                </td>
                                <td>
                                    @foreach($amount as $am)
                                        @if($detail->order_detail_id == $am['order_detail_id'])
                                            {{ ($am['amount']) *($detail->quantity) }}
                                        @endif     
                                    @endforeach
                                   
                                </td>
                                <td>{{$detail->discount_amount}}</td>
                                <td > {{ number_format($detail->amount_with_discount)}} </td>
                            </tr>
                            <?php $sub_total += $detail->amount_with_discount ?>
                        @endforeach
                        <tr class="invoice_body inv_head">
                            <td colspan="7">Sub Total</td>
                            <td>{{ $sub_total }}</td>
                        </tr>
                        <tr class="invoice_body inv_head">
                            <td colspan="7">Service Amount</td>
                            <td >{{$orders->service_amount}}</td>
                        </tr>
                        <tr class="invoice_body inv_head">
                            <td colspan="7">Tax Amount</td>
                            <td >{{$orders->tax_amount}}</td>
                        </tr>
                        <tr class="invoice_body inv_head">
                            <td colspan="6">Member Discount Amount</td>
                            <td>{{($orders->member_discount)}}<span>%</span>
                            <td><span>-</span>{{($orders->member_discount_amount)}}</td>
                        </tr>
                        <tr class="invoice_body inv_head">
                            <td colspan="7">Net Amount</td>
                            <td>{{ number_format($orders->all_total_amount)}}</td>
                        </tr>        
                    </tbody>
                </table>
                
            </div>
        </div>
    </div>
  

@endsection
