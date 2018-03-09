
@extends('cashier.layouts.master')
@section('title','ROS - Food Order List')
@section('content')
    <div class="container-fluid">  
        <div class="row cmn-ttl cmn-ttl1">
            <div class="container"> 
                <h3>Food Order Lists</h3>
            </div> 
        </div>
        <div class="container"> 
            <div class="row food-status">   
                <div class="col-md-3">  
                    <span class="fd-status fd-taken"></span>Taken by waiter
                </div>
                <div class="col-md-3">  
                    <span class="fd-status fd-cooked"></span>Cooked
                </div>
                <div class="col-md-3">  
                    <span class="fd-status fd-cooking"></span>Cooking
                </div>
                <div class="col-md-3">  
                    <span class="fd-status fd-notyet"></span>Haven't cook yet
                </div>
            </div>

            <div class="row" id="autoDiv"> 
            @if(isset($groupedOrders) && count($groupedOrders) > 0)
                @foreach($groupedOrders as $group)  
                    @if($group['status'] == 1)
                    <div class="col-md-3 mg-20" style="margin-bottom: 20px;">   
                        <div class="order-status">
                        @if($group['order_id'])
                            <p class="order-num"><span>Order No. </span><span>{{ $group['order_id']}}</span></p>
                        @endif
                            <div class="ordernum-list"> 
                                <button class="btn fd-taken ajax_request" id="{{$group['order_id']}}/4" type="button" {{ $group['count_taken'] > 0 ? "" : "disabled" }}>{{$group['count_taken']}}</button>
                                <button class="btn fd-cooked ajax_request" id="{{$group['order_id']}}/3" type="button" {{ $group['count_cooked'] > 0 ? "" : "disabled" }}>{{$group['count_cooked']}}</button>
                                <button class="btn fd-cooking ajax_request" id="{{$group['order_id']}}/2" type="button" {{ $group['count_cooking'] > 0 ? "" : "disabled" }}>{{$group['count_cooking']}}</button>
                                <button class="btn fd-notyet ajax_request" id="{{$group['order_id']}}/1" type="button" {{ $group['count_start'] > 0 ? "" : "disabled" }}>{{$group['count_start']}}</button>
                            </div> 
                            @if($group['order_id'])
                            <p class="table-num">
                                @if($group['take_id'] == 1)
                                    Take Away
                                @endif

                                @if(isset($tables))
                                    @foreach($tables as $table)
                                        @if($table->order_id == $group['order_id'])
                                           {{ $table->table_no }}
                                        @endif
                                    @endforeach
                                @endif

                                @if(isset($rooms))
                                    @foreach($rooms as $room)
                                        @if($room->order_id == $group['order_id'])
                                            {{ $room->room_name }}
                                        @endif
                                    @endforeach
                                @endif
                            </p> 
                            @endif
                        </div>
                    </div>
                    @endif 
                @endforeach
            @endif
            </div>
        </div>  
    </div><!-- container-fluid -->

    <!-- Small modal -->
    <div class="modal fade" id="smallModal" tabindex="-1" role="dialog" aria-labelledby="smallModal" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel"></h4>
                </div>
                <div class="modal-body" id="getCode">
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" id="order_close">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function(){
            $('#autoDiv').on('click','.ajax_request',function (){
                var id = $(this).attr('id');
                order(id);
                return false;
            });

            $('#order_close').click(function(){
                $('#myModalLabel').html("");
                $('#getCode').html("");
            });

            function order(id){
                var request = $.get('/Cashier/FoodOrderList/Detail/'+id);

                request.done(function(data) {
                    var items = "";
                    var title = "";
                    var status_id = id.split('/');
                    var status = status_id[1];

                    $.each(data,function(i,item){
                        if(item.item_id != 0){
                            items += "<p>"+item.name+"</p><hr>";
                        }
                        if(item.setmenu_id != 0){
                            items += "<p>"+item.set_menus_name+"</p><hr>";
                        }

                    });
                    if(status == 1){title = "Haven't Cooked Yet";}
                    if(status == 2){title = "Cooking";}
                    if(status == 3){title = "Cooked";}
                    if(status == 4){title = "Taken By Waiter";}

                    $('#myModalLabel').html(title);
                    $("#getCode").html(items);
                    $('#smallModal').modal('show');            
                });
            }

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

        function order(id){
            var request = $.get('/Cashier/FoodOrderList/Detail/'+id);

            request.done(function(data) {
                var items = "";
                var title = "";
                var status_id = id.split('/');
                var status = status_id[1];

                $.each(data,function(i,item){
                    if(item.item_id != 0){
                        items += "<p>"+item.name+"</p><hr>";
                    }
                    if(item.setmenu_id != 0){
                        items += "<p>"+item.set_menus_name+"</p><hr>";
                    }

                });
                if(status == 1){title = "Haven't Cooked Yet";}
                if(status == 2){title = "Cooking";}
                if(status == 3){title = "Cooked";}
                if(status == 4){title = "Taken By Waiter";}

                $('#myModalLabel').html(title);
                $("#getCode").html(items);
                $('#smallModal').modal('show');            
            });
        }
    </script>
@endsection
