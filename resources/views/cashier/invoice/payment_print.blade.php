<!-- Modal For Printer -->
<div class="modal image-slide-show-modal" tabindex="-1" role="dialog" aria-labelledby="" id="{{$order->order_id}}-print">
    <div class="modal-dialog" role="document" style="width:360px;">
        <div class="modal-content" style="background:none;box-shadow:none;">
            <div class="modal-header" style="width: 340px;">
                <div class="bootstrap-dialog-header">
                    <div class="bootstrap-dialog-title" id="294d853f-691f-4de9-967c-d66fd0adfb69_title">Print Invoice</div>
                </div>
            </div>
            <div class="modal-body" id="order-id" style="width: 340px;">
                <div id="{{$order->order_id}}-print-table" style="font-family:'Courier New',Times New Roman;font-weight: bold;">
                    <table class="print-invoice" style="border-collapse: collapse;width:83mm;margin:0 auto;table-layout: fixed;word-wrap: break-word;background:none;">
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
                                <td width="10%" style="height:25px;padding:5px 7px;">Qty</th>
                                <td width="50%" style="height:25px;padding:5px 7px;">Product</th>
                                <td width="20%" style="text-align:right;height:25px;padding:5px 7px;">Price</th>
                                <td width="20%" style="text-align:right;height:25px;padding:5px 7px;">Amount</th>
                            </tr>
                        </thead>
                        
                        <tbody style="font-size:13px;line-height:25px;">
                            @foreach($order_detail as $detail)
                            <tr style="vertical-align: text-top;">
                                <td style="height:25px;padding:5px 7px;"> {{$detail->quantity }}</td>
                                <td style="height:25px;font-family:zawgyi-one;padding:5px 7px;">
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
                                <td style="text-align:right;height:25px;padding:5px 7px;">{{ number_format($detail->amount)  }}</td>
                                <td style="height:25px;text-align:right;padding:5px 7px;">{{number_format($detail->quantity * $detail->amount)}}</td>
                            </tr>
                            <!-- Add on -->
                                 <?php
                                $default_extra = '0.0';
                                ?>
                                @foreach($amount as $am)
                                    @if($detail->order_detail_id == $am['order_detail_id'])
                                    <tr style="font-size:13px;line-height:15px;">
                                        <td style="height:15px;padding:5px 7px;">{{ $am['quantity']}}</td>
                                        <td style="padding:5px 7px;">{{ $am['food_name']}}</td>
                                        <td style="text-align:right;height:15px;padding:5px 7px;">{{ $am['amount']}}</td>
                                        <td style="text-align:right;height:15px;padding:5px 7px;">{{ $am['quantity'] * $am['amount'] }}</td>
                                    </tr>
                                    @endif
                                @endforeach 
                            @endforeach
                            <tr style="border-bottom:1px dashed black;">
                                <td colspan="4" style="height:25px;"></td>
                            </tr>

                            <tr>
                                <td colspan="3" style="height:25px;padding:5px 7px;">Total: (Exclusive Tax)</td>
                                <td style="text-align:right;height:25px;padding:5px 7px;">{{ number_format($order->total_price) }}</td>
                            </tr>

                            <tr>
                                <td colspan="3" style="height:25px;padding:5px 7px;">Service Tax ({{ $config->service}} %)</td>
                                <td style="text-align:right;height:25px;padding:5px 7px;">{{ $order->service_amount }}</td>
                            </tr>

                            <tr>
                                <td colspan="3" style="height:25px;padding:5px 7px;">GST ({{$config->tax}} %)</td>
                                <td style="text-align:right;height:25px;padding:5px 7px;">{{ $order->tax_amount }}</td>
                            </tr>

                            <tr style="border-bottom:1px dashed black;">
                                <td colspan="3" style="height:25px;padding:5px 7px;">Discount</td>
                                <td style="text-align:right;height:25px;padding:5px 7px;">{{ $order->total_discount_amount }}</td>
                            </tr>

                            <tr style="border-bottom:1px dashed black;">
                                <td colspan="3" style="height:25px;padding:5px 7px;">FOC</td>
                                <td style="text-align:right;height:25px;padding:5px 7px;" class="foc-amount">{{ $order->foc_amount }}</td>
                            </tr>
                            
                            @if(count($rooms) > 0)
                                <tr style="border-bottom:1px dashed black;">
                                    <td colspan="3" style="height:25px;padding:5px 7px;">Room Charge</td>
                                    <td style="text-align:right;height:25px;padding:5px 7px;">{{ number_format($order->room_charge) }} </td>
                                </tr>
                            @endif
                            <tr style="border-bottom:1px dashed black;" class="net-amount">
                                <td colspan="3" style="height:25px;padding:5px 7px;">Net Amount</td>
                                <td style="text-align:right;height:25px;padding:5px 7px;">{{ number_format($order->all_total_amount) }} </td>
                            </tr>


                            @foreach($payments as $payment)
                            <tr class="tr-bottom-dashed i-title payment-amount">
                                <td colspan="3" style="padding:5px 7px;">Paid {{ $payment['name'] }}</td>
                                <td class="text-right" style="padding:5px 7px;">{{ number_format($payment['paid_amount']) }}</td>
                            </tr>
                            @endforeach

                            <tr style="border-bottom:1px dashed black;">
                                <td colspan="3" style="height:25px;padding:5px 7px;">Change</td>
                                <td style="text-align:right;height:25px;padding:5px 7px;" class="total-change">{{ number_format($order->refund) }}</td>
                            </tr>

                            <tr style="text-align:center;">
                                <td colspan="4" style="height:25px;padding:5px 7px;">Thank You</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="spacer-10px"></div>
                <div align="center">
                    <button class="btn btn-success btn-lg" id ="{{$order->order_id}}" onClick="print_click(this.id)">Print</button>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-primary btn-lg" onclick="return_btn()">Close</button>
                </div>  
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->