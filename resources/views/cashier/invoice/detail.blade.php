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
                        <table class="print-invoice" style="border:1px solid #F4F4F4;padding: 15px;">
                            <thead>
                                <tr>
                                    <td colspan="4" style="text-align:center;font-size:13px;line-height:25px;">
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

                                <tr style="border-bottom:1px dashed black;font-size:13px;line-height:25px;">
                                    <td style="height:25px;" width="10%">Qty</th>
                                    <td style="height:25px;" width="50%">Product</th>
                                    <td style="text-align:right;height:25px;" width="20%">Price</th>
                                    <td style="text-align:right;height:25px;" width="20%">Amount</th>
                                </tr>
                            </thead>
                            
                            <tbody style="font-size:13px;line-height:25px;">
                                @foreach($order_detail as $detail)
                                <tr style="vertical-align: text-top;">
                                    <td style="height:25px;"> {{$detail->quantity }}</td>
                                    <td style="height:25px;font-family:zawgyi-one">
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
                                    <td style="text-align:right;height:25px;">{{ number_format($detail->amount)  }}</td>
                                    <td style="text-align:right;height:25px;">{{number_format($detail->quantity * $detail->amount)}}</td>
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
                                <tr style="border-bottom:1px dashed black;">
                                    <td colspan="4" style="height:25px;"></td>
                                </tr>
                                
                                <tr class="i-title">
                                    <td colspan="3" style="height:25px;">Total: (Exclusive Tax)</td>
                                    <td style="text-align:right;height:25px;">{{ number_format($orders->total_price) }}</td>
                                </tr>
                                @if(isset($rooms))
                                    <tr style="border-bottom:1px dashed black;">
                                        <td colspan="3" style="height:25px;">Room Charge</td>
                                        <td style="text-align:right;height:25px;">{{ $orders->room_charge }}</td>
                                    </tr>
                                @endif

                                <tr class="i-title">
                                    <td colspan="3" style="height:25px;">Service Tax ({{ $config->service}} %)</td>
                                    <td style="text-align:right;height:25px;">{{ $orders->service_amount }}</td>
                                </tr>

                                <tr class="i-title">
                                    <td colspan="3" style="height:25px;">GST ({{$config->tax}} %)</td>
                                    <td style="text-align:right;height:25px;">{{ $orders->tax_amount }}</td>
                                </tr>
                                
                                <tr style="border-bottom:1px dashed black;">
                                    <td colspan="3" style="height:25px;">Discount</td>
                                    <td style="text-align:right;height:25px;">{{ $orders->total_discount_amount }}</td>
                                </tr>
                                
                                <tr style="border-bottom:1px dashed black;">
                                    <td colspan="3" style="height:25px;">FOC</td>
                                    <td style="text-align:right;height:25px;" class="foc-amount">{{ $orders->foc_amount }}</td>
                                </tr>
                                <tr style="border-bottom:1px dashed black;" class="net-amount">
                                    <td colspan="3" style="height:25px;">Net Amount</td>
                                    <td style="text-align:right;height:25px;">{{ number_format($orders->all_total_amount) }} </td>
                                </tr>


                                @foreach($payments as $payment)
                                <tr class="tr-bottom-dashed i-title payment-amount">
                                    <td colspan="3">Paid {{ $payment['name'] }}</td>
                                    <td class="text-right">{{ number_format($payment['paid_amount']) }}</td>
                                </tr>
                                @endforeach

                                <tr style="border-bottom:1px dashed black;">
                                    <td colspan="3">Change</td>
                                    <td class="text-right">{{ number_format($orders->refund) }}</td>
                                </tr>

                                <tr style="text-align:center;">
                                    <td colspan="4" >Thank You</td>
                                </tr>

                                <tr style="text-align:center;">
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
