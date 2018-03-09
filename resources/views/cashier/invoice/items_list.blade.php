<!-- Modal For Printer -->
<div class="modal image-slide-show-modal" tabindex="-1" role="dialog" aria-labelledby="" id="{{$order->order_id}}-item">
    <div class="modal-dialog" role="document" style="width:330px;">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Items</h4>
        </div>
        <div class="modal-body" id="order-id">
            <div id="{{$order->order_id}}-print-table" style="font-family:'Courier New',Times New Roman;font-weight: bold;">
                <table class="print-invoice" style="border-collapse: collapse;margin:0 auto;">
                    <thead>

                        <tr style="border-bottom:1px dashed black;font-size:13px;line-height:25px;">
                            <td width="10%" style="height:25px;">Qty</th>
                            <td width="50%" style="height:25px;">Product</th>
                            <td width="20%" style="text-align:right;height:25px;">Price</th>
                            <td width="20%" style="text-align:right;height:25px;">Amount</th>
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
                            <td style="height:25px;text-align:right;">{{number_format($detail->quantity * $detail->amount)}}</td>
                        </tr>
                        <!-- Add on -->
                             <?php
                            $default_extra = '0.0';
                            ?>
                            @foreach($amount as $am)
                                @if($detail->order_detail_id == $am['order_detail_id'])
                                <tr style="font-size:13px;line-height:15px;">
                                    <td style="height:15px;">{{ $am['quantity']}}</td>
                                    <td>{{ $am['food_name']}}</td>
                                    <td style="text-align:right;height:15px;">{{ $am['amount']}}</td>
                                    <td style="text-align:right;height:15px;">{{ $am['quantity'] * $am['amount'] }}</td>
                                </tr>
                                @endif
                            @endforeach 
                        @endforeach
                        <tr style="border-bottom:1px dashed black;">
                            <td colspan="4" style="height:25px;"></td>
                        </tr>

                        <tr>
                            <td colspan="3" style="height:25px;">Total: (Exclusive Tax)</td>
                            <td style="text-align:right;height:25px;">{{ number_format($order->total_price) }}</td>
                        </tr>

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
                        
                        @if(count($rooms) > 0)
                            <tr style="border-bottom:1px dashed black;">
                                <td colspan="3" style="height:25px;">Room Charge</td>
                                <td style="text-align:right;height:25px;">{{ number_format($order->room_charge) }} </td>
                            </tr>
                        @endif
                        <tr style="border-bottom:1px dashed black;">
                            <td colspan="3" style="height:25px;">Net Amount</td>
                            <td style="text-align:right;height:25px;">{{ number_format($order->all_total_amount) }} </td>
                        </tr>

                        <tr style="text-align:center;">
                            <td colspan="4" style="height:25px;">Thank You</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
        </div>
    </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->