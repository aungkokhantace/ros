
@extends('cashier.layouts.master')
@section('title','Payment')
@section('content')
    <div class="wrapper"> 
        <div class="container-fluid receipt">  
          <div class="row cmn-ttl cmn-ttl2">
              <div class="container">
                <div class="row">
                    <input type="hidden" class="void-value" id="" />
                    <input type="hidden" class="void-type" id="" />
                    <div class="col-lg-4 col-md-5 col-sm-6 col-6">
                        <h3>Order no : {{$order->order_id }} - 
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
                        </h3>
                    </div>
                  <div class="col-lg-8 col-md-7 col-sm-6 col-6 receipt-btn">
                        <button class="btn print-modal" onclick="printInvoice('{{$order->order_id}}')" data-toggle="modal" data-target="#printModal" data-id="{{$order->order_id}}" id="printInvoice" {{ $order->status == 2 ? "" : "style=display:none;" }}>
                            <img src="/assets/cashier/images/payment/print_img.png" alt="Print Image" class="heightLine_06">
                        </button>

                    <a class="btn" href="/Cashier/invoice">                
                        <img src="/assets/cashier/images/payment/previous_img.png" alt="Previous" class="heightLine_06">     
                    </a>
                  </div>
                </div> 
              </div> 
          </div>
            <div class="row"> 
                <div class="container"> 
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-6">
                            <div class="table-responsive">
                                <table class="table receipt-table">
                                    <tr>
                                        <td>Sub Total</td>
                                        <td>{{ number_format($order->total_price) }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="bg-gray">Sub-Total (After All Discount)</td>
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
                                        <td>GST({{ $config->tax}}%)</td>
                                        <td>{{ number_format($order->tax_amount) }} </td>
                                    </tr>

                                    @if ($order->total_discount_amount > 0)
                                    <tr>
                                        <td>discount</td>
                                        <td>{{ number_format($order->total_discount_amount) }}</td>
                                    </tr>  
                                    @endif

                                    <tr class="foc-tr" style="cursor: pointer;">
                                        <td>free of charge</td>
                                        <td class="foc">{{ number_format($order->foc_amount) }}</td>
                                    </tr>
                                </table>
                            </div><!-- table-responsive -->

                            <h3 class="receipt-ttl">TOTAL - {{ number_format($order->all_total_amount) }}</h3>
                            <div class="table-responsive">
                                <table class="table receipt-table" id="invoice-table">
                                    <tr class="before-tr" style="height: 32px;">
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
                        <td>BALANCE</td>
                        <td class="balance">{{ $tenders['balance'] }}</td>
                      </tr>
                      <tr>
                        <td>CHANGE</td>
                        <td class="change">
                            {{ $tenders['change']}}
                        </td>
                      </tr>
                    </table>
                  </div><!-- table-responsive -->
                    <div class="row receipt-btn02">
                        <div class="col-md-6 col-sm-6 col-6"><button class="btn btn-primary item-modal" data-toggle="modal" data-target="#printModal" data-id="{{$order->order_id}}" onclick="itemModal('{{$order->order_id}}')">ITEM LISTS</button></div>
                        <div class="col-md-6 col-sm-6 col-6"><button class="btn btn-primary">VIEW DETAILS</button></div>
                    </div>

                </div> 
                <div class="col-md-8 col-sm-8 col-6">
                  <div class="row"> 
                    <div class="col-md-12 list-group" id="myList" role="tablist">
                        <a class="list-group-item list-group-item-action heightLine_05 active" data-toggle="list" href="#home" role="tab" id="payment-cash">
                          <span class="receipt-type cash-img"></span><span class="receipt-txt">Cash</span>
                        </a>
                        <a class="list-group-item list-group-item-action heightLine_05" data-toggle="list" href="#profile" role="tab" id="payment-card">
                          <span class="receipt-type card-img"></span><span class="receipt-txt">Card</span>
                        </a>
                        <a class="list-group-item list-group-item-action heightLine_05" data-toggle="list" href="#messages" role="tab" id="payment-voucher">
                          <span class="receipt-type voucher-img"></span><span class="receipt-txt">Voucher</span>
                        </a>
                        <a class="list-group-item list-group-item-action heightLine_05" data-toggle="list" href="#settings" role="tab" id="payment-nocollection">
                          <span class="receipt-type collection-img"></span><span class="receipt-txt">No Collection</span>
                        </a>
                        <a class="list-group-item list-group-item-action heightLine_05" data-toggle="list" href="#settings" role="tab" id="payment-loyalty">
                          <span class="receipt-type loyality-img"></span><span class="receipt-txt">Loyalty</span>
                        </a>
                    </div> <!-- list-group -->
                    <div class="col-md-12">
                    <div class="tab-content row">
                      <div class="tab-pane active" id="home" role="tabpanel">
                        <button class="btn heightLine_04 cash-payment" id="CASH"><span class="extra-cash"></span><span>Kyats</span></button>
                        <button class="btn heightLine_04 cash-payment" id="CASH50"><span class="money">50</span> <span>Kyats</span></button>
                        <button class="btn heightLine_04 cash-payment" id="CASH100"><span class="money">100</span><span>Kyats</span></button>
                        <button class="btn heightLine_04 cash-payment" id="CASH200"><span class="money">200</span><span>Kyats</span></button>
                        <button class="btn heightLine_04 cash-payment" id="CASH500"> <span class="money">500</span> <span>Kyats</span></button>
                        <button class="btn heightLine_04 cash-payment" id="CASH1000"><span class="money">1000</span><span>Kyats</span></button>
                        <button class="btn heightLine_04 cash-payment" id="CASH5000"><span class="money">5000</span><span>Kyats</span> </button>
                        <button class="btn heightLine_04 cash-payment" id="CASH10000"> <span class="money">10000</span><span>Kyats</span></button>
                      </div>
                      <div class="tab-pane" id="profile" role="tabpanel">
                            <button class="btn heightLine_05 mpu-type agd-mpu card-payment" id="MPU_AGD"><span class="receipt-type cash-img"></span><span class="receipt-txt">AGD</span></button>
                            <button class="btn heightLine_05 mpu-type kbz-mpu card-payment" id="MPU_KBZ"><span class="receipt-type cash-img"></span><span class="receipt-txt">KBZ</span></button>
                            <button class="btn heightLine_05 mpu-type uab-mpu card-payment" id="MPU_UAB"><span class="receipt-type cash-img"></span><span class="receipt-txt">UAB</span></button>
                            <button class="btn heightLine_05 mpu-type mob-mpu card-payment" id="MPU_MOB"><span class="receipt-type cash-img"></span><span class="receipt-txt">MOB</span></button>
                            <button class="btn heightLine_05 mpu-type chd-mpu card-payment" id="MPU_CHD"><span class="receipt-type cash-img"></span><span class="receipt-txt">CHD</span></button>

                            <button class="btn heightLine_05 mpu-type kbz-visa card-payment" id="VISA_KBZ"><span class="receipt-type cash-img"></span><span class="receipt-txt">KBZ</span></button>
                            <button class="btn heightLine_05 mpu-type cb-visa card-payment" id="VISA_CB"><span class="receipt-type cash-img"></span><span class="receipt-txt">CB</span></button>
                      </div>
                      <!-- <div class="tab-pane" id="messages" role="tabpanel">Messages</div>
                      <div class="tab-pane" id="settings" role="tabpanel">Settings</div> -->
                    </div> <!-- tab-content -->
                    </div>
                    <div class="payment-cal col-md-12"> 
                      <div class="row"> 
                        <div class="col-md-12 payment-show">
                          <p class="amount-quantity" style="min-height: 33px;"></p>
                        </div>
                        <div class="col-md-12 receipt-btn3"> 
                          <button class="btn quantity" id="1">1</button>
                          <button class="btn quantity" id="2">2</button>
                          <button class="btn quantity" id="3">3</button>
                          <button class="btn quantity" id="4">4</button>
                          <button class="btn quantity" id="5">5</button>
                          <button class="btn quantity" id="6">6</button>
                          <button class="btn quantity" id="7">7</button>
                          <button class="btn quantity" id="8">8</button>
                          <button class="btn quantity" id="9">9</button>
                          <button class="btn quantity" id="0">0</button>
                        </div>
                        <div class="col-md-12 receipt-btn4">                       
                            <button class="btn btn-primary void-btn" id = 'void-item'>VOID <i class="fa fa-trash-alt"></i></button>
                            <button class="btn clear-input-btn">CLEAR INPUT</button>
                            <button class="btn btn-primary foc-btn">FREE CHARGE</button>
                        </div>
                      </div>

                    </div>
                  </div> <!-- row -->     
                </div> <!-- col-md-8 -->

              </div>

            </div> 
          </div>
        </div><!-- container-fluid -->
      </div><!-- wrapper -->

        @include('cashier.invoice.payment_print')
        @include('cashier.invoice.items_list')
      <script type="text/javascript">
        $(document).ready(function(){
            var socket = socketConnect();
            //If Clear button 
            $('.clear-input-btn').click(function(){
                $('.amount-quantity').text('');
            });

            //If User Click Quantity Button
            $('.quantity').click(function(){
                quantity        = $(this).attr('id');
                $(".amount-quantity").append(quantity);
            });

            $('.cash-payment').click(function(){
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
                                $("#printInvoice").css("display", "");
                                for (var print in payment_print) {
                                    var printObj        = payment_print[print];
                                    var card_name       = printObj.name;
                                    var paid_amount     = printObj.paid_amount;
                                    $('.net-amount').after('<tr class="tr-bottom-dashed i-title payment-amount"><td colspan="3">Paid ' + card_name + '</td><td class="text-right">' + paid_amount + '</td></tr>');
                                }
                                socket.emit('order_payment', { 
                                    order_payment   : 'order_payment'
                                });
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
            $('.card-payment').click(function(){
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
                                $("#printInvoice").css("display", "");
                                for (var print in payment_print) {
                                    var printObj        = payment_print[print];
                                    var card_name       = printObj.name;
                                    var paid_amount     = printObj.paid_amount;
                                    $('.net-amount').after('<tr class="tr-bottom-dashed i-title payment-amount"><td colspan="3">Paid ' + card_name + '</td><td class="text-right">' + paid_amount + '</td></tr>');
                                }
                                socket.emit('order_payment', { 
                                    order_payment   : 'order_payment'
                                });
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
                $('.foc-tr').css('background', 'none');
                $(this).css('background-color', '#A9B7C4');
                var elements = document.querySelectorAll('.void-value');
                $('.void-type').attr('id', 'type-1');
                if (elements.length) {
                    elements[0].id = 'void-' + transaction_id;
                }
            });

            $('.foc-tr').click(function() {
                // var transaction_id      = $(this).attr("id");
                $('.foc-tr').css('background', 'none');
                $('.tender').css('background', 'none');
                $(this).css('background-color', '#A9B7C4');
                var elements = document.querySelectorAll('.void-value');
                $('.void-type').attr('id', 'type-2');
                if (elements.length) {
                    elements[0].id = 'void-' + transaction_id;
                }
            });

            //If User Click Void Button
            $('#void-item').click(function(){
                var void_type   = $('.void-type').attr('id');
                var void_id   = $('.void-value').attr('id');
                if (void_type == '' || void_type == 0) {
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
                    if (void_type == 'type-1') {
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

                    //If FOC Void
                    if (void_type == 'type-2') {
                        var dataString = { 
                                    _token        : '{{ csrf_token() }}',
                                    order_id          : '{{ $order->order_id }}'
                                };
                        $.ajax({
                            url     : '/Cashier/transaction_tenders/deleteFoc',
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
                }  
            } 
            });

            //If user click foc button
            $('.foc-btn').click(function(){
                amount        = $('.amount-quantity').text();
                if (amount == '') {
                    swal({
                        title: "Warning!",
                        text: "Your need to choose foc amount",
                        type: "info",
                        showCancelButton: false,
                        confirmButtonColor: "#86CCEB",
                        confirmButtonText: "Confirm",
                        closeOnConfirm: false
                    }); 
                } else {
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
                }  
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
