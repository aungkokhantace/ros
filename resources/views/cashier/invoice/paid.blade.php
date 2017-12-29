<div class="col-md-4 tbl-container">
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
                        <span style="float:left">Invoice No: {{ $order->order_id}}</span><br/>
                        <span style="float:left">Invoice Date:{{$order->order_time}}</span><br/>
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
                    <td class="mm-font">
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
                    <td class="text-right right">{{ number_format($detail->amount)  }}</td>
                    <td class="text-right right">{{number_format($detail->quantity * $detail->amount)}}</td>
                </tr>
                    
                    @foreach($addon as $add)
                        @if($detail->order_detail_id == $add['order_detail_id'])
                            <tr class="i-title">
                                <td>{{ $add['quantity']}}</td>
                                <td>{{ $add['food_name']}}</td>
                                <td>{{ $add['amount']}}</td>
                                <td class="text-right right">{{number_format($add['quantity'] * $add['amount'])}}</td>
                            </tr>
                        @endif

                    @endforeach 

                @endforeach
                <tr class="tr-bottom-dashed i-title">
                    <td colspan="4"></td>
                </tr>
                
                <tr class="i-title">
                    <td colspan="3">Total: (Exclusive Tax)</td>
                    <td class="text-right right">{{ number_format($order->total_price) }}</td>
                </tr>

                @if(isset($rooms))
                <tr class="tr-bottom-dashed i-title">
                    <td colspan="3">Room Charge</td>
                    <td class="text-right right">{{ number_format($order->room_charge) }} </td>
                </tr>
                @endif
                
                <tr class="i-title">
                    <td colspan="3">Service Tax ({{ $config->service}} %)</td>
                    <td class="text-right right">{{ $order->service_amount }}</td>
                </tr>

                <tr class="i-title">
                    <td colspan="3">GST ({{$config->tax}} %)</td>
                    <td class="text-right right">{{ $order->tax_amount }}</td>
                </tr>
                
                <tr class="tr-bottom-dashed i-title">
                    <td colspan="3">Discount</td>
                    <td class="text-right right">{{ $order->total_discount_amount }}</td>
                </tr>

                <tr class="tr-bottom-dashed i-title">
                    <td colspan="3">FOC</td>
                    <td class="text-right right">{{ $order->foc_amount }}</td>
                </tr>
                
                <tr class="tr-bottom-dashed i-title">
                    <td colspan="3">Net Amount</td>
                    <td class="text-right right">{{ number_format($order->all_total_amount) }} </td>
                </tr>

                @foreach($payments as $payment)
                <tr class="tr-bottom-dashed i-title">
                    <td colspan="3">Paid {{ $payment['name'] }}</td>
                    <td class="text-right right">{{ number_format($payment['paid_amount']) }}</td>
                </tr>
                @endforeach

                <tr class="tr-bottom-dashed i-title">
                    <td colspan="3">Total Payment</td>
                    <td class="text-right right">{{ number_format($order->payment_amount) }}</td>
                </tr>
                <tr class="tr-bottom-dashed i-title">
                    <td colspan="3">Change</td>
                    <td class="text-right right">{{ number_format($order->refund) }}</td>
                </tr>

                <tr>
                    <td colspan="4"  style="text-align:center;">Thank You</td>
                </tr>
            </tbody>
        </table>
        </div>
    </div>
</div>