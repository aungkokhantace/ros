
<!-- Modal For Printer -->
<div class="modal image-slide-show-modal" tabindex="-1" role="dialog" aria-labelledby="" id="{{$order->id}}-print">
    <div class="modal-dialog" role="document" style="width:330px;">
    <div class="modal-content">
        <div class="modal-header">
        <div class="bootstrap-dialog-header">
            <div class="bootstrap-dialog-close-button" style="display: block;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="bootstrap-dialog-title" id="294d853f-691f-4de9-967c-d66fd0adfb69_title">Print Invoice</div>
        </div>
        </div>
        <div class="modal-body" id="order-id">
            <div id="{{$order->id}}-print-table" style="font-family:'Courier New',Times New Roman;font-weight: bold;">
                <table class="print-invoice" style="border-collapse: collapse;width:75mm;margin:0 auto;">
                    <thead>
                        <tr>
                            <td colspan="4" style="text-align:center;font-size:13px;line-height:25px;">
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
                            <td width="10%" style="height:25px;">Qty</th>
                            <td width="50%" style="height:25px;">Product</th>
                            <td width="20%" style="text-align:right;height:25px;">Price</th>
                            <td width="20%" style="text-align:right;height:25px;">Amount</th>
                        </tr>
                    </thead>
                    
                    <tbody style="font-size:13px;line-height:25px;">
                        @foreach($order->order_detail as $detail)
                        <tr>
                            <td style="height:25px;"> {{$detail->quantity }}</td>
                            <td style="height:25px;">
                                @if(isset($detail->item_name))
                                    {{$detail->item_name}}
                                @else
                                    {{ $detail->set_name }}
                                @endif
                            </td>
                            <td style="text-align:right;height:25px;">{{ number_format($detail->amount)  }}</td>
                            <td style="text-align:right;height:25px;">{{number_format($detail->quantity * $detail->amount)}}</td>
                        </tr>
                        <!-- Add on -->
                            @foreach($order->addon as $addon)
                                @foreach($addon as $add)
                                    @if($detail->order_detail_id == $add['order_detail_id'])
                                    <tr style="font-size:13px;line-height:15px;">
                                        <td style="height:15px;"></td>
                                        <td style="height:15px;">{{ $add['food_name']}}</td>
                                        <td style="height:15px;"></td>
                                        <td style="text-align:right;height:15px;">{{ $add['amount']}}</td>
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

                        <tr>
                            <td colspan="3" style="height:25px;">Service Amount</td>
                            <td style="text-align:right;height:25px;">{{ $order->service_amount }}</td>
                        </tr>

                        <tr>
                            <td colspan="3" style="height:25px;">Tax Amount</td>
                            <td style="text-align:right;height:25px;">{{ $order->tax_amount }}</td>
                        </tr>
                        
                        <tr style="border-bottom:1px dashed black;">
                            <td colspan="3" style="height:25px;">Discount</td>
                            <td style="text-align:right;height:25px;">{{ $order->total_discount_amount }}</td>
                        </tr>
                        
                        <tr style="border-bottom:1px dashed black;">
                            <td colspan="3" style="height:25px;">Net Amount</td>
                            <td style="text-align:right;height:25px;">{{ number_format($order->all_total_amount) }} </td>
                        </tr>


                        <tr style="border-bottom:1px dashed black;">
                            <td colspan="3" style="height:25px;">Paid Cash</td>
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