<!-- Modal For Print    r -->
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
                        <col width="90">
                        <col width="40">
                        <col width="30">
                        <col width="50">
                        <thead>
                            <tr>
                                <td colspan="4" style="text-align:center;font-size:13px;line-height:25px;padding:5px 7px;">
                                    {{ $config->restaurant_name}}<br/>
                                    {{ $config->website}}<br/>
                                    Email: {{ $config->email }}<br/>
                                    Tel: {{ $config->phone}}<br/>
                                    Addr: {{ $config->address}}<br /><br />
                                    <span style="float:left">Invoice No: {{ $order->order_id}}</span><br/>
                                    <span style="float:left">Invoice Date:{{$order->order_time}}</span><br/>
                                    @if(count($tables)>0)
                                        Table No :
                                        @foreach($tables as $table)
                                            {{ $table->table_no }}
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
                                <td align="right">Qty</th>
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
                                                <td class="no-border">{{ number_format($detail['amount']) }}</td>
                                                <td class="no-border" align="right">{{ $qty2 }}</td>
                                                <td class="no-border" align="right">{{ number_format($detail['amount']* $qty2) }} </td>
                                            @endif
                                        @else
    
                                            <td class="no-border">{{ $detail['item_name'] }}</td>
                                            <td class="no-border">{{ number_format($detail['amount']) }}</td>
                                            <td class="no-border" align="right">{{ $qty2 }}</td>
                                            <td class="no-border" align="right">{{ number_format($detail['amount']* $qty2) }} </td>
                                        @endif                                                                                            
                                </tr>
                            @endforeach

                            @foreach($addon as $add)
                                       
                            <tr>
                                <td class="no-border">{{ $add['food_name']}} (addon)</td>
                                <td class="no-border">{{ number_format($add['amount']) }}</td>
                                <td class="no-border" align="right">{{ $add['quantity'] }} </td>
                                <td class="no-border" align="right">{{ number_format($add['amount'] * $add['quantity']) }}</td>
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
                                <td align="right">{{ number_format($order->service_amount) }}</td>
                            </tr>

                            <tr>
                                <td colspan="3" style="height:25px;padding:5px 7px;">Tax</td>
                                <td align="right">{{ number_format($order->tax_amount) }}</td>
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

                <div class="spacer-10px"></div>
                <div align="center">
                    
                    <button class="btn btn-success btn-lg" id ="{{$order->order_id}}" onClick="print_click(this.id)">Print</button>
                </div>  
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<style>

    .right-align{
        text-align: right;display:inline-block;
    }
</style>