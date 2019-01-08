
@extends('cashier.layouts.master')
@section('title','Payment')
@section('content')
@if($order->status == 1)
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
                    <a href="{{ url()->previous() }}" class="btn"><img src="/assets/cashier/images/payment/previous_img.png" alt="Previous" class="heightLine_06"></a>
                  </div>
                </div> 
              </div> 
          </div>
          <form action="/Cashier/invoice/paid/{{$order->order_id}}" method="POST">
            {{ csrf_field() }}
            <div class="row"> 
                <div class="container"> 
                    <div class="row">
                        <div class="col-md-5 col-sm-5">
                            <div class="table-responsive">
                                <table class="table receipt-table">
                                    <tr class="border">
                                        <td><b>Item</b></td>
                                        <td><b>Price</b></td>
                                        <td><b>Quantity</b></td>
                                        <td><b>Amount</b></td>
                                    </tr>
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
                                                <td class="no-border">{{ $detail['amount'] }}</td>
                                                <td class="no-border">{{ $qty2 }}</td>
                                                <td class="no-border">{{ $detail['amount']* $qty2 }} </td>
                                            @endif
                                        @else
    
                                            <td class="no-border">{{ $detail['item_name'] }}</td>
                                            <td class="no-border">{{ $detail['amount'] }}</td>
                                            <td class="no-border">{{ $qty2 }}</td>
                                            <td class="no-border">{{ $detail['amount']* $qty2 }} </td>
                                        @endif                                                                                            
                                    </tr>
                                    @endforeach

                                    @php $i = '' @endphp
                                    
                                    @foreach($addon as $add)
                                        
                                            <tr>
                                                <td class="no-border">{{ $add['food_name']}} (add on)</td>
                                                <td class="no-border">{{ $add['amount'] }}</td>
                                                <td class="no-border">{{ $add['quantity'] }} </td>
                                                <td class="no-border">{{ $add['amount'] * $add['quantity'] }}</td>
                                            </tr>
                                           
                                    @endforeach

                                   
                                    <tr class="big_row_font">
                                        <td colspan="3"><b>Net Amount</b></td>
                                        <td><input type ="number" class="total_price" value="{{$order->total_price}}" style="width:70px ; border:none;" dir="rtl" readonly></td>
                                    </tr>
                                    
                                    <tr>
                                        <td colspan="3" class="no-border"><b>Discount</b></td>
                                        <td class="no-border"><input type="number" name="discount_price" class="discount_price" value="" style="width:70px ; border:none;" dir="rtl" readonly/></td>
                                    </tr>

                                    <tr>
                                        <td colspan="3"><b>Sub-Total</b></td>
                                        <td><input type="number" name="sub_total" class="sub_total" value="" style="width:72px ; border:none;" dir="rtl" readonly></td>
                                    </tr>

                                    @if($config->service != 0)
                                    <tr class="service_charge_row">
                                        <td colspan="3" class="no-border"><b>service ({{ $config->service}}%)</b></td>
                                        <td class="no-border"><input type="number" name="service_tax" class="service_tax" value="" style="width:72px ; border:none;" dir="rtl" readonly></td>
                                    </tr>
                                    @endif

                                    <tr class="gov_charge_row"> 
                                        <td colspan="3" class="no-border"><b>TAX({{ $config->tax}}%)</b></td>
                                        <td class="no-border"><input type="number" name="gov_tax" class="gov_tax" value="" style="width:72px ; border:none;" dir="rtl" readonly></td>
                                    </tr>

                                    @if(count($rooms) > 0)
                                    <tr style="border-bottom:1px dashed black;">
                                        <td colspan="3" style="">Room Charge</td>
                                        <td align="right"><input type="number" name="room_charge" class="room_charge" value="{{$order->room_charge}}" style="width:72px ; border:none;" dir="rtl" readonly></td>
                                    </tr>
                                    @endif

                                    <tr>
                                        <td colspan="3" class=""><b class="">Total Amount</b></td>
                                        <td class=""><input type="number" name="total_amount" class="total_amount" value="" style="width:72px ; border:none;" dir="rtl" readonly></td>
                                    </tr>

                                    <tr>
                                        <td colspan="3" class=""><b>Cash Received</b></td>
                                        <td class=""><input type="number" name="receive_price" class="receive_price" value="" style="width:72px ; border:none;" dir="rtl" readonly></td>
                                    </tr>

                                    <tr>
                                        <td colspan="3" class="no-border"><b>Change</b></td>
                                        <td class="no-border"><input type="number" name="change" class="receive_change" value="" style="width:72px ; border:none;" dir="rtl" readonly></td>
                                    </tr>
                                </table>
                            </div><!-- table-responsive -->
                        <div>
                    </div>
                </div> 
                <div class="col-md-7 col-sm-7">

                    <div class="row mb-3">
                            <div class="col-md-1"></div>
                            <div class="col-md-11">
                                <label class="form-check-label ml-4">
                                    <input type="checkbox" class="form-check-input print_check_box" value="" checked="checked">ေျပစာရယူလိုပါသလား
                                </label>
                            </div>
                    </div>

                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-11">
                            <b>Discount</b>
                            <input type="number" name="discount_input" class="form-control discount_input">
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-1"></div>
                        <div class="col-md-11">
                            <b>Remark</b>
                            <input type="text" name="remark" class="form-control remark">
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-1"></div>
                        <div class="col-md-11">
                            <b>Cash Received</b>
                            <input type="number" name="cash_receive_input" class="form-control cash_receive_input">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-1"></div>
                        <div class="col-md-11">
                            <button type="submit" class="btn btn-primary save_btn" disabled>Save</button>
                        </div>
                    </div>
                  </div> <!-- row -->     
                </div> <!-- col-md-8 -->
              </div>
            </form>
            </div> 
          </div>
        </div><!-- container-fluid -->
    </div><!-- wrapper -->
