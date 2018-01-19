@extends('cashier.layouts.master')
@section('title','Food Order List')
@section('content')
    <section class="content">
        <div class="row">
          <div class="col-md-12" id="autoDiv">
              @include('cashier.foodorderlist.order')
          </div>
        </div>
    </section>

<script>
$(document).ready(function(){
    var url     = "/Cashier/OrderView/ajaxRequest";//Json Callback Url
    var div     = "autoDiv";//Put div id inside html response

    //Order Cancel Socket
    var invoice_update      = "invoice_update";
    socketOn(invoice_update,url,div);

    //Order start Cooking Socket
    var cooked      = "cooked";
    socketOn(cooked,url,div);

    //Order Cancel Socket
    var order_remove      = "order_remove";
    socketOn(order_remove);

    //Order Cooking Done
    var cooking_done      = "cooking_done";
    socketOn(cooking_done,url,div);

    //Taken By Waiter
    var take      = "take";
    socketOn(take,url,div);

    //Payment Done
    var payment_done      = "payment_done";
    socketOn(payment_done,url,div);

});
</script>

@endsection
