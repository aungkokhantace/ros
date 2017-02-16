@extends('cashier.layouts.master')
@section('title','Detail Food Order List')
@section('content')
    <section class="content">
        <div class="row">
          <div class="col-md-12" id="autoDiv">
             <div class="col-md-12">
                <div class="col-md-6"></div>
                <div class="col-md-6">
                    <div class="col-md-3">
                        <img src="/assets/images/icon_grey.png">Haven't Cook Yet
                    </div>
                    <div class="col-md-3">
                        <img src="/assets/images/icon_red.png">Cooking
                    </div>
                    <div class="col-md-3">
                        <img src="/assets/images/icon_green.png">Cooked
                    </div>
                    <div class="col-md-3">
                        <img src="/assets/images/icon_blue.png">Taken By Waiter
                    </div>
                </div>
             </div>
             <table>
            @foreach($orders as $order)
            <tr class="orderlist-body">
                <td>
                    @if($order->order_status == 1)
                        <span><img src="/assets/images/icon_gray.png">
                            @if($order->item_id != "null")
                                {{$order->name}}
                            @endif
                            @if($order->set_id != "null")
                                {{$order->set_menus_name}}
                            @endif
                        </span>
                    
                    @elseif($order->order_status == 2)
                        <span><img src="/assets/images/icon_red.png">
                            @if($order->item_id != "null")
                                {{$order->name}}
                            @endif
                            @if($order->set_id != "null")
                                {{$order->set_menus_name}}
                            @endif
                        </span>
                    @elseif($order->order_status == 3)
                        <span><img src="/assets/images/icon_green.png">
                            @if($order->item_id != "null")
                                {{$order->name}}
                            @endif
                            @if($order->set_id != "null")
                                {{$order->set_menus_name}}
                            @endif
                        </span>
                    @else
                        <span><img src="/assets/images/icon_blue.png">
                            @if($order->item_id != "null")
                                {{$order->name}}
                            @endif
                            @if($order->set_id != "null")
                                {{$order->set_menus_name}}
                            @endif
                        </span>                        
                    @endif 
                        <span>({{$order->order_type}})</span><br/>
                </td>
            </tr>
             @endforeach
             <table>
          </div>
        </div>
    </section>

@endsection

