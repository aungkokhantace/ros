<!-- Modal For Printer -->
<div class="modal image-slide-show-modal" tabindex="-1" role="dialog" aria-labelledby="" id="{{$order->id}}-print">
    <div class="modal-dialog" role="document" style="width:360px;">
        <div class="modal-content" style="background:none;box-shadow:none;">
            <div class="modal-header" style="width: 340px;">
                <div class="bootstrap-dialog-header">
                    <div class="bootstrap-dialog-title" id="294d853f-691f-4de9-967c-d66fd0adfb69_title">Print Invoice</div>
                </div>
            </div>
            <div class="modal-body" id="order-id" style="width: 340px;">
                <div id="{{$order->id}}-print-table" style="font-family:'Courier New',Times New Roman;font-weight: bold;">
                    <table class="print-invoice" style="border-collapse: collapse;width:83mm;margin:0 auto;table-layout: fixed;word-wrap: break-word;">
                        <thead>
                            <tr>
                                <td colspan="4" style="text-align:center;font-size:13px;line-height:25px;padding:5px 7px;">
                                    {{ $config->restaurant_name}}<br/>
                                    Website: {{ $config->website}}<br/>
                                    Email: {{ $config->email }}<br/>
                                    Tel: {{ $config->phone}}<br/>
                                    Addr: {{ $config->address}}<br /><br/>
                                    <span style="float:left">Invoice No: {{ $order->id}}</span><br/>
                                    <span style="float:left">Invoice Date:{{$order->created_at}}</span><br/>
                                    @if(isset($order->table))
                                        Table No : {{ $order->table }}
                                    @endif

                                    @if(isset($order->room))
                                        Room No : {{ $order->room }}
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
                            @foreach($order->order_detail as $detail)
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
                                @foreach($order->addon as $addon)
                                    @foreach($addon as $add)
                                        @if($detail->order_detail_id == $add['order_detail_id'])
                                        <tr style="font-size:13px;line-height:15px;">
                                            <td style="height:15px;padding:5px 7px;">{{ $add['quantity']}}</td>
                                            <td style="padding:5px 7px;">{{ $add['food_name']}}</td>
                                            <td style="text-align:right;height:15px;padding:5px 7px;">{{ $add['amount']}}</td>
                                            <td style="text-align:right;height:15px;padding:5px 7px;">{{number_format($add['quantity'] * $add['amount'])}}</td>
                                        </tr>
                                        @endif
                                    @endforeach
                                @endforeach 

                            @endforeach
                            <tr style="border-bottom:1px dashed black;">
                                <td colspan="4" style="height:25px;"></td>
                            </tr>
                            
                            <tr>
                                <td colspan="3" style="height:25px;">Total: (Exclusive Tax)</td>
                                <td style="text-align:right;height:25px;">{{ number_format($order->total_price) }}</td>
                            </tr>

                            @if(isset($order->room))
                                <tr class="i-title">
                                    <td colspan="3">Room Charge</td>
                                    <td class="text-right">{{ $order->room_charge }}</td>
                                </tr>
                            @endif

                            <tr>
                                <td colspan="3" style="height:25px;">Service Tax ({{ $config->service}} %)</td>
                                <td style="text-align:right;height:25px;">{{ $order->service_amount }}</td>
                            </tr>

                            <tr>
                                <td colspan="3" style="height:25px;">GST ({{$config->tax}} %)</td>
                                <td style="text-align:right;height:25px;">{{ $order->tax_amount }}</td>
                            </tr>
                            
                            <tr style="border-bottom:1px dashed black;">
                                <td colspan="3" style="height:25px;">Discount</td>
                                <td style="text-align:right;height:25px;">{{ $order->total_discount_amount }}</td>
                            </tr>
                            
                            <tr style="border-bottom:1px dashed black;">
                                <td colspan="3" style="height:25px;">FOC</td>
                                <td style="text-align:right;height:25px;">{{ $order->foc_amount }}</td>
                            </tr>

                            <tr style="border-bottom:1px dashed black;">
                                <td colspan="3" style="height:25px;">Net Amount</td>
                                <td style="text-align:right;height:25px;">{{ number_format($order->all_total_amount) }} </td>
                            </tr>
                            @foreach($order->paid as $pay)
                            <tr class="tr-bottom-dashed i-title">
                                <td colspan="3">Paid {{ $pay['name'] }}</td>
                                <td class="text-right">{{ number_format($pay['paid_amount']) }}</td>
                            </tr>
                            @endforeach
                            <tr style="border-bottom:1px dashed black;">
                                <td colspan="3" style="height:25px;">Toatal Payment</td>
                                <td style="text-align:right;height:25px;">{{ number_format($order->payment_amount) }}</td>
                            </tr>

                            <tr style="border-bottom:1px dashed black;">
                                <td colspan="3" style="height:25px;">Change</td>
                                <td style="text-align:right;height:25px;">{{ number_format($order->refund) }}</td>
                            </tr>

                            <tr style="text-align:center;">
                                <td colspan="4" style="height:25px;">Thank You</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="spacer-10px"></div>
                <button class="btn btn-success btn-lg" id ="{{ $order->id}}" onClick="print_click(this.id)">Print</button>
                <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-primary btn-lg">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->