@extends('Backend.layouts.kitchen.master')
@section('title','Order View')
@section('content')
    {{--title--}}
    <div class="content-wrapper">
   
       <div class="box-header">
        <div class="row">
            <div id="body">
                <div class="container">
                    <div class="row" id="autoDiv">
                    @foreach($product as $orderKey=>$p)
                        <div class="col-md-12 tbl-container">
                            <div class="table-responsive">	
                                <table class="table to-down">
                                    <thead class="header">
                                        <tr>
                                            <td class="tdname">
                                                <h4>{{$p['item_name']}}
                                                    @if ($p['has_continent'] == 1)
                                                    ( {{ $p['continent']}} )
                                                    @endif
                                                </h4>
                                            </td>
                                            <td colspan="3" class="txt-l">
                                                <img src="/uploads/{{$p['item_image']}}" alt="food">
                                            </td>
                                        </tr>
                                        <tr class="tr_header">
                                            <td>Table/Room Name/Take Away</td>
                                            <td>Quantity</td>
                                            <td>Exception</td>
                                            <td>Remark</td>
                                            <td>Add On</td>
                                            <td>StartTime</td>
                                            <td>Order Duration</td>
                                            <td>Cooking Duration</td>
                                            <td>Order Status</td>
                                            <td>Cancel</td>
                                        </tr>
                                    </thead>
                                    <tbody class="body">
                                    @if($p['product_order'] != null)
                                        @foreach($p['product_order'] as $item)
                                            @if($p['item_id'] == $item->id)
                                        <tr class="tr-row" data-ordertime = "{{$item->order_time}}">
                                            <td class="tr_right">
                                                @if($item->take_id == 1)
                                                    <h4>Take Away</h4>
                                                @endif
                                                @if(isset($tables) && count($tables) >0 )
                                                    @foreach($tables as $table)
                                                        @if($table->order_id == $item->order_id)
                                                            <h4>{{$table->table_no}}</h4>
                                                        @endif
                                                    @endforeach
                                                @endif

                                                @if(isset($rooms) && count($rooms) > 0)
                                                    @foreach($rooms as $room)
                                                        @if($room->order_id == $item->order_id)
                                                            <h4>{{ $room->room_name }}</h4>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </td>
                                            <td class="tr_right">{{ $item->quantity }}</td>
                                            <td class="tr_right">{{ $item->exception }}</td>
                                            <td class="tr_right">{{ $item->remark }}</td>
                                            <td class="tr_right">
                                                @foreach($extra as $ex)
                                                    @if($ex->order_detail_id == $item->order_detail_id)
                                                        {{ $ex->food_name }},
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td class="td-row tr_right" data-ordertime = "{{ $item->order_time}}">
                                                {{ date('h:i:s A', strtotime($item->order_time)) }}
                                            </td>
                                            <td class="tr_right">
                                                <!-- @if($item->status_id == '1')
                                                    <span class="duration"></span>
                                                    <input type="hidden" name="duration" class="txt_duration"/>
                                                @endif -->
                                                @if($item->status_id =='2')
                                                    {{ date('h:i:s A', strtotime($item->order_duration)) }}
                                                @endif
                                            </td>
                                            <td class="tr_right">
                                                @if($item->status_id =='2')
                                                    <input type="hidden" name="order_duration" value="{{ $item->order_duration }}"/>
                                                    <span class="cooking_duration"></span>
                                                    <input type="hidden" name="duration" class="txt_cooking_duration"/>
                                                @endif
                                            </td>
                                            <td class="tr_right">
                                                @if($item->status_id == '1')
                                                    <input type="submit" class="start start_duration_item btn_k" id="{{$item->order_detail_id}}" name="start" value="Cooking">
                                                @endif
                                                @if($item->status_id =='2')
                                                    <input type="submit" class="complete complete_duration_item btn_k" id="{{$item->order_detail_id}}" name="complete" value="Cooked">
                                                @endif
                                            </td>

                                            @if($item->status_id == '1')
                                            <td class="tr_right">
                                                <input type="button" class="cancel btn_k" id="{{$item->order_detail_id}}-{{$item->setmenu_id}}" name="cancel" value="Cancel" data-toggle="modal" data-target="#{{$item->order_detail_id}}-{{$item->setmenu_id}}modal">
                                                <div class="modal fade" id="{{$item->order_detail_id}}-{{$item->setmenu_id}}modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content pop-up-content">
                                                            <div class="modal-header pop-up-header">
                                                                <h4 class="modal-title" id="myModalLabel">Reason of Cancellation</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                {!! Form::open(array('url' => 'Kitchen/getCancelID/ProductView', 'class'=> 'form-horizontal','onsubmit'=>'return false;', 'id' => $item->order_detail_id . "-" . $item->setmenu_id . "form")) !!}

                                                                @if(isset($item->setmenu_id) && $item->setmenu_id != 0)
                                                                    <input type="hidden" name="order_details_id" value="{{$item->order_detail_id}}">
                                                                @else
                                                                    <input type="hidden" name="order_details_id" value="{{$item->order_detail_id}}">
                                                                @endif
                                                                <input type="hidden" name="setmenu_id" value="{{$item->setmenu_id}}">

                                                                <div class="row">
                                                                    <label class="col-sm-3 control-label"><b>Enter Message</b></label>
                                                                    <div class="col-sm-7">
                                                                        <input type="text" name="message" class="form-control">
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-sm-offset-3 col-sm-8 pop-up-linespace">
                                                                        <button type="button" name="submit" class="btn btn-primary pop-up-button cancel_product" id="{{$item->order_detail_id}}-{{$item->setmenu_id}}">Save</button>
                                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                    </div>
                                                                </div>
                                                                {!! Form::close() !!}
                                                            </div>
                                                            <div class="modal-footer pop-up-footer">
                                                                <span>AcePlus Solutions.,Co Ltd</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Modal -->
                                            </td>
                                            @endif 
                                                                                
                                        </tr>
                                        @endif
                                        @endforeach    
                                    @endif


                                    <!-- For Set Menu -->
                                    @if($p['setmenu'] != null)
                                        @foreach($p['setmenu'] as $setmenu)
                                            @if($p['item_id'] == $setmenu->item_id)
                                                <tr class="tr-row"  data-ordertime = "{{$setmenu->order_time}}">
                                                    <td>
                                                        @if($setmenu->take_id == 1)
                                                            <h4>Take Away</h4>
                                                        @endif
                                                        @if(isset($tables) && count($tables) >0 )
                                                            @foreach($tables as $table)
                                                                @if($table->order_id == $setmenu->order_id)
                                                                    <h4>{{$table->table_no}}</h4>
                                                                @endif
                                                            @endforeach
                                                        @endif

                                                        @if(isset($rooms) && count($rooms) > 0)
                                                            @foreach($rooms as $room)
                                                                @if($room->order_id == $setmenu->order_id)
                                                                    <h4>{{ $room->room_name }}</h4>
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    </td>
                                                    <td>{{ $setmenu->quantity }}</td>
                                                    <td>{{ $setmenu->exception }}</td>
                                                    <td>{{ $setmenu->remark }}</td>
                                                    <td>
                                                        @foreach($extra as $ex)
                                                            @if($ex->order_detail_id == $setmenu->order_detail_id)
                                                                {{ $ex->food_name }},
                                                            @endif
                                                        @endforeach
                                                    </td>
                                                    <td class="td-row" data-ordertime = "{{ $setmenu->order_time}}">
                                                        {{ date('h:i:s A', strtotime($setmenu->order_time)) }}
                                                    </td>
                                                    <td >
                                                        @if($setmenu->status_id =='2')
                                                            {{ date('h:i:s A', strtotime($setmenu->order_duration)) }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($setmenu->status_id =='2')
                                                            <input type="hidden" name="order_duration" value="{{ $setmenu->order_duration }}"/>
                                                            <span class="cooking_duration"></span>
                                                            <input type="hidden" name="duration" class="txt_cooking_duration"/>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($setmenu->status_id == '1')
                                                            <input type="submit" class="start start_duration_setmenu btn_k" id="{{$setmenu->id}}" name="start" value="Cooking">
                                                        @endif
                                                        @if($setmenu->status_id =='2')
                                                            <input type="submit" class="complete complete_duration_setmenu btn_k" id="{{$setmenu->id}}" name="complete" value="Cooked">
                                                        @endif
                                                    </td>  
                                                    @if($setmenu->status_id == '1')
                                                    <td>
                                                        <input type="button" class="cancel btn_k" id="{{$setmenu->order_detail_id}}-{{$setmenu->setmenu_id}}" name="cancel" value="Cancel" data-toggle="modal" data-target="#{{$setmenu->order_detail_id}}-{{$setmenu->setmenu_id}}modal">
                                                        <div class="modal fade" id="{{$setmenu->order_detail_id}}-{{$setmenu->setmenu_id}}modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content pop-up-content">
                                                                    <div class="modal-header pop-up-header">
                                                                        <h4 class="modal-title" id="myModalLabel">Reason of Cancellation</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        {!! Form::open(array('url' => 'Kitchen/getCancelID/ProductView', 'class'=> 'form-horizontal','onsubmit'=>'return false;', 'id' => $setmenu->order_detail_id . "-" . $setmenu->setmenu_id . "form")) !!}

                                                                        @if(isset($setmenu->setmenu_id) && $setmenu->setmenu_id != 0)
                                                                            <input type="hidden" name="order_details_id" value="{{$setmenu->order_detail_id}}">
                                                                        @else
                                                                            <input type="hidden" name="order_details_id" value="{{$setmenu->order_detail_id}}">
                                                                        @endif
                                                                        <input type="hidden" name="setmenu_id" value="{{$setmenu->setmenu_id}}">

                                                                        <div class="row">
                                                                            <label class="col-sm-3 control-label"><b>Enter Message</b></label>
                                                                            <div class="col-sm-7">
                                                                                <input type="text" name="message" class="form-control">
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-sm-offset-3 col-sm-8 pop-up-linespace">
                                                                                <input type="button" name="submit" value="Save" class="btn btn-primary pop-up-button cancel_product">
                                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                            </div>
                                                                        </div>
                                                                        {!! Form::close() !!}
                                                                    </div>
                                                                    <div class="modal-footer pop-up-footer">
                                                                        <span>AcePlus Solutions.,Co Ltd</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- Modal -->
                                                    </td>
                                                    @endif                          
                                                </tr>    
                                            @endif
                                        @endforeach    
                                    @endif 
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <script type="text/javascript">
        $(document).ready(function(){
            var myVar = setInterval(myTimer ,1000);
            function myTimer() {
                $("table tr.tr-row").each(function () {
                   var currentTime = moment();                    

                    var orderTime = moment($(this).data("ordertime"), 'YYYY-MM-DD hh:mm:ss tt');

                    var diff = currentTime.diff(orderTime);
                    var d = moment.duration(diff);
                    var s = Math.floor(d.asHours()) + moment.utc(diff).format(":mm:ss");
                   
                    $(this).find(".duration").text(s);
                    $(this).find(".txt_duration").val(s);

                    var orderDuration = $(this).find("[name=order_duration]").val();
                    var duration      = moment(orderDuration,'YYYY-MM-DD hh:mm:ss tt');
                    var result        = currentTime.diff(duration);
                    var time          = moment.duration(result);
                    var cooking_time  = Math.floor(d.asHours()) + moment.utc(result).format(":mm:ss");
                    
                    $(this).find(".cooking_duration").text( cooking_time );
                    $(this).find(".txt_cooking_duration").val( cooking_time );
                });
            };

            $('#viewBy').change(function(e){
                var url = 'getTableView?view='+ $(this).value();
            })
            $('#autoDiv').on('click', '.start_duration_item',function(e){
                var itemID      = $(this).attr('id');

                $(document).ready(function  (){
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
                            $.ajax({
                                type: 'GET',
                                url: '/Kitchen/productView/CookingItem/' + itemID,
                                success: function (Response) {
                                    var returnResp        = Response.message;
                                    if (returnResp == 'success') {
                                        //Socket Emit
                                        var socketKey        = "start_cooking";
                                        var socketValue      = "start_cooking";
                                        socketEmit(socketKey,socketValue);
                                        swal.close();
                                    }
                                }
                            });
                        };
                    });
                });
            });
            $('#autoDiv').on('click','.complete_duration_item', function (e) {
                // window.location.href = "/Kitchen/productView/CookedItem/" + $(this).attr('id');
                var itemID      = $(this).attr('id');
                $(document).ready(function(){
                    swal({
                        title: "Are you sure?",
                        text: "You will not be able to recover this item!",
                        type: "success",
                        showCancelButton: true,
                        confirmButtonColor: "#86CCEB",
                        confirmButtonText: "Confirm",
                        closeOnConfirm: false
                    }, function(isConfirm){
                        if (isConfirm) {
                            $.ajax({
                                type: 'GET',
                                url: '/Kitchen/productView/CookedItem/' + itemID,
                                success: function (Response) {
                                    var returnResp        = Response.message;
                                    if (returnResp == 'success') {
                                        //Socket Emit
                                        var socketKey        = "cooking_complete";
                                        var socketValue      = "cooking_complete";
                                        socketEmit(socketKey,socketValue);
                                        swal.close();
                                    }
                                }
                            });
                        };
                    });
                });
            });
            $('#autoDiv').on('click','.start_duration_setmenu',function(e){
                var itemID      = $(this).attr('id');
                swal({
                    title: "Are you sure?",
                    text: "You will not be able to recover this item!",
                    type: "success",
                    showCancelButton: true,
                    confirmButtonColor: "#86CCEB",
                    confirmButtonText: "Confirm",
                    closeOnConfirm: false
                }, function(isConfirm){
                    if (isConfirm) {
                        $.ajax({
                            type: 'GET',
                            url: '/Kitchen/productView/CookingSetMenuItem/' + itemID,
                            success: function (Response) {
                                var returnResp        = Response.message;
                                if (returnResp == 'success') {
                                    var socket      = io.connect( 'http://'+window.location.hostname+':3333' );
                                    socket.emit('start_cooking', 'start_cooking');
                                    swal.close();
                                }
                            }
                        });
                    };
                });
            });
            $('#autoDiv').on('click','.complete_duration_setmenu',function(e){
                var itemID      = $(this).attr('id');
                swal({
                    title: "Are you sure?",
                    text: "You will not be able to recover this item!",
                    type: "success",
                    showCancelButton: true,
                    confirmButtonColor: "#86CCEB",
                    confirmButtonText: "Confirm",
                    closeOnConfirm: false
                }, function(isConfirm){
                    if (isConfirm) {
                        $.ajax({
                            type: 'GET',
                            url: '/Kitchen/productView/CookedSetMenuItem/' + itemID,
                            success: function (Response) {
                                var returnResp        = Response.message;
                                if (returnResp == 'success') {
                                    var socket = io.connect( 'http://'+window.location.hostname+':3333' );
                                    socket.emit('cooking_complete','cooking_complete');
                                    swal.close();
                                }
                            }
                        });
                    };
                });
            });


            $('#autoDiv').on('click', '.cancel_product',function (e) {
                var formID      = $(this).closest("form").attr('id');
                var data        = $('#' + formID).serialize();
                console.log(data);
                var modalID     = $(this).attr('id') + 'modal';
                $.ajax({
                    type: 'POST',
                    url: '/Kitchen/getCancelID/ProductView',
                    data: data,
                    dataType: "json",
                    success: function (Response) {
                        var returnResp        = Response.message;
                        var order_id          = Response.order_id;
                        if (returnResp == 'success') {
                            $("#" + modalID).modal("hide");
                            $('body').removeClass('modal-open');
                            $('.modal-backdrop').remove();
                            var port   = getSocketPort();
                            var socket = io.connect( 'http://'+window.location.hostname+':' + port );
                            socket.emit('order_cancel',{
                                'order_cancel' : order_id
                            });
                        }
                    },
                    error: function(Response) {
                        alert('hihi');
                    }
                });

            });
           
        });
    </script>

    <script>
        $(document).ready(function(){
            var url     = "/Kitchen/kitchen/ajaxRequestProduct";//Json Callback Url
            var div     = "autoDiv";//Put div id inside html response
            //Order Cancel Socket
            var invoice_update      = "invoice_update";
            socketOn(invoice_update,url,div);

            //Order start Cooking Socket
            var cooked      = "cooked";
            socketOn(cooked,url,div);

            //Order Cancel Socket
            var order_remove      = "order_remove";
            socketOn(order_remove,url,div);

            //Order Cooking Done
            var cooking_done      = "cooking_done";
            socketOn(cooking_done,url,div);

            //Table Transfer
            var tableChange      = "tableChange";
            socketOn(tableChange,url,div);

            //Order Edit
            var edit      = "edit";
            socketOn(edit,url,div);
        });
    </script>
@endsection

