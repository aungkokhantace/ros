@extends('cashier.layouts.master')
@section('title','Make Order')
@section('content')

    <div class="col-md-3">
       <a href="/Cashier/MakeOrder/category"><img id="img" class="bottom image" src= "../../../assets/images/icon-home-1.png" ></a>
       <h3 class="listheader">Take Away</h3>
    </div>
    <div class="col-md-3">
       <img id="img" class="bottom image" src= "../../../assets/images/icon-home-2.png" ></a>
       <h3 class="listheader">Table</h3>
    </div>
    <div class="col-md-3">
       <img id="img" class="bottom image" src= "../../../assets/images/icon-home-3.png" ></a>
       <h3 class="listheader">Room</h3>
    </div>
    <div class="col-md-3">
       <img id="img" class="bottom image" src= "../../../assets/images/icon-home-4.png" ></a>
       <h3 class="listheader">Invoice</h3>
    </div>
    <script type="text/javascript">
        $("#body").css('background-color','rgba(255, 255, 255, 0)');
    </script>

@endsection