@endif

@if($order->status == 2)
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
                

                    <button class="btn print-modal" onclick="printInvoice('{{$order->order_id}}')">
                        <img src="/assets/cashier/images/payment/print_img.png" alt="Print Image" class="heightLine_06">
                    </button>
                    
                    <a href="/Cashier/Dashboard" class="btn"><img src="/assets/cashier/images/payment/previous_img.png" alt="Previous" class="heightLine_06"></a>
                  </div>
                </div> 
              </div> 
          </div>
          <form action="/Cashier/invoice/paid/{{$order->order_id}}" method="POST">
            {{ csrf_field() }}
            <div class="row"> 
                <div class="container"> 
                    <div class="row">
                        <div class="col-md-5 col-sm-5">
                            <div class="table-responsive">
                                <table class="table receipt-table">
                                    <tr class="border">
                                        <td><b>Item</b></td>
                                        <td><b>Price</b></td>
                                        <td><b>Qty</b></td>
                                        <td><b>Amount</b></td>
                                    </tr>
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
                                                <td class="no-border">{{ $detail['amount'] }}</td>
                                                <td class="no-border">{{ $qty2 }}</td>
                                                <td class="no-border">{{ $detail['amount']* $qty2 }} </td>
                                            @endif
                                        @else
    
                                            <td class="no-border">{{ $detail['item_name'] }}</td>
                                            <td class="no-border">{{ $detail['amount'] }}</td>
                                            <td class="no-border">{{ $qty2 }}</td>
                                            <td class="no-border">{{ $detail['amount']* $qty2 }} </td>
                                        @endif                                                                                            
                                    </tr>
                                    @endforeach

                                    @php $i = '' @endphp

                                    @php $i = '' @endphp
                                    
                                    @foreach($addon as $add)
                                        
                                            <tr>
                                                <td class="no-border">{{ $add['food_name']}} (add on)</td>
                                                <td class="no-border">{{ $add['amount'] }}</td>
                                                <td class="no-border">{{ $add['quantity'] }} </td>
                                                <td class="no-border">{{ $add['amount'] * $add['quantity'] }}</td>
                                            </tr>
                                           
                                    @endforeach

                                    <tr class="big_row_font">
                                        <td colspan="3"><b>Net Amount</b></td>
                                        <td class="">{{$order->total_price}}</td>
                                    </tr>
                                    
                                    <tr>
                                        <td colspan="3" class="no-border"><b>Discount</b></td>
                                        <td class="no-border">{{ $order->over_all_discount }}</td>
                                    </tr>

                                    <tr>
                                        <td colspan="3"><b>Sub-Total</b></td>
                                        <td>{{ $order->sub_total }}</td>
                                    </tr>

                                    @if($config->service != 0)
                                    <tr class="service_charge_row">
                                        <td colspan="3" class="no-border"><b>service ({{ $config->service}}%)</b></td>
                                        <td class="no-border">{{ $order->service_amount }}</td>
                                    </tr>
                                    @endif

                                    <tr class="gov_charge_row"> 
                                        <td colspan="3" class="no-border"><b>TAX({{ $config->tax}}%)</b></td>
                                        <td class="no-border">{{ $order->tax_amount }}</td>
                                    </tr>

                                    @if(count($rooms) > 0)
                                    <tr style="border-bottom:1px dashed black;">
                                        <td colspan="3" style="">Room Charge</td>
                                        <td align="right">{{$order->room_charge}}</td>
                                    </tr>
                                    @endif

                                    <tr>
                                        <td colspan="3" class=""><b class="">Total Amount</b></td>
                                        <td class="">{{ $order->all_total_amount }}</td>
                                    </tr>

                                    <tr>
                                        <td colspan="3" class=""><b>Cash Received</b></td>
                                        <td class="">{{ $order->payment_amount }} </td>
                                    </tr>

                                    <tr>
                                        <td colspan="3" class="no-border"><b>Change</b></td>
                                        <td class="no-border">{{ $order->refund }}</td>
                                    </tr>
                                </table>
                            </div><!-- table-responsive -->
                        <div>
                    </div>
                </div> 
                <div class="col-md-7 col-sm-7">

                    <div class="row mb-3">
                            <div class="col-md-1"></div>
                            <div class="col-md-11">
                                <label class="form-check-label ml-4">
                                    <input type="checkbox" class="form-check-input print_check_box" value="" checked="checked" disabled>ေျပစာရယူလိုပါသလား
                                </label>
                            </div>
                    </div>

                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-11">
                            <b>Discount</b>
                            <input type="number" name="discount_input" class="form-control discount_input" disabled>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-1"></div>
                        <div class="col-md-11">
                            <b>Remark</b>
                            <input type="number" name="remark" class="form-control remark" disabled>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-1"></div>
                        <div class="col-md-11">
                            <b>Cash Received</b>
                            <input type="number" name="cash_receive_input" class="form-control cash_receive_input" disabled>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-1"></div>
                       
                    </div>
                  </div> <!-- row -->     
                </div> <!-- col-md-8 -->
              </div>
            </form>
            </div> 
          </div>
        </div><!-- container-fluid -->
    </div><!-- wrapper -->
