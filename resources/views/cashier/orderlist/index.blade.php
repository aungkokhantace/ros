@extends('cashier.layouts.master')
@section('title','Order')
@section('content')
    <div class="container">  
        <div class="row cmn-ttl cmn-ttl1">
            <div class="container"> 
                <h3>Make Order</h3>
            </div> 
        </div>
        <div class="row">   
            <div class="col-md-3">
                <a href="/Cashier/MakeOrder/takeAway"><img id="img" class="bottom image" src= "../../../assets/images/icon-home-1.png" ></a>
                <h3 class="listheader">Take Away</h3>
            </div>

            <div class="col-md-3">
                <a href="/Cashier/MakeOrder/tables"><img id="img" class="bottom image" src= "../../../assets/images/icon-home-2.png" ></a>
                <h3 class="listheader">Table</h3>
            </div>

            <div class="col-md-3">
                <a href="/Cashier/MakeOrder/rooms"><img id="img" class="bottom image" src= "../../../assets/images/icon-home-3.png" ></a>
                <h3 class="listheader">Room</h3>
            </div>
        </div><!-- End Row -->
    </div><!-- container-fluid -->
    <script type="text/javascript">
        $("#body").css('background-color','rgba(255, 255, 255, 0)');
    </script>

@endsection