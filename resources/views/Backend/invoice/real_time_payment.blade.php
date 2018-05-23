<div class="row" id="autoDiv">
    {!! Form::open(array('url' => '/Cashier/invoice/add_paid', 'method' => 'post','id' => 'myForm' , 'files' => false)) !!}
    {{ Form::hidden('id', $order->order_id) }}
    {{ Form::hidden('all_total', $order->all_total_amount) }}
    <div class="col-md-8">
        <table class="table paid_table">
            <thead>
            <tr class="paid_header">
                <th class="text-center">Item Name</th>
                <th class="text-center">Price</th>
                <th class="text-center">Quantity</th>
                <th class="text-center">ExtraPrice</th>
                <th class="text-center">Discount</th>
                <th class="text-center">Amount</th>
            </tr>
            </thead>

            <tbody>
            <?php $t=0; $tt=0; $sub_total=0;$add_qty=0; ?>
            @foreach($order_detail as $detail)
                <tr>
                    <td class="text-center">
                        @if(isset($detail->item_name))
                            {{$detail->item_name}}
                        @else
                            {{ $detail->set_name }}
                        @endif
                    </td>
                    <td class="text-center"> {{ number_format($detail->amount)  }}</td>
                    <td class="text-center"> {{$detail->quantity}} </td>
                    <td class="text-center">

                        <?php
                        $default_extra = '0.0';
                        ?>
                        @foreach($amount as $am)
                            @if($detail->order_detail_id == $am['order_detail_id'])
                                {{ ($am['amount']) *($detail->quantity) }}
                                    <?php $default_extra = ''; ?>
                            @endif
                        @endforeach

                        {{ $default_extra }}
                    </td>
                    <td class="text-center">{{$detail->discount_amount}}</td>
                    <td class="text-center">{{ $detail->amount_with_discount }}</td>
                </tr>

                <?php $sub_total += $detail->amount_with_discount ?>
            @endforeach

            </tbody>
        </table>

    </div>
    <div class="col-md-4">

        <div class="row">
            <div class="col-md-4">
                <span class="col-left-vouncher">Date</span>
            </div>

            <div class="col-md-6">
                <span class="col-left-vouncher"> :&nbsp;&nbsp;&nbsp;&nbsp;{{$order->order_time}}</span>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <span class="col-left-vouncher">Vouncher No</span>
            </div>

            <div class="col-md-6">
                <span class="col-left-vouncher"> :&nbsp;&nbsp;&nbsp;&nbsp;{{$order->order_id }}</span>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                @if($tables->count())
                    <span class="col-left-vouncher"> Table No : </span>
                @endif
                @if($rooms->count())
                    <span class="col-left-vouncher"> Room No : </span>
                @endif
            </div>

            <div class="col-md-6">
                @if(isset($tables))
                    @foreach($tables as $table)
                        <span class="col-left-vouncher"> :&nbsp;&nbsp;&nbsp;&nbsp;{{ $table->table_no }}</span>
                    @endforeach
                @endif

                @if(isset($rooms))
                    @foreach($rooms as $room)
                        <span class="col-left-vouncher"> :&nbsp;&nbsp;&nbsp;&nbsp;{{ $room->room_name }}</span>
                    @endforeach
                @endif
            </div>
        </div><div class="spacer-10px"></div>

        <div class="row">
            <div class="col-md-10 paid_mem_info">
                <div class="paid-post-box">
                    <input id="FOC" name="foc" type="text" class="form-control form-invoice" placeholder="Free Of Charge" value="@if($order->foc_amount > 0){{ 'Free of Charge - ' .  $order->foc_amount }} @elseif(Request::old('foc')){{ Request::old('foc') }} @endif" @if($order->foc_amount > 0){{ 'disabled' }} @endif />
                </div>
            </div>
        </div><div class="spacer-10px"></div>

        <div class="row">
            <div class="col-md-10 paid_mem_info">
                <div class="paid-post-box">
                    <input id="Remark" name="Remark" type="text" class="form-control form-invoice" value="" placeholder="Remark"/>

                </div>
            </div>
        </div><div class="spacer-10px"></div>

        @include('cashier.invoice.card')


        <div class="row">
            <div class="col-md-6">
                <span class="paid_mem_info">Refund:</span>
            </div>

            <div class="col-md-4 text-right">
                <span class="paid_mem_info" id="refund">{{ $order->refund }}</span>
            </div>
        </div><div class="spacer-10px"></div>

        <div class="row">
            <div class="col-md-6">
                <span class="paid_mem_info">Total amout:</span>
            </div>

            <div class="col-md-4 text-right">
                <span class="paid_mem_info">{{ number_format($sub_total) }}</span>
            </div>
        </div><div class="spacer-10px"></div>

        <div class="row">
            <div class="col-md-6">
                <span class="paid_mem_info">Total Discount Amount:</span>
            </div>

            <div class="col-md-4 text-right">
                <span class="paid_mem_info">{{ $order->total_discount_amount }}</span>
            </div>
        </div><div class="spacer-10px"></div>

        <div class="row">
            <div class="col-md-6">
                <span class="paid_mem_info">Member Discount Amount:</span>
            </div>

            <div class="col-md-4 text-right">
                <span class="paid_mem_info">{{ $order->member_discount_amount }}</span>
            </div>
        </div><div class="spacer-10px"></div>

        <div class="row">
            <div class="col-md-6">
                <span class="paid_mem_info">Tax:</span>
            </div>

            <div class="col-md-4 text-right">
                <span class="paid_mem_info" id="Tax">{{ number_format($order->tax_amount)}}</span>
            </div>
        </div><div class="spacer-10px"></div>

        <div class="row">
            <div class="col-md-6">
                <span class="paid_mem_info">Service:</span>
            </div>

            <div class="col-md-4 text-right">
                <span class="paid_mem_info" id="Service">{{ number_format($order->service_amount)}}</span>
            </div>
        </div><div class="spacer-10px"></div>

        @if(isset($rooms))
        <div class="row">
            <div class="col-md-6">
                <span class="paid_mem_info">Room Charge:</span>
            </div>

            <div class="col-md-4 text-right">
                <span class="paid_mem_info">{{ number_format($order->room_charge)}}</span>
            </div>
        </div><div class="spacer-10px"></div>
        @endif

        <div class="row">
            <div class="col-md-6">
                <span class="paid_mem_info">Net Amount:</span>
            </div>

            <div class="col-md-4 text-right">
                <span class="paid_mem_info" id="Net">{{ number_format($order->all_total_amount)}}</span>
            </div>
        </div><div class="spacer-10px"></div>

        @if ($order->payment_amount <= 0)
        <div class="row">
            <div class="col-md-10">
                <button type="submit" class="btn btn-default btn-md paid_btn pull-right" id="btn-payment" disabled>
                    <span><i class="fa fa-usd" aria-hidden="true"></i>&nbsp;&nbsp;Paid</span>
                </button>
            </div>
        </div><div class="spacer-10px"></div>
        @endif
    </div>
    {!! Form::close() !!}
</div>