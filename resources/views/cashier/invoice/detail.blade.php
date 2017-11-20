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
                                <td colspan="4" class="td-config">
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

                            <tr class="tr-bottom-dashed i-title">
                                <td width="10%">Qty</th>
                                <td width="50%">Product</th>
                                <td width="20%" class="text-right">Price</th>
                                <td width="20%" class="text-right">Amount</th>
                            </tr>
                        </thead>
                        
                        <tbody class="i-title">
                            @foreach($order_detail as $detail)
                            <tr>
                                <td> {{$detail->quantity }}</td>
                                <td>
                                    @if(isset($detail->item_name))
                                        {{$detail->item_name}}
                                    @else
                                        {{ $detail->set_name }}
                                    @endif
                                </td>
                                <td class="text-right">{{ number_format($detail->amount)  }}</td>
                                <td class="text-right">{{number_format($detail->quantity * $detail->amount)}}</td>
                            </tr>

                                @foreach($addon as $add)
                                    @if($detail->order_detail_id == $add['order_detail_id'])
                                        {{ $add['food_name']}}
                                        <tr class="i-title">
                                            <td></td>
                                            <td>{{ $add['food_name']}}</td>
                                            <td></td>
                                            <td class="text-right">{{ $add['amount']}}</td>
                                        </tr>
                                    @endif

                                @endforeach 

                            @endforeach
                            <tr class="tr-bottom-dashed i-title">
                                <td colspan="4"></td>
                            </tr>
                            
                            <tr class="i-title">
                                <td colspan="3">Total: (Exclusive Tax)</td>
                                <td class="text-right">{{ number_format($orders->total_price) }}</td>
                            </tr>

                            <tr class="i-title">
                                <td colspan="3">Service Amount</td>
                                <td class="text-right">{{ $orders->service_amount }}</td>
                            </tr>

                            <tr class="i-title">
                                <td colspan="3">Tax Amount</td>
                                <td class="text-right">{{ $orders->tax_amount }}</td>
                            </tr>
                            
                            <tr class="tr-bottom-dashed i-title">
                                <td colspan="3">Discount</td>
                                <td class="text-right">{{ $orders->total_discount_amount }}</td>
                            </tr>
                            
                            <tr class="tr-bottom-dashed i-title">
                                <td colspan="3">Net Amount</td>
                                <td class="text-right">{{ number_format($orders->all_total_amount) }} </td>
                            </tr>


                            <tr class="tr-bottom-dashed i-title">
                                <td colspan="3">Paid Cash</td>
                                <td class="text-right">{{ number_format($orders->payment_amount) }}</td>
                            </tr>

                            <tr class="tr-bottom-dashed i-title">
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
