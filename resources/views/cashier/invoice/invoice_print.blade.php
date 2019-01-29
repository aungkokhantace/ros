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
                        <col width="80">
                        <col width="40">
                        <col width="40">
                        <col width="50">
                        
                        <thead>
                            <tr>
                                <td colspan="4" style="text-align:center;font-size:13px;line-height:25px;padding:5px 7px;">
                                    {{ $config->restaurant_name}}<br/>
                                    Website: {{ $config->website}}<br/>
                                    Email: {{ $config->email }}<br/>
                                    Tel: {{ $config->phone}}<br/>
                                    Addr: {{ $config->address}}<br /><br />
                                    <span style="float:left">Cashier: {{ $order->cashier }}</span><br>
                                    <span style="float:left">Waiter: {{ $order->User->user_name }}</span><br>
                                    <span style="float:left">Invoice No: {{ $order->id}}</span><br/>
                                    <span style="float:left">Invoice Date:{{ Carbon\Carbon::parse($order->order_time)->format('d-m-Y') }}</span><br/>
                                    @if(count($tables)>0)
                                        Table No :
                                        @foreach($tables as $table)
                                            {{ $table->table_no . "," }}
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
                                <td>Qty</th>
                                <td>Amount</th>
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
                                    $item = App\RMS\Item\Item::where('id',$detail['item_id'])->first();

                                    @endphp
                                    @if($qty > 1)
                                        @if($v != $detail['item_id'])
                                        @php $v = $detail['item_id'] @endphp
                                            <td class="no-border" style="">
                                                {{ $detail['item_name'] }}
                                                @if($item->Continent)
                                                ({{ $item->Continent->name }})
                                                @endif
                                            </td>
                                            <td class="no-border">{{ number_format($detail['amount']) }}</td>
                                            <td class="no-border">{{ $qty }}</td>
                                            <td class="no-border">{{ number_format($detail['amount']* $qty) }} </td>
                                        @endif
                                    @else

                                        <td class="no-border" style="">
                                            {{ $detail['item_name'] }}
                                            @if($item->Continent)
                                            ({{ $item->Continent->name }})
                                            @endif
                                        </td>
                                        <td class="no-border">{{ number_format($detail['amount']) }}</td>
                                        <td class="no-border">{{ $qty }}</td>
                                        <td class="no-border">{{ number_format($detail['amount']*$qty) }} </td>
                                    @endif                                                                                            
                            </tr>
                            @endforeach

                            <tr style="border-bottom:1px dashed black;">
                                <td colspan="4" style="height:5px;"></td>
                            </tr>

                            <tr>
                                <td colspan="3" style="height:25px;padding:5px 7px;">Net Amount</td>
                                <td>{{ number_format($order->total_price) }}</td>
                            </tr>

                            <tr>
                                <td colspan="3" style="height:25px;padding:5px 7px;">Discount</td>
                                <td>{{ number_format($order->over_all_discount) }}</td>
                            </tr>

                            <tr style="border-bottom:1px dashed black;">
                                <td colspan="4" style="height:5px;"></td>
                            </tr>

                            <tr>
                                <td colspan="3" style="height:25px;padding:5px 7px;">Sub Total</td>
                                <td>{{ number_format($order->sub_total) }}</td>
                            </tr>

                            <tr>
                                <td colspan="3" style="height:25px;padding:5px 7px;">Service Charge</td>
                                <td>{{ number_format($order->service_amount) }}</td>
                            </tr>

                            <tr>
                                <td colspan="3" style="height:25px;padding:5px 7px;">Tax</td>
                                <td>{{ number_format($order->tax_amount) }}</td>
                            </tr>
                            
                            <tr style="border-bottom:1px dashed black;">
                                <td colspan="4" style="height:5px;"></td>
                            </tr>

                            @if(count($rooms) > 0)
                                <tr style="border-bottom:1px dashed black;">
                                    <td colspan="4" style="">Room Charge</td>
                                    <td>{{ number_format($order->room_charge) }} </td>
                                </tr>
                            @endif
                            <tr style="border-bottom:1px dashed black;" class="net-amount">
                                <td colspan="3" style="height:25px;padding:5px 7px;">Total Amount</td>
                                <td>{{ number_format($order->all_total_amount) }} </td>
                            </tr>


                            @foreach($payments as $payment)
                            <tr class="tr-bottom-dashed i-title payment-amount">
                                <td colspan="3" style="padding:5px 7px;">Paid {{ $payment['name'] }}</td>
                                <td class="text-right" style="padding:5px 7px;">{{ number_format($payment['paid_amount']) }}</td>
                            </tr>
                            @endforeach

                            <tr style="">
                                <td colspan="3" style="height:25px;padding:5px 7px;">Change</td>
                                <td>{{ number_format($order->refund) }}</td>
                            </tr>

                            <tr style="text-align:center;">
                                <td colspan="4" style="height:25px;padding:5px 7px;">Thank You</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="spacer-10px"></div>
                <div align="center">
                    <button class="btn btn-success btn-lg" id ="{{$order->order_id}}" onClick="printInvoice(this.id)">Print</button>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-primary btn-lg" onclick="return_btn()">Close</button>
                </div>  
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->