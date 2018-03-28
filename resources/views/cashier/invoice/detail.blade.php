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
                <div class="invoice-title"><p class="text-center">Invoice Detail</p></div>
                    <div class="invoice-table-wrapper">
                        <table class="print-invoice">
                            <thead>
                                <tr>
                                    <td colspan="4" class="text-center">
                                        {{ $config->restaurant_name}}<br/>
                                        Website: {{ $config->website}}<br/>
                                        Email: {{ $config->email }}<br/>
                                        Tel: {{ $config->phone}}<br/>
                                        Addr: {{ $config->address}}<br /><br/>
                                        <span style="float:left">Invoice No: {{ $orders->order_id}}</span><br/>
                                        <span style="float:left">Invoice Date:{{$orders->order_time}}</span><br/>
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
                                    </td>
                                </tr>

                                <tr class="dash-border">
                                    <td width="10%">Qty</th>
                                    <td width="50%">Product</th>
                                    <td class="text-right" width="20%">Price</th>
                                    <td class="text-right" width="20%">Amount</th>
                                </tr>
                            </thead>
                            
                            <tbody style="font-size:13px;line-height:25px;">
                                @foreach($order_detail as $detail)
                                <tr style="vertical-align: text-top;">
                                    <td> {{$detail->quantity }}</td>
                                    <td style="font-family:zawgyi-one">
                                        @if(isset($detail->item_name))
                                            {{$detail->item_name}}
                                            @if ($detail->has_continent)
                                                @foreach($continent as $con)
                                                    @if ($detail->continent_id == $con->id)
                                                        ({{ $con->name }})
                                                    @endif
                                                @endforeach
                                            @endif
                                        @else
                                            {{ $detail->set_name }}
                                        @endif
                                    </td>
                                    <td class="text-right">{{ number_format($detail->amount)  }}</td>
                                    <td class="text-right">{{number_format($detail->quantity * $detail->amount)}}</td>
                                </tr>

                                    @foreach($addon as $add)
                                        @if($detail->order_detail_id == $add['order_detail_id'])
                                            <tr class="i-title">
                                                <td>{{ $add['quantity']}}</td>
                                                <td>{{ $add['food_name']}}</td>
                                                <td class="text-right">{{ $add['amount']}}</td>
                                                <td class="text-right">{{number_format($add['quantity'] * $add['amount'])}}</td>
                                            </tr>
                                        @endif

                                    @endforeach  

                                @endforeach
                                <tr class="dash-border">
                                    <td colspan="4"></td>
                                </tr>
                                
                                <tr class="i-title">
                                    <td colspan="3">Total: (Exclusive Tax)</td>
                                    <td class="text-right">{{ number_format($orders->total_price) }}</td>
                                </tr>
                                @if(isset($rooms))
                                    <tr class="dash-border">
                                        <td colspan="3">Room Charge</td>
                                        <td class="text-right">{{ $orders->room_charge }}</td>
                                    </tr>
                                @endif

                                <tr class="i-title">
                                    <td colspan="3">Service Tax ({{ $config->service}} %)</td>
                                    <td class="text-right">{{ $orders->service_amount }}</td>
                                </tr>

                                <tr class="i-title">
                                    <td colspan="3">GST ({{$config->tax}} %)</td>
                                    <td class="text-right">{{ $orders->tax_amount }}</td>
                                </tr>
                                
                                <tr class="dash-border">
                                    <td colspan="3">Discount</td>
                                    <td class="text-right">{{ $orders->total_discount_amount }}</td>
                                </tr>
                                
                                <tr class="dash-border">
                                    <td colspan="3">FOC</td>
                                    <td class="text-right" class="foc-amount">{{ $orders->foc_amount }}</td>
                                </tr>
                                <tr class="dash-border" class="net-amount">
                                    <td colspan="3">Net Amount</td>
                                    <td class="text-right">{{ number_format($orders->all_total_amount) }} </td>
                                </tr>


                                @foreach($payments as $payment)
                                <tr class="tr-bottom-dashed i-title payment-amount">
                                    <td colspan="3">Paid {{ $payment['name'] }}</td>
                                    <td class="text-right">{{ number_format($payment['paid_amount']) }}</td>
                                </tr>
                                @endforeach

                                <tr class="dash-border">
                                    <td colspan="3">Change</td>
                                    <td class="text-right">{{ number_format($orders->refund) }}</td>
                                </tr>

                                <tr class="text-center">
                                    <td colspan="4" >Thank You</td>
                                </tr>

                                <tr class="text-center">
                                    <td colspan="4" ><a href="/Cashier/invoice" class="btn btn-primary">Go Back</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
