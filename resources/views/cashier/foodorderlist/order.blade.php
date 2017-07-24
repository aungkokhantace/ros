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
@if(isset($groupedOrders) && count($groupedOrders) > 0)
@foreach($groupedOrders as $group)
    <div class="col-md-2 sticky">
        <table>
         @if($group['order_id'])
            <tr class="orderlist-header">
                <td>
                     <h4>Order No.{{ $group['order_id']}}</h4>
                </td>
            </tr>
            <tr class="orderlist-body">
                <td>
                        @if($group['take_id'] == 1)
                            <h5>Take Away </h5>
                        @endif

                        @if(isset($tables))
                            @foreach($tables as $table)
                                @if($table->order_id == $group['order_id'])
                                    <h5> {{ $table->table_no }} </h5>
                                @endif
                            @endforeach
                        @endif

                        @if(isset($rooms))
                            @foreach($rooms as $room)
                                @if($room->order_id == $group['order_id'])
                                    <h5> {{ $room->room_name }} </h5>
                                @endif
                            @endforeach
                        @endif
                </td>
            </tr>
         @endif
            <tr class="orderlist-body">
                <td >
                    <a href="#" id="{{$group['order_id']}}/1" class="ajax_request">
                        <div class="col-md-12 gray">
                            Haven't Cooked Yet
                            ({{$group['count_start']}})
                        </div>
                    </a>
                </td>
            </tr>
            <tr class="orderlist-body">
                <td >
                    <a href="#" id="{{$group['order_id']}}/2" class="ajax_request">
                        <div class="col-md-12 red">
                            Cooking
                            ({{$group['count_cooking']}})
                        </div>
                    </a>    
                </td>
            </tr>
                
            <tr class="orderlist-body">
                <td>
                    <a href="#" id="{{$group['order_id']}}/3" class="ajax_request">
                        <div class="col-md-12 green">
                            Cooked
                            ({{$group['count_cooked']}})
                        </div>
                    </a>    
                </td>
            </tr>

            <tr class="orderlist-body">
                <td>
                    <a href="#" id="{{$group['order_id']}}/4" class="ajax_request">
                        <div class="col-md-12 blue">
                            Taken By Waiter
                            ({{$group['count_taken']}})
                        </div>
                    </a>    
                </td>
            </tr>

        </table>
    </div>
@endforeach
@endif
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
<script>
    $(document).ready(function() {
        $('.ajax_request').click(function(){
            var id = $(this).attr('id');
            
            order(id);
            return false;
        });
        $('#order_close').click(function(){
            $('#myModalLabel').html("");
            $('#getCode').html("");
        });
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
