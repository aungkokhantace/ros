@extends('cashier.layouts.master')
@section('title','Invoice Paid')
@section('content') 
    <link href="/assets/mystyle/styles.css" rel="stylesheet">
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
            <div class="col-xs-12">
                <div class="page-ctn clearfix">
                    <div class="col-lg-4 col-md-12">
                        <div class="pay-table">
                            <input type="hidden" class="void-value" id="" />
                            <div class="table-responsive">
                                <table class="table" id="invoice-table">
                                  <thead>
                                    <tr>
                                        <th>ORDER NO : {{$order->order_id }}</th>
                                        <th>
                                            @if($tables->count() > 0)
                                                @foreach($tables as $table)
                                                    {{ $table->table_no }}
                                                @endforeach
                                            @elseif($rooms->count() > 0)
                                                @foreach($rooms as $room)
                                                    {{ $room->room_name }}
                                                @endforeach
                                            @else
                                                {{ "Take Away" }}
                                            @endif
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>SUB TOTAL</th>
                                        <th>{{ number_format($order->total_price) }}</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr>
                                        <td colspan="2" class="text-center amount-quantity"></td>
                                    </tr>   
                                    <tr>
                                        <td colspan="2" class="cell-col-gray text-center">Sub Total (After All Discount)</td>
                                    </tr>  
                                    @if ($order->room_charge > 0) 
                                    <tr>
                                        <td>room charge</td>
                                        <td>{{ number_format($order->room_charge) }}</td>
                                    </tr> 
                                    @endif

                                    <tr>
                                        <td>service charge ({{ $config->service}}%)</td>
                                        <td>{{ number_format($order->service_amount) }}</td>
                                    </tr>   
                                    <tr>
                                        <td>gst({{ $config->tax}}%)</td>
                                        <td>{{ number_format($order->tax_amount) }} </td>
                                    </tr>   

                                    @if ($order->total_discount_amount > 0)
                                    <tr>
                                        <td>discount</td>
                                        <td>{{ number_format($order->total_discount_amount) }}</td>
                                    </tr>  
                                    @endif

                                    <tr>
                                        <td>free of charge</td>
                                        <td class="foc">{{ number_format($order->foc_amount) }}</td>
                                    </tr>
                                    <tr class="cell-col-gray">
                                        <td>payable amount</td>
                                        <td>{{ number_format($order->all_total_amount) }}</td>
                                    </tr>
                                    <tr class="before-tr">
                                        <td colspan="2" class="bl-data"></td>
                                    </tr>
                                    @foreach($tenders['pay'] as $tender)
                                        <tr class="tender" id="transaction-{{ $tender['id'] }}">
                                            <td>
                                            @if ($tender['card'] == 1)
                                                cash {{ $tender['total'] }} mmk
                                            @else
                                                {{ $tender['total'] . ' mmk - ' . $tender['description']}}
                                            @endif
                                            </td>
                                            <td>{{ $tender['total'] }}</td>
                                        </tr>
                                    @endforeach
                                        <tr>
                                            <td colspan="2" class="bl-data"></td>
                                        </tr>
                                        <tr>
                                            <td>balance</td>
                                            <td class="balance">{{ $tenders['balance'] }}</td>
                                        </tr>
                                        <tr>
                                            <td>change</td>
                                            <td class="change">
                                                {{ $tenders['change']}}
                                            </td>
                                        </tr>                       
                                  </tbody>
                                </table>
                            </div><!-- pay table -->
                            <div class="pay-btn-group clearfix">
                                <button type="button" class="btn btn-success" onclick="backOrder()"><span>BACK ORDER</span></button>
                                <button type="button" class="btn btn-success item-modal" data-toggle="modal" data-target="#printModal" data-id="{{$order->order_id}}" onclick="itemModal('{{$order->order_id}}')"><span>ITEM LIST</span></button>
                                <button type="button" class="btn btn-success"><span>VIEW DETAILS</span></button>
                            </div><p>&nbsp;</p>
                            
                            <div class="pay-btn-group clearfix print-div" @if($order->status == 1) {{ "style=display:none "}} @else {{ "style=display:block "}} @endif>
                                <button type="button" class="btn btn-success print-modal" data-toggle="modal" data-target="#printModal" data-id="{{$order->order_id}}" onclick="printInvoice('{{$order->order_id}}')"><span>PRINT INVOICE</span></button>
                            </div>
                        </div>
                    </div><!--left side-->
                    <div class="col-lg-6 col-md-12 pay-center">
                        <div class="pay-type pay-bg clearfix">  
                            <button type="button" class="btn btn-primary payment-type" id="payment-cash"><span>CASH</span></button>
                            <button type="button" class="btn btn-primary payment-type" id="payment-card"><span>CARD</span></button>
                            <button type="button" class="btn btn-primary payment-type" id="payment-voucher"><span>VOUCHER</span></button>
                            <button type="button" class="btn btn-primary payment-type" id="payment-nocollection"><span>No Collection</span></button>
                            <button type="button" class="btn btn-primary payment-type" id="payment-loyalty"><span>LOYALTY</span></button>
                        </div>                      
                        
                        @include('cashier.invoice.payment_cash')
                        @include('cashier.invoice.payment_card')
                        @include('cashier.invoice.payment_print')
                        @include('cashier.invoice.items_list')
                    </div><!--center side-->
                    <div class="col-lg-2 col-md-12">
                        <div class="void">                              
                            <button type="button" class="btn btn-secondary" id = 'void-item'>VOID</button>
                            <button type="button" class="btn btn-success quantity" id="1">1</button>
                            <button type="button" class="btn btn-success quantity" id="2">2</button>
                            <button type="button" class="btn btn-success quantity" id="3">3</button>
                            <button type="button" class="btn btn-success quantity" id="4">4</button>
                            <button type="button" class="btn btn-success quantity" id="5">5</button>
                            <button type="button" class="btn btn-success quantity" id="6">6</button>
                            <button type="button" class="btn btn-success quantity" id="7">7</button>
                            <button type="button" class="btn btn-success quantity" id="8">8</button>
                            <button type="button" class="btn btn-success quantity" id="9">9</button>
                            <button type="button" class="btn btn-success quantity" id="0">0</button>
                            <button type="button" class="btn btn-warning foc-btn">FREE OF CHARGE</button>
                            <button type="button" class="btn btn-danger clear-btn">CLEAR INPUT</button>
                        </div>
                    </div><!--right side-->
                </div><!--page-ctn-->
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function(){
            //If Clear button 
            $('.clear-btn').click(function(){
                $('.amount-quantity').text('');
            });
            $('.payment-type').click(function(){
                $('.payment-type').removeClass("btn-active");
                payment_id      = $(this).attr("id");
                $('#' + payment_id).addClass("btn-active");

                //If Click Pay Cash
                if (payment_id == 'payment-cash') {
                    $('.pay-cash').show();
                    $('.pay-card').hide();
                }

                //If Click Pay Card
                if (payment_id == 'payment-card') {
                    $('.pay-card').show();
                    $('.pay-cash').hide();
                }
            });

            //If User Click Quantity Button
            $('.quantity').click(function(){
                quantity        = $(this).attr('id');
                $('.amount-quantity').append(quantity);
            });

            $( ".pay-cash" ).on( "click", ".cash-payment", function() {
                cash_id         = $(this).attr("id");
                quantity        = $('.amount-quantity').text();
                if (quantity == '' || quantity == '0') {
                    qty        = 1;
                } else {
                    qty        = parseInt(quantity);
                }
                var dataString = { 
                      cash_id       : cash_id,
                      _token        : '{{ csrf_token() }}',
                      order_id      : '{{ $order->order_id }}',
                      quantity      : qty
                };
                $.ajax({
                    url     : '/Cashier/transaction_tenders/storeCash',
                    type    : 'POST',
                    data    : dataString,
                    dataType: "json",
                    cache   : false,
                    success: function(data) {
                        $('.amount-quantity').text('');
                        var msg         = data.message;
                        var foc         = data.foc;
                        var order_total = data.order_total;
                        $('.foc').text(foc);
                        if (msg == 'success') {
                            var invoiceList     = JSON.parse(data.invoice);
                            var balance         = invoiceList.balance;
                            var change          = invoiceList.change;
                            var payment         = invoiceList.pay;
                            var payment_print   = invoiceList.payment_print;
                            var payment_done    = invoiceList.payment_done;
                            payment.reverse();
                            // console.log(payment);
                            $('tr[class=tender]').andSelf().remove();
                            for (var pay in payment) {
                                var paymentObj      = payment[pay];
                                var total       = paymentObj.total;
                                var description     = paymentObj.description;
                                var type            = paymentObj.card;
                                if (type == 1) {
                                    pay_amount  = 'cash ' + total + ' mmk';
                                } else {
                                    pay_amount  = total + ' mmk - ' + description;
                                }
                                $('#invoice-table .before-tr').after('<tr class="tender" onclick="myFunction(this)" id="transaction-' + paymentObj.id + '"><td>' + pay_amount + '</td><td>' + total + '</td></tr>');
                            }
                            //Add Balance Amount
                            $('.balance').text('');
                            $('.balance').append(balance);

                            //Add Change Amount
                            $('.change').text('');
                            $('.change').append(change);

                            if (payment_done == 'yes') {
                                $('tr[class=payment-amount]').andSelf().remove();
                                $('.total-change').text(change);
                                $('.foc-amount').text(foc);
                                $(".print-div").css("display", "block");
                                for (var print in payment_print) {
                                    var printObj        = payment_print[print];
                                    var card_name       = printObj.name;
                                    var paid_amount     = printObj.paid_amount;
                                    $('.net-amount').after('<tr class="tr-bottom-dashed i-title payment-amount"><td colspan="3">Paid ' + card_name + '</td><td class="text-right">' + paid_amount + '</td></tr>');
                                }
                                $('.print-modal').click(); 
                            }
                        }

                        if (msg == 'paid') {
                            swal({
                                title: "Payment Done!",
                                text: "Your Payment is done",
                                type: "info",
                                showCancelButton: false,
                                confirmButtonColor: "#86CCEB",
                                confirmButtonText: "Confirm",
                                closeOnConfirm: false
                            });
                        }
                    },
                    error: function(data) {
                        alert('Error');    
                    }
                });
            });
            //User pay with card
            $( ".pay-card" ).on( "click", ".card-payment", function() {
                card_id                 = $(this).attr("id");
                card_with_amount        = $('.amount-quantity').text();
                qty                     = 1;
                if (card_with_amount == '' || card_with_amount == '0') {
                    exact_payment        = 'yes';
                } else {
                    exact_payment        = 'no';
                }
                var dataString = { 
                      card_id           : card_id,
                      _token            : '{{ csrf_token() }}',
                      order_id          : '{{ $order->order_id }}',
                      card_with_amount  : card_with_amount,
                      quantity          : qty,
                      exact_payment     : exact_payment
                };
                $.ajax({
                    url     : '/Cashier/transaction_tenders/storeCard',
                    type    : 'POST',
                    data    : dataString,
                    dataType: "json",
                    cache   : false,
                    success: function(data) {
                        console.log(data);
                        $('.amount-quantity').text('');
                        var msg         = data.message;
                        var foc         = data.foc;
                        var order_total = data.order_total;
                        if (msg == 'success') {
                            var invoiceList     = JSON.parse(data.invoice);
                            console.log(invoiceList);
                            var balance         = invoiceList.balance;
                            var change          = invoiceList.change;
                            var payment         = invoiceList.pay;
                            var payment_done    = invoiceList.payment_done;
                            var payment_print   = invoiceList.payment_print;
                            if (payment_done == 'yes') {
                                $('tr[class=payment-amount]').andSelf().remove();
                                $('.total-change').text(change);
                                $('.foc-amount').text(foc);
                                $(".print-div").css("display", "block");
                                for (var print in payment_print) {
                                    var printObj        = payment_print[print];
                                    var card_name       = printObj.name;
                                    var paid_amount     = printObj.paid_amount;
                                    $('.net-amount').after('<tr class="tr-bottom-dashed i-title payment-amount"><td colspan="3">Paid ' + card_name + '</td><td class="text-right">' + paid_amount + '</td></tr>');
                                }
                                $('.print-modal').click();
                            }
                            payment.reverse();
                            // console.log(payment);
                            $('tr[class=tender]').andSelf().remove();
                            for (var pay in payment) {
                                var paymentObj      = payment[pay];
                                var total           = paymentObj.total;
                                var description     = paymentObj.description;
                                var type            = paymentObj.card;
                                if (type == 1) {
                                    pay_amount  = 'cash ' + total + ' mmk';
                                } else {
                                    pay_amount  = total + ' mmk - ' + description;
                                }
                                $('#invoice-table .before-tr').after('<tr class="tender" onclick="myFunction(this)" id="transaction-' + paymentObj.id + '"><td>' + pay_amount + '</td><td>' + total + '</td></tr>');
                            }
                            //Add Balance Amount
                            $('.balance').text('');
                            $('.balance').append(balance);

                            //Add Change Amount
                            $('.change').text('');
                            $('.change').append(change);
                        }

                        if (msg == 'paid') {
                            swal({
                                title: "Payment Done!",
                                text: "Your Payment is done",
                                type: "info",
                                showCancelButton: false,
                                confirmButtonColor: "#86CCEB",
                                confirmButtonText: "Confirm",
                                closeOnConfirm: false
                            });
                        }
                    },
                    error: function(data) {
                        alert('Error');    
                    }
                });
            });
            $('#payment-cash').click();

             //For Void Function 
            var transaction_id     = '';

            $('.tender').click(function() {
                $('.amount-quantity').text('');
                var transaction_id      = $(this).attr("id");
                $('.tender').css('background', 'none');
                $(this).css('background-color', '#A9B7C4');
                var elements = document.querySelectorAll('.void-value');
  
                if (elements.length) {
                    elements[0].id = 'void-' + transaction_id;
                }
            });

            //If User Click Void Button
            $( ".void" ).on( "click", "#void-item", function() {
                var void_id   = $('.void-value').attr('id');
                if (void_id == '') {
                    swal({
                        title: "Warning!",
                        text: "Your need to select one of payment",
                        type: "info",
                        showCancelButton: false,
                        confirmButtonColor: "#86CCEB",
                        confirmButtonText: "Confirm",
                        closeOnConfirm: false
                    });
                } else {
                    var void_val  = void_id.replace("void-transaction-", "");
                    void_val      = parseInt(void_val);
                    var dataString = { 
                                    _token        : '{{ csrf_token() }}',
                                    order_id          : '{{ $order->order_id }}',
                                    void_val          : void_val 
                                };
                    $.ajax({
                        url     : '/Cashier/transaction_tenders/delete',
                        type    : 'POST',
                        data    : dataString,
                        dataType: "json",
                        cache   : false,
                        success: function(data) {
                            var msg         = data.message;
                            if (msg == 'success') {
                                var invoiceList     = JSON.parse(data.invoice);
                                var balance         = invoiceList.balance;
                                var change          = invoiceList.change;
                                var payment         = invoiceList.pay;
                                payment.reverse();
                                // console.log(payment);
                                $('tr[class=tender]').andSelf().remove();
                                for (var pay in payment) {
                                    var paymentObj      = payment[pay];
                                    var total       = paymentObj.total;
                                    var description     = paymentObj.description;
                                    var type            = paymentObj.card;
                                    if (type == 1) {
                                        pay_amount  = 'cash ' + total + ' mmk';
                                    } else {
                                        pay_amount  = total + ' mmk - ' + description;
                                    }
                                    $('#invoice-table .before-tr').after('<tr class="tender" onclick="myFunction(this)" id="transaction-' + paymentObj.id + '"><td>' + pay_amount + '</td><td>' + total + '</td></tr>');
                                }
                                //Add Balance Amount
                                $('.balance').text('');
                                $('.balance').append(balance);

                                //Add Change Amount
                                $('.change').text('');
                                $('.change').append(change);
                            }

                            if (msg == 'paid') {
                                swal({
                                    title: "Payment Done!",
                                    text: "Your Payment is done.You can not void item.",
                                    type: "info",
                                    showCancelButton: false,
                                    confirmButtonColor: "#86CCEB",
                                    confirmButtonText: "Confirm",
                                    closeOnConfirm: false
                                });
                            }
                        },
                        error: function(data) {
                            alert('Error');    
                        }
                    });   
                } 
            });

            //If user click foc button
            $( ".void" ).on( "click", ".foc-btn", function() {
                amount        = $('.amount-quantity').text();
                var dataString = { 
                                _token        : '{{ csrf_token() }}',
                                order_id          : '{{ $order->order_id }}',
                                amount            : amount 
                            };
                $.ajax({
                    url     : '/Cashier/transaction_tenders/updateFoc',
                    type    : 'POST',
                    data    : dataString,
                    dataType: "json",
                    cache   : false,
                    success: function(data) {
                        var msg         = data.message;
                        var foc         = data.foc;
                        $('.foc').text(foc);
                        if (msg == 'success') {
                            var invoiceList     = JSON.parse(data.invoice);
                            var balance         = invoiceList.balance;
                            var change          = invoiceList.change;
                            var payment         = invoiceList.pay;
                            payment.reverse();
                            // console.log(payment);
                            $('tr[class=tender]').andSelf().remove();
                            for (var pay in payment) {
                                var paymentObj      = payment[pay];
                                var total       = paymentObj.total;
                                var description     = paymentObj.description;
                                var type            = paymentObj.card;
                                if (type == 1) {
                                    pay_amount  = 'cash ' + total + ' mmk';
                                } else {
                                    pay_amount  = total + ' mmk - ' + description;
                                }
                                $('#invoice-table .before-tr').after('<tr class="tender" onclick="myFunction(this)" id="transaction-' + paymentObj.id + '"><td>' + pay_amount + '</td><td>' + total + '</td></tr>');
                            }
                            //Add Balance Amount
                            $('.balance').text('');
                            $('.balance').append(balance);

                            //Add Change Amount
                            $('.change').text('');
                            $('.change').append(change);
                            $('.amount-quantity').text('');
                        }

                        if (msg == 'paid') {
                            swal({
                                title: "Payment Done!",
                                text: "Your Payment is done",
                                type: "info",
                                showCancelButton: false,
                                confirmButtonColor: "#86CCEB",
                                confirmButtonText: "Confirm",
                                closeOnConfirm: false
                            });
                        }
                    },
                    error: function(data) {
                        alert('Error');    
                    }
                });  
            });
        });


        function backOrder() {
            window.location='/Cashier/invoice';
        }

        function printInvoice(invoice) {
            var id      = invoice;
            var modal   = id + '-print';
            $('#' + modal).modal('show');
        }

        function itemModal(invoice) {
            var id      = invoice;
            var modal   = id + '-item';
            $('#' + modal).modal('show');
        }

        function myFunction(x) {
            $(document).ready(function(){
                $('.amount-quantity').text('');
                var transaction_id      = x.id;
                $('.tender').css('background', 'none');
                $(x).css('background-color', '#A9B7C4');
                var elements = document.querySelectorAll('.void-value');
                if (elements.length) {
                    elements[0].id = 'void-' + transaction_id;
                }
            });
        }

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
            printElement(document.getElementById(printID));
        }
    </script>
@endsection
