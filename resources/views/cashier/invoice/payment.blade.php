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
                            member card number : {{($order->member_id)}}
                        </div>
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
                
                <!-- <div class="row">
                    <div class="col-md-6">
                        <span class="paid_mem_info">Total Extra Amount:</span>
                    </div>

                    <div class="col-md-4 text-right">
                        <span class="paid_mem_info">{{ $order->total_extra_price }}</span>
                    </div>
                </div><div class="spacer-10px"></div> -->

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
        </div>
        {!! Form::close() !!}

        @include('cashier.invoice.payment_print')
        @if (session('status'))
            <script>
                //If Redirect Back from controller socket send and print box show
                var socketKey        = "order_payment_done";
                var socketValue      = {order_payment_done : 'order_payment_done'};
                socketEmit(socketKey,socketValue);

                var modal   = $('.modal').attr('id');
                $('#' + modal).modal('show');

            </script>
        @endif
        <script type="text/javascript">
            var foc = document.getElementById('FOC');
        </script>

        <script>
        function isEmpty() {
            var amount      = $('.amount').map(function() { return this.value; }).get();
            var isValid     = true;
            $(".amount").each(function() {
                
                var element         = $(this);
                var inputvalue      = element.val();
                if (inputvalue == "") {
                    isValid = false;
                    alert('Enter Payment Value');
                }
                if (inputvalue.match(/[a-zA-Z]/i)) {
                    isValid = false;
                    alert('Payment Must be Integer');
                }
                if (inputvalue.match(/[ !@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/g)) {
                    isValid = false;
                    alert('Payment Must be Integer');
                }
            });
            return isValid;
            
        }

        function getItems() {
            var items = document.getElementsByClassName("amount");
            var total = 0;
            for (var i = 0; i < items.length; i++) {
                total += Number(items[i].value);
            }
            return total;
        }

        var element     = document.getElementById('fields_wrap').innerHTML;
        function addAmount(element) {

            var checkAdd  = isEmpty();

            //Get Net Amount
            var payment     = $('#Net').html();
            payment         = parseInt(payment.replace(/,/g, ''));
            //Calculate Payment with FOC
            var foc         = parseInt($('#FOC').val());
            if (Number.isNaN(foc)) {
                foc     = 0;
            }
            var payment     = payment - foc;
            //Total Sum From input
            var total   = getItems();

            //If Pay amount is Greater than Payment Disable Add button And Enable Paid Button
            if (total >= payment) {
            checkAdd     = false;
            $('.add-amount').attr('disabled','disabled'); 
            $('#btn-payment').prop('disabled', false);
            var refund   = total - payment;
            $('#refund').text(refund);
            } else {
            $('#refund').text(0); 
            }

            if (checkAdd == true) {
                var count       = parseInt($('.count').val());
                $(document).ready(function(e) {
                    count       = count + 1;
                    $('.count').val(count);//Add Count to input hidden to get count
                    $('.changeSelect').attr('class', count);
                    $('#fields_wrap').append(element);

                    $('.remove').css('display','block');
                    var parentCount     = count - 1;
                    $('.add-amount:eq(' + parentCount + ')').css('display','none');

                    $('.remove').click(function() { 
                        //If Total Amount Less than Payment Enable Button
                        if (total < payment) {
                            $('.add-amount').removeAttr('disabled');
                        }

                        $(this).closest(".payment_wrapper").remove();
                        var count   = parseInt($('.count').val()); 
                        count       = count - 1;
                        $('.count').val(count);
                        
                        if (count > 0) {
                            $('.add-amount:eq(' + count + ')').css('display','block');
                            exit();
                        } else {
                        $('.add-amount:eq(' + count + ')').css('display','block');
                        $('.remove:eq(' + count + ')').css('display','none');
                            exit(); 
                        }
                    });
                });
            }
        }

        function checkCash(selectObj) {
            var count           = parseInt($('.count').val());
            var cardType        = selectObj.value;
            var classObj        = $("option:selected", selectObj).attr("class");
            
            $(document).ready(function() {
                if (cardType == 2) {
                    $('input.' +classObj).hide();
                } else {
                    $('input.' +classObj).show(); 
                }
            });
            
        }
        </script>

        <!-- For Print Js -->
        <script>
            function printElement(e) {
            var ifr = document.createElement('iframe');
            ifr.style='height: 0; width: 0px; position: absolute'

            document.body.appendChild(ifr);

            $(e).clone().appendTo(ifr.contentDocument.body);
            ifr.contentWindow.print();

            ifr.parentElement.removeChild(ifr);
        }

        function print_click(clicked_id)
        {
            var clickID     = clicked_id;
            var printID     = clickID + "-print-table";
            console.log(printID);
            console.log(document.getElementById(printID));
            printElement(document.getElementById(printID));
        }

        //Close Button Return Payment List
        function return_btn()
        {
            window.location.href = "/Cashier/invoice";
        }
        </script>

        <script>
            $('#btn-payment').on('click',function(e){
                e.preventDefault();
                var form = $(this).parents('form');
                swal({
                    title: "Are you sure?",
                    text: "You will not be able to recover this payment!",
                    type: "success",
                    showCancelButton: true,
                    confirmButtonColor: "#86CCEB",
                    confirmButtonText: "Confirm",
                    closeOnConfirm: false
                }, function(isConfirm){
                    if (isConfirm) {

                            var socketKey2        = "order_payment";
                            var socketValue2      = {order_payment : 'order_payment'};
                            socketEmit(socketKey2,socketValue2);

                            var invoiceID        = document.getElementsByName("id")[0].value;
                            var socketKey       = "invoice_id";
                            var socketValue     = {invoice_id : invoiceID};
                            socketEmit(socketKey,socketValue);

                            //When Socket Emit Success Form Submit
                            var port    = getSocketPort();
                            var socket  = io.connect( 'http://'+window.location.hostname  +':' + port);
                            socket.on('invoice_payment', function(data) {
                                form.submit();
                            });
                    }
                });
                return false;
            });

            function submitForm() {
                document.forms["myForm"].submit();
            }

            function socketSendByOrder() {
                var invoiceID        = document.getElementsByName("id")[0].value;
                var socketKey       = "invoice_id";
                var socketValue     = {invoice_id : invoiceID};
                socketEmit(socketKey,socketValue);
            }
            function socketSend() {
                //Socket Emit
                var socketKey        = "order_payment";
                var socketValue      = {order_payment : 'order_payment'};
                socketEmit(socketKey,socketValue);
            }
        </script>
    </div>
@endsection
