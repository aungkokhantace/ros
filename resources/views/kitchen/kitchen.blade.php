@extends('Backend.layouts.kitchen.master')
@section('title','Order View')
@section('content')
    {{--title--}}
  
      {{--Order Listing Table--}}
        <div class="container" id="divAuto" style="cursor: pointer;">
            <div class="row">
                <div id="body" class="order-pg">
                    <div class="row" id="autoDiv2">
                    @foreach($orders as $orderKey=>$orderValue)
                        @if(isset($orderValue->items) && count($orderValue->items) > 0)
                        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 mgr-b20">
                            <h3 class="pricing-title @if (count($orderValue->items) > 1) {{ 'down-arrow' }} @endif ">Order No. <span>{{ $orderValue->id }}</span></h3>
                            <div class="table-wrapper order-tb">
                                <div class="table-box table-responsive">
                                    <table class="table">
                                    @foreach($orderValue->items as $key => $item)
                                        <tr>
                                            <td class="table-type ver-top">
                                                @if($orderKey)
                                                    @if($orderValue->take_id != 0)
                                                    <h4>Take Away </h4>
                                                    @endif

                                                    @if(isset($tables))
                                                        @foreach($tables as $table)
                                                            @if($table->order_id == $orderKey)
                                                                <h4> {{ $table->table_no }} </h4>
                                                            @endif
                                                        @endforeach
                                                    @endif

                                                    @if(isset($rooms))
                                                        @foreach($rooms as $room)
                                                            @if($room->order_id == $orderKey)
                                                                <h4> {{ $room->room_name }} </h4>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                @endif
                                            </td>
                                            <td rowspan="2"><img src="/uploads/{{ $item->image }}" alt="food"></td> 
                                        </tr>
                                        <tr>
                                            <td class="food-type">{{ $item->name }} 
                                            @if($item->has_continent == '1')
                                                {{ "($item->continent_name)" }}
                                            @endif
                                            <br>
                                            @if($item->setmenu_id != '0')
                                                {{ "(SetMenu)" }}
                                            @endif
                                            </td>
                                        </tr>
                                        <tr class="pad-t20">
                                            <td class="ver-top">Order Type : 
                                            @if($item->order_type_id == '1')
                                                {{ " Dine in" }}
                                            @else
                                                {{ " Parcel"}}
                                            @endif
                                            </td>
                                            <td rowspan="3" class="ver-top">
                                            @if ($item->status_id == 1)
                                                <input type="submit" class="start btn_k" id="{{$item->id}}/{{$item->setmenu_id}}" value="Cooking" /><br><br>
                                                <input type="button" class="cancel btn_k" id="{{$item->id}}-{{$item->setmenu_id}}" data-toggle="modal" data-target="#{{$item->id}}-{{$item->setmenu_id}}modal" value="Cancel">
                                            @else
                                                <input type="submit" class="complete btn_k" id="{{$item->id}}/{{$item->setmenu_id}}" value="Cooked" /><br><br>
                                            @endif
                                            
                                                <div class="modal fade" id="{{$item->id}}-{{$item->setmenu_id}}modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content pop-up-content">
                                                            <div class="modal-header pop-up-header">
                                                                <h4 class="modal-title" id="myModalLabel">Reason of Cancellation</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                            {!! Form::open(array('url' => 'Kitchen/getCancelID/TableView', 'class'=> 'form-horizontal', 'id' => $item->id)) !!}
                                                                    @if ($item->setmenu_id != 0)
                                                                    <input type="hidden" name="order_details_id" value="{{$item->order_detail_id}}" />
                                                                    @else
                                                                    <input type="hidden" name="order_details_id" value="{{$item->id}}" />
                                                                    @endif
                                                                <input type="hidden" name="setmenu_id" value="{{$item->setmenu_id}}">

                                                                <div class="row">
                                                                    <label class="col-sm-3 control-label text-info"><b>Enter Message</b></label>
                                                                    <div class="col-sm-7">
                                                                        <input type="text" name="message" class="form-control">
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-sm-offset-3 col-sm-8 pop-up-linespace">
                                                                        <input type="button" name="submit" value="Save" class="btn btn-primary pop-up-button cancel_item" id="{{$item->id}}-{{$item->setmenu_id}}">
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
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Quantity : {{ $item->quantity }}</td>
                                        </tr>
                                        @if ($item->exception !== '')
                                        <tr>
                                            <td>Exception : {{ $item->exception }}</td>
                                        </tr>
                                        @endif

                                        @if ($item->remark !== '')
                                        <tr>
                                            <td>Remark : {{ $item->remark }}</td>
                                        </tr>
                                        @endif

                                        @foreach($extra as $ex)
                                            @if($ex->order_detail_id == $item->id && $item->setmenu_id == 0)
                                            <tr>
                                                <td>Add on :  {{ $ex->food_name }}</td>
                                            </tr>
                                            @elseif ($ex->order_detail_id == $item->order_detail_id && $item->setmenu_id > 0)
                                            <tr>
                                                <td>Add on : {{ $ex->food_name }}</td>
                                            </tr>
                                            @endif
                                        @endforeach

                                        <tr class="tr-row">
                                            <td>
                                                <div class="product-name tr-row" data-ordertime="{{ $item->order_time }}">
                                                    OrderTime : {{ date('h:i:s A', strtotime($item->order_time)) }}<br />
                                                    <!-- @if($item->status_id == '1')
                                                        <div>
                                                            CookingTime : <span class="duration"></span>
                                                            <input type="hidden" name="duration" class="txt_duration" />
                                                        </div>
                                                    @endif -->

                                                    @if($item->status_id =='2')
                                                        Start Time : {{ date('h:i:s A', strtotime($item->order_duration)) }}<br />
                                                    @endif

                                                    @if($item->status_id =='2')
                                                        <input type="hidden" name="order_duration" value="{{ $item->order_duration }}" />
                                                        CookingTime : <span class="cooking_duration"></span>
                                                                    
                                                        <input type="hidden" name="duration" class="txt_cooking_duration" />
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>

                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td> <hr></td>
                                            <td><hr></td>
                                        </tr>

                                    @endforeach
                                    </table><!-- table -->
                                    
                                </div><!-- table-box -->
                            </div><!-- table-wrapper -->
                        </div><!-- col-md-4 -->
                        @endif   
                    @endforeach
                    </div>
                </div> 
            </div><!-- row -->

        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {

           setInterval(myTimer,1000);

            function myTimer() {
                $(".tr-row").each(function () {
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
                    //console.log(cooking_time);

                    $(this).find(".cooking_duration").text( cooking_time );
                    $(this).find(".txt_cooking_duration").val( cooking_time );

                });
            };

            $('#divAuto').on('click', '.start', function(e){
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
                                url: '/Kitchen/getStart/ajaxRequest/' + itemID,
                                success: function (Response) {
                                    //Socket Emit
                                    var socketKey        = "start_cooking";
                                    var socketValue      = "start_cooking";
                                    socketEmit(socketKey,socketValue);
                                    swal.close();
                                }
                            });
                        };
                    });
                });
            });
            
            
        
            $('#divAuto').on('click', '.complete',function (e) {
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
                                url: '/Kitchen/getCompleteID/' + itemID,
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

            $('#divAuto').on('click', '.cancel_item',function (e) {
                var formID      = $(this).closest("form").attr('id');
                var data        = $('#' + formID).serialize();
                var modalID     = $(this).attr('id') + 'modal';
                $(document).ready(function(){
                    $.ajax({
                        type: 'POST',
                        url: '/Kitchen/getCancelID/TableView',
                        data: data,
                        dataType: "json",
                        success: function (Response) {
                            var returnResp        = Response.message;
                            var order_id   = Response.order_id;
                            if (returnResp == 'success') {
                                console.log(order_id);
                                $("#" + modalID).modal("hide");
                                $('body').removeClass('modal-open');
                                $('.modal-backdrop').remove();
                                //Socket Emit
                                var socketKey        = "order_cancel";
                                var socketValue      = {order_cancel : order_id};
                                socketEmit(socketKey,socketValue);
                            }
                        }
                    });
                });

            });

            $('#viewBy').change(function (e) {
                var url = 'getTableView?view=' + $(this).value();
            });

        });
    </script>

    <script>
        $(document).ready(function(){
            var url     = "/Kitchen/kitchen/ajaxRequest";//Json Callback Url
            var div     = "divAuto";//Put div id inside html response
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

            //Invoice Payment Socket
            var payment_done      = "payment_done";
            socketOn(payment_done,url,div);

            //Table Transfer
            var tableChange      = "tableChange";
            socketOn(tableChange,url,div);

            //Order Eidt
            var edit      = "edit";
            socketOn(edit,url,div);
        });
    </script>
@endsection