@endif
        @include('cashier.invoice.payment_print')
        @include('cashier.invoice.items_list')
      <script type="text/javascript">
        $(document).ready(function(){


            $(".print_check_box").change(function() {
                var ischecked= $(this).is(':checked');
                if(!ischecked){
                    $('.service_charge_row').hide(300);
                    $('.gov_charge_row').hide(300);

                    var total_price = $('.total_price').val();

                    var discount_price = $('.discount_price').val();

                    var sub_total = total_price - discount_price;

                    $('input[name="sub_total"]').val(sub_total);       

                    var sub_total_price = $('.sub_total').val();

                    var service_tax_number = 0;

                    var gov_tax_number = 0;

                    $('input[name="gov_tax"]').val(gov_tax);       

                    var total_amount = eval(sub_total_price);

                    
                    var receive_price = $('.receive_price').val();
                    
                    var room_charge = $('.room_charge').val();

                    if (typeof room_charge === "undefined") {
                        
                        var room_charge = 0;

                    }
                    
                    var total_amount = eval(total_amount) + eval(room_charge);
                    
                    
                    $('input[name="total_amount"]').val(total_amount);  

                    var receive_change = eval(receive_price) - eval(total_amount);
                    
                    $('input[name="change"]').val(receive_change);   

                    if(receive_change >= 0){
                        $( ".save_btn" ).prop( "disabled", false );
                    }else{
                        $( ".save_btn" ).prop( "disabled", true );                    
                    }


                }else{

                    $('.service_charge_row').show(300);
                    $('.gov_charge_row').show(300);

                    var total_price = $('.total_price').val();
  
                    var discount_price = $('.discount_price').val();

                    var sub_total = total_price - discount_price;

                    $('input[name="sub_total"]').val(sub_total);       

                    var sub_total_price = $('.sub_total').val();

                    var service_tax_number = '<?= $config->service; ?>';

                    if(service_tax_number == 0){

                        var service_tax = 0;

                    }else{
                        var service_tax = (sub_total_price / 100) * service_tax_number;
                    }

                    var service_tax = Math.ceil(service_tax);

                    $('input[name="service_tax"]').val(service_tax);       

                    var gov_tax_number = '<?= $config->tax; ?>'
                        
                    var gov_tax = (sub_total_price / 100) * gov_tax_number;                    

                    var gov_tax = Math.ceil(gov_tax);


                    $('input[name="gov_tax"]').val(gov_tax);       
                    
                    var room_charge = $('.room_charge').val();
                    
                    if (typeof room_charge === "undefined") {

                        var room_charge = 0;

                    }

                    var total_amount = eval(sub_total_price) + eval(service_tax) + eval(gov_tax)+eval(room_charge);
                    

                    $('input[name="total_amount"]').val(total_amount);  
                    
                    var receive_price = $('.receive_price').val();

                    var receive_change = eval(receive_price) - eval(total_amount);

                    $('input[name="change"]').val(receive_change);     

                    if(receive_change >= 0){
                        $( ".save_btn" ).prop( "disabled", false );
                    }else{
                        $( ".save_btn" ).prop( "disabled", true );                    
                    }

                }
            }); 

                var total_price = $('.total_price').val();

                $('input[name="discount_price"]').val($(this).val());        

                var discount_price = $('.discount_price').val();

                var sub_total = total_price - discount_price;

                $('input[name="sub_total"]').val(sub_total);       

                var sub_total_price = $('.sub_total').val();

                var service_tax_number = '<?= $config->service; ?>';
                
                if(service_tax_number == 0){

                var service_tax = 0;

                }else{
                    var service_tax = (sub_total_price / 100) * service_tax_number;
                }

                var service_tax = Math.ceil(service_tax);

                $('input[name="service_tax"]').val(service_tax);       


                var gov_tax_number = '<?= $config->tax; ?>'
                    
                var gov_tax = (sub_total_price / 100) * gov_tax_number;

                var gov_tax = Math.ceil(gov_tax);


                $('input[name="gov_tax"]').val(gov_tax);       

                var room_charge = $('.room_charge').val();

                if (typeof room_charge === "undefined") {
                    var room_charge = 0;
                }

                var total_amount = eval(sub_total_price) + eval(service_tax) + eval(gov_tax)+eval(room_charge);

                $('input[name="total_amount"]').val(total_amount);  

            

            $('input[name="discount_input"]').on('input', function() {

                $('.receive_price').val('');

                $('.total_amount').val();
                
                $('.cash_receive_input').val('');
                
                $('.receive_change').val('');

                var total_price = $('.total_price').val();

                $('input[name="discount_price"]').val($(this).val());        

                var discount_price = $('.discount_price').val();
                
                var sub_total = total_price - discount_price;
                
                $('input[name="sub_total"]').val(sub_total);       

                var sub_total_price = $('.sub_total').val();
                
                var service_tax_number = '<?= $config->service; ?>';

                if(service_tax_number == 0){

                var service_tax = 0;

                }else{
                    var service_tax = (sub_total_price / 100) * service_tax_number;
                }

                var service_tax = Math.ceil(service_tax);

                $('input[name="service_tax"]').val(service_tax);       

                var gov_tax_number = '<?= $config->tax; ?>'
                
                var gov_tax = (sub_total_price / 100) * gov_tax_number;                

                var gov_tax = Math.ceil(gov_tax);
                

                $('input[name="gov_tax"]').val(gov_tax);       
                
                var room_charge = $('.room_charge').val();
                
                if (typeof room_charge === "undefined") {
                    var room_charge = 0;
                }

                var total_amount = eval(sub_total_price) + eval(service_tax) + eval(gov_tax)+eval(room_charge);

                $('input[name="total_amount"]').val(total_amount); 
                

            });    

            $('input[name="cash_receive_input"]').on('input', function() {
                $('input[name="receive_price"]').val($(this).val());       

                var receive_price = $('.receive_price').val();

                 var total_amount = $('.total_amount').val();

                 var receive_change = eval(receive_price) - eval(total_amount);

                $('input[name="change"]').val(receive_change);    
                
                if(receive_change >= 0){
                    $( ".save_btn" ).prop( "disabled", false );
                }else{
                    $( ".save_btn" ).prop( "disabled", true );                    
                }

            });

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
                alert(transaction_id);
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
                console.log(x);
                $('.amount-quantity').text('');
                var transaction_id      = x.id;
                $('.tender').css('background', 'none');
                $(x).css('background-color', '#A9B7C4');
                $('.void-type').attr('id', 'type-1');
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
