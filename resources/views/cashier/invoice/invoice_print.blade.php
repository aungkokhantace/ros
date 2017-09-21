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
            <div id="{{$order->id}}-print-table">
                <table class="print-invoice">
                    <thead>
                        <tr>
                            <td colspan="3" class="text-left">
                                {{ $config->restaurant_name}}<br/>
                                Website: {{ $config->website}}<br/>
                                Email: {{ $config->email }}<br/>
                                Tel: {{ $config->phone}}<br/>
                                Addr: {{ $config->address}}<br />
                                Invoice No: {{ $order->id}}<br/>
                                Invoice Date:{{$order->created_at}}<br/>
                                @if(isset($order->table))
                                    Table No : {{ $order->table }}
                                @endif

                                @if(isset($order->room))
                                    Room No : {{ $order->room }}
                                @endif
                            </td>
                        </tr>
                        
                        <tr colspan="3" class="border-dashed"></tr>
                        <tr class="text-left" >
                            <td width="20%">Qty</th>
                            <td width="60%">Product</th>
                            <td width="10%">Price</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        @foreach($order->order_detail as $detail)
                        <tr class="text-left">
                            <td> {{$detail->quantity }}</td>
                            <td >
                                @if(isset($detail->item_name))
                                    {{$detail->item_name}}
                                @else
                                    {{ $detail->set_name }}
                                @endif
                            </td>
                            <td>{{number_format($detail->quantity * $detail->amount)}}</td>
                        </tr>
                        <!-- Add on -->
                            @foreach($order->addon as $addon)
                                @foreach($addon as $add)
                                    @if($detail->order_detail_id == $add['order_detail_id'])
                                    <tr class="text-left">
                                        <td></td>
                                        <td>{{ $add['food_name']}}</td>
                                        <td>{{ $add['amount']}}</td>
                                    </tr>
                                    @endif
                                @endforeach
                            @endforeach 

                        @endforeach

                        <tr colspan="3" class="border-dashed"></tr>
                        <tr class="text-left">
                            <td colspan="2">Total: (Exclusive Tax)</td>
                            <td>{{ number_format($order->total_price) }}</td>
                        </tr>

                        <tr class="text-left">
                            <td colspan="2">Service Amount</td>
                            <td>{{ $order->service_amount }}</td>
                        </tr>
                        <tr class="text-left">
                            <td colspan="2">Tax Amount</td>
                            <td>{{ $order->tax_amount }}</td>
                        </tr>

                        <tr colspan="3" class="border-dashed"></tr>
                        <tr class="text-left">
                            <td colspan="2">Net Amount</td>
                            <td>{{ number_format($order->all_total_amount) }} </td>
                        </tr>
                        
                        <tr colspan="3" class="border-dashed"></tr>
                        <tr class="text-left">
                            <td colspan="2">Paid Cash</td>
                            <td>{{ number_format($order->payment_amount) }}</td>
                        </tr>
                        <th colspan="3" style="border-bottom:1px dashed black;">

                        <tr class="text-left">
                            <td colspan="2">Change</td>
                            <td>{{ number_format($order->refund) }}</td>
                        </tr>
                        <tr colspan="3" class="border-dashed"></tr>

                        <tr class="text-center">
                            <td colspan="3">Thank You</td>
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