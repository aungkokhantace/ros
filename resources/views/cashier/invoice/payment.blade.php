@extends('cashier.layouts.master')
@section('title','Invoice Paid')
@section('content')
    <div class="row" xmlns="http://www.w3.org/1999/html">
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
            {!! Form::open(array('url' => '/Cashier/invoice/add_paid', 'method' => 'post', 'files' => false)) !!}
            {{ Form::hidden('id', $orders->order_id) }}
            {{ Form::hidden('all_total', $orders->all_total_amount) }}
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
                                @if(isset($detail->order_extra))
                                    {{$detail->order_extra}}
                                @else
                                    {{ '0.0' }}
                                @endif
                            </td>
                            <td class="text-center">{{$detail->discount_amount}}</td>
                            <td class="text-center">{{ number_format($detail->amount_with_discount)}}</td>
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
                        <span class="col-left-vouncher"> :&nbsp;&nbsp;&nbsp;&nbsp;{{$orders->order_time}}</span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <span class="col-left-vouncher">Vouncher No</span>
                    </div>

                    <div class="col-md-6">
                        <span class="col-left-vouncher"> :&nbsp;&nbsp;&nbsp;&nbsp;{{$orders->order_id }}</span>
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
                            member card number : {{($orders->member_id)}}
                        </div>
                    </div>
                </div><div class="spacer-10px"></div>

                <div class="row">
                    <div class="col-md-10 paid_mem_info">
                        <div class="paid-post-box">
                            <input id="FOC" name="foc" type="text" class="form-control form-invoice" value="@if($orders->total_price_foc > 0){{ 'Free of Charge - ' .  $orders->total_price_foc }} @endif" @if($orders->total_price_foc > 0){{ 'disabled' }} @endif placeholder="Free Of Charge"/>
                        </div>
                    </div>
                </div><div class="spacer-10px"></div>

                <div class="row">
                    <div class="col-md-10 paid_mem_info">
                        <div class="paid-post-box">
                            Remark
                        </div>
                    </div>
                </div><div class="spacer-10px"></div>

                <div class="row">
                    <div class="col-md-10 paid_mem_info">
                        <div class="paid-post-box">
                            <input id="Payment" type="text" class="form-control form-invoice" value="@if($orders->payment_amount > 0){{ 'Payment - ' .  $orders->payment_amount }} @endif" name="payment" placeholder="Pay Amount" @if($orders->payment_amount > 0){{ 'disabled' }} @endif/>

                        </div>
                        <p class="text-danger">{{$errors->first('payment')}}</p>
                    </div>
                </div><div class="spacer-10px"></div>


                <div class="row">
                    <div class="col-md-6">
                        <span class="paid_mem_info">Refund:</span>
                    </div>

                    <div class="col-md-4 text-right">
                        <span class="paid_mem_info" id="refund">{{ $orders->refund }}</span>
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
                        <span class="paid_mem_info">Total Extra Amount:</span>
                    </div>

                    <div class="col-md-4 text-right">
                        <span class="paid_mem_info">{{ $orders->total_extra_price }}</span>
                    </div>
                </div><div class="spacer-10px"></div>

                <div class="row">
                    <div class="col-md-6">
                        <span class="paid_mem_info">Total Discount Amount:</span>
                    </div>

                    <div class="col-md-4 text-right">
                        <span class="paid_mem_info">{{ $orders->total_discount_amount }}</span>
                    </div>
                </div><div class="spacer-10px"></div>

                <div class="row">
                    <div class="col-md-6">
                        <span class="paid_mem_info">Member Discount Amount:</span>
                    </div>

                    <div class="col-md-4 text-right">
                        <span class="paid_mem_info">{{ $orders->member_discount_amount }}</span>
                    </div>
                </div><div class="spacer-10px"></div>

                <div class="row">
                    <div class="col-md-6">
                        <span class="paid_mem_info">Tax:</span>
                    </div>

                    <div class="col-md-4 text-right">
                        <span class="paid_mem_info">{{ number_format($orders->tax_amount)}}</span>
                    </div>
                </div><div class="spacer-10px"></div>

                <div class="row">
                    <div class="col-md-6">
                        <span class="paid_mem_info">Service:</span>
                    </div>

                    <div class="col-md-4 text-right">
                        <span class="paid_mem_info">{{ number_format($orders->tax_amount)}}</span>
                    </div>
                </div><div class="spacer-10px"></div>

                <div class="row">
                    <div class="col-md-6">
                        <span class="paid_mem_info">Net Amount:</span>
                    </div>

                    <div class="col-md-4 text-right">
                        <span class="paid_mem_info">{{ number_format($orders->all_total_amount)}}</span>
                    </div>
                </div><div class="spacer-10px"></div>

                @if ($orders->payment_amount <= 0)
                <div class="row">
                    <div class="col-md-10">
                        <button type="submit" class="btn btn-default btn-md paid_btn pull-right" id="btn-payment" onclick="confirmPayment();">
                            <span><i class="fa fa-usd" aria-hidden="true"></i>&nbsp;&nbsp;Paid</span>
                        </button>
                    </div>
                </div><div class="spacer-10px"></div>
                @endif
            </div>
        </div>
        {!! Form::close() !!}

    </div>

    <?php
    $net_ammount = $orders->all_total_amount;
    ?>
    <script>
        var net = "<?php echo $net_ammount; ?>";
        var PaymentInput = document.getElementById('Payment');
        var FocInput = document.getElementById('FOC');
        var typingTimer;                //timer identifier
        var doneTypingInterval = 1000;  //time in ms, 1 second for example
        var $input = $('#Payment');
        var focinput = $('#FOC');

        //on keyup, start the countdown
        $input.on('keyup', function () {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(doneTyping, doneTypingInterval);
        });

        //on keydown, clear the countdown
        $input.on('keydown', function () {
            clearTimeout(typingTimer);
        });

        //on keyup, start the countdown
        focinput.on('keyup', function () {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(doneTyping, doneTypingInterval);
        });

        //on keydown, clear the countdown
        focinput.on('keydown', function () {
            clearTimeout(typingTimer);
        });

        //user is "finished typing," do something
        function doneTyping () {
            var PaymentValue = PaymentInput.value*1;
            var FocValue = FocInput.value*1;
            var PaymentFoc = PaymentValue + FocValue;
            var Refund = PaymentFoc - net;
            document.getElementById('refund').innerHTML = Refund;
        }
    </script>
@endsection
