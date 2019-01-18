<?php
ini_set('memory_limit', '-1');
?>
@extends('kitchen.kitchen_header')
@section('title','Order View')
@section('content')
<head>
  <style>
  .modal-width {
    width: 300px;
  }
  .modal-header {
    border-radius: 5px 5px 0 0 !important;
  }
  .cancle-modal {
    width: 400px !important;
  }
  .modal-body table td {
    border: 0 !important;
    background: #ecf0f5 !important;
  }
  .modal-body input[type=text] {
    float: right;
    width: 230px !important;
  }
  .modal-body {
    background: #ecf0f5;
  }
  .modal-body table button {
    float: left;
    background: #eb9605;
    border-color: #eb9605;
  }
  .modal-foot {
    padding: 15px;
    font-weight: bolder !important;
    color :white;
    background: #5cb85c;
    border-radius: 0 0 5px 5px !important;
  }
  table tr .remark {
    max-width: 100px;
    word-break: break-all;
  }
  </style>
</head>
    <div id="body">
        <div class="container" id="divAuto" style="cursor: pointer;">
            <div class="row" id="autoDiv">
                @foreach($orders as $orderKey =>$orderValue)
                    @if(isset($orderValue->items) && count($orderValue->items) > 0)
                        <?php
                        $index_key    = [];
                        $index_keys[] = $orderKey;
                        ?>
                        <div class="col-md-12 tbl-container">
                            <div class="table-responsive">
                                <table class="table to-down">
                                    <thead class="header">
                                    <tr>
                                        <td class="tbname">
                                            <h4>
                                                @if($orderKey)
                                                    @if($orderValue->take_id != 0)
                                                        <h4>Take Away </h4>
                                                    @endif
                                                    @if(isset($tables))
                                                        @foreach($tables as $table)
                                                            @if($table->order_id == $orderKey)
                                                                <h4>
                                                                    Table No : {{ $table->table_no }}
                                                                </h4>
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
                                            </h4>
                                        </td>
                                        <!-- <td colspan="3" class="txt-l">
                                            <img src="/uploads/" alt="food">
                                        </td> -->
                                    </tr>
                                    <tr class="tr_header">
                                        <td>Stand No : {{ $orderValue->stand_number }}</td>
                                        <td><span>&nbsp;Quantity&nbsp;</span></td>
                                        <!--  <td>Exception</td> -->
                                        <td><span>&nbsp;Remark&nbsp;</span></td>
                                        <td class="min-width"><span>&nbsp;Add On&nbsp;</span></td>
                                        <!--  <td>StartTime</td> -->
                                        <td class="order-min-width"><span>&nbsp;Order Time&nbsp;</span></td>
                                        <!-- <td>Cooking Duration</td> -->
                                        <td class="order-min-width"><span>&nbsp;Order Status&nbsp;</span></td>
                                        {{--@php--}}
                                        {{--if ($item->status_id == 2) {--}}
                                        {{--$colspan = 1;--}}
                                        {{--}--}}
                                        {{--@endphp--}}
                                        <td colspan="4"><span>&nbsp;Action&nbsp;</span></td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($orderValue->items as $key => $item)
                                        <tr>
                                            <td class="item-list">
                                                <table>
                                                    @if($orderKey)
                                                        <tr>
                                                            <td class="td-min-width">Item Name</td>
                                                            <td>&nbsp;:&nbsp;</td>
                                                            <td class="td-item">{{$item->name}}&nbsp;
                                                                @if($item->has_continent == '1')
                                                                    {{ "($item->continent_name)" }}&nbsp;
                                                                @endif
                                                                @if($item->setmenu_id != '0')
                                                                    {{ "(SetMenu)" }}
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endif
                                                    <tr>
                                                        <td class="td-min-width">Order Type</td>
                                                        <td>&nbsp;:&nbsp;</td>
                                                        <td class="td-item">
                                                            @if($item->order_type_id == '1')
                                                                {{ " Dine in" }}
                                                            @else
                                                                {{ " Parcel"}}
                                                            @endif
                                                        </td>
                                                    </tr>
                                                </table>
                                            <td class="food-type">
                                    <span>
                                        {{ $item->quantity }}
                                    </span>
                                            </td>
                                        <!-- <td>
                                @if ($item->exception !== '')
                                            {{ $item->exception }}
                                        @endif
                                                </td> -->
                                            <td>
                                              @if ($item->remark !== '')
                                                {{ $item->remark }}
                                              @endif
                                            </td>
                                            <td>
                                              @php $extra_array = []; @endphp
                                              @foreach($extra as $ex)
                                                @if($ex->order_detail_id == $item->id && $item->setmenu_id == 0)
                                                  @php $extra_array[] = $ex->food_name @endphp
                                                @elseif ($ex->order_detail_id == $item->order_detail_id && $item->setmenu_id > 0)
                                                  @php $extra_array[] = $ex->food_name @endphp
                                                @endif
                                              @endforeach
                                              <span>{{ implode(',', $extra_array) }}</span>
                                            </td>
                                        <!-- <td>
                                @if($item->status_id =='2')
                                            Start Time : {{ date('h:i:s A', strtotime($item->order_duration)) }}<br />
                                @endif
                                                </td> -->
                                            <td>
                                    <span>
                                        {{ date('h:i:s A', strtotime($item->order_time)) }}
                                    </span><br/>
                                            </td>
                                            <td>
                                                @if ($item->status_id == 1)
                                                    <span>Order</span>
                                                @elseif($item->status_id == 2 && $item->is_ready_food)
                                                    <span>Order</span>
                                                @elseif($item->status_id == 2)
                                                    <span>Cooking</span>
                                                @else
                                                    <span>Ready</span>
                                                @endif
                                            </td>
                                        <!-- <td>
                                    @if($item->status_id =='2')
                                            <input type="hidden" name="order_duration" value="{{ $item->order_duration }}" />
                                          <span class="cooking_duration"></span>
                                        <input type="hidden" name="duration" class="txt_cooking_duration" />
                                    @endif
                                                </td> -->
                                            <td>
                                                <div class="btn-group">
                                                    <div>
                                                        @if ($item->status_id == 1 && !$item->is_ready_food)
                                                            <input type="submit" class="start btn btn-info btn_k" id="{{$item->id}}/{{$item->setmenu_id}}" value="Start Cooking"/>
                                                        @elseif(!empty($item->is_ready_food) && $item->status_id == 1)
                                                            <input type="submit" class="complete btn btn-info btn_k" id="{{$item->id}}/{{$item->setmenu_id}}" value="Food Ready"/>
                                                        @elseif($item->status_id == '3')
                                                            <div>
                                                                <input type="submit" class="taken btn btn-info btn_k" id="{{$item->id}}/{{$item->setmenu_id}}" value="Take"/>
                                                            </div>
                                                        @endif
                                                        @if ($item->status_id == 2)
                                                            <input type="submit" class="complete btn btn-success btn_k" id="{{$item->id}}/{{$item->setmenu_id}}" value="Complete"/>
                                                        @endif
                                                    </div>
                                                    <div>
                                                      <div class="modal fade" id="{{$item->id}}-{{$item->setmenu_id}}modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog cancle-modal" role="document">
                                                          <div class="modal-content">
                                                            <div class="modal-header">
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
                                                              <table class="table">
                                                                <tr>
                                                                  <td>Enter Message</td>
                                                                  <td><input type="text" name="message" class="form-control"></td>
                                                                </tr>
                                                                <tr>
                                                                  <td></td>
                                                                  <td></td>
                                                                </tr>
                                                                <tr>
                                                                  <td>
                                                                    <input type="button" name="submit" value="Save" class="btn btn-info cancel_item" id="{{$item->id}}-{{$item->setmenu_id}}">
                                                                  </td>
                                                                  <td>
                                                                    <button type="button" class="btn" data-dismiss="modal">Close</button>
                                                                  </td>
                                                                </tr>
                                                              </table>
                                                              {!! Form::close() !!}
                                                            </div>
                                                            <div class="modal-foot">
                                                                <span>AcePlus Solutions.,Co Ltd</span>
                                                            </div>
                                                          </div>
                                                        </div>
                                                      </div>
                                                    </div>
                                                </div>
                                            </td>

                                            <td style="border-left: none !important;">
                                                <div class="btn-group">
                                                    <button class="btn btn-success" id="{{ $item->order_detail_id }}" onclick="print_waiter('{{$item->order_detail_id}}')" data-toggle="modal" data-id="{{$item->order_detail_id}}" data-target="#printWaiter">Print (Waiter)</button>
                                                </div>
                                            </td>
                                            <td style="border-left: none !important;">
                                                @php
                                                    if (isset($tables)) {
                                                        $id = $table->table_id;
                                                    } elseif (isset($room)) {
                                                        $id = $room->rome_id;
                                                    }
                                                @endphp
                                                @if (empty($item->is_ready_food))
                                                    <div class="btn-group">
                                                        <button class="btn btn-success" id='{{ $item->id }}' onclick="print_chief('{{$item->id}}')" data-toggle="modal" data-id="{{$item->id}}" data-target="#printModal">Print (Chef)</button>
                                                    </div>
                                                @endif
                                            </td>

                                            @if ($item->status_id == 1)
                                                <td style="border-left: none !important;">
                                                    <div class="btn-group">
                                                        <input type="button" class="cancel btn btn-danger btn_k" id="{{$item->id}}-{{$item->setmenu_id}}" data-toggle="modal" data-target="#{{$item->id}}-{{$item->setmenu_id}}modal" value="Cancel">
                                                    </div>
                                                </td>
                                            @else
                                                <td style="border-left: none !important;"></td>
                                            @endif
                                            {{-- @if ($item->status_id == 1)
                                                <td style="border-left: none !important;">
                                                    <div class="btn-group">
                                                        <button class="btn btn-success" id="{{ $item->order_detail_id }}" onclick="print_waiter('{{$item->order_detail_id}}')" data-toggle="modal" data-id="{{$item->order_detail_id}}" data-target="#printWaiter">Print For Waiter</button>
                                                    </div>
                                                </td>
                                                <td style="border-left: none !important;">
                                                    @php
                                                        if (isset($table)) {
                                                            $id = $table->table_id;
                                                        } elseif (isset($room)) {
                                                            $id = $room->room_id;
                                                        }
                                                    @endphp
                                                    @if (empty($item->is_ready_food))
                                                        <div class="btn-group">
                                                            <button class="btn btn-success" id='{{ $item->id }}' onclick="print_chief('{{$item->id}}')" data-toggle="modal" data-id="{{$item->id}}" data-target="#printModal">Print For Chef</button>
                                                        </div>
                                                    @endif
                                                </td>
                                            @else
                                                <td style="border-left: none !important;"></td>
                                                <td style="border-left: none !important;"></td>
                                            @endif --}}
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
    <!-- for modal -->
    @foreach($orders as $order)
        @include('kitchen.KitchenPrintForChief')
    @endforeach

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
                                url: '/Kitchen/getStart/ajaxRequest/' + itemID,
                                success: function (Response) {
                                    console.log(Response);
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


            $('#divAuto').on('click', '.taken', function(e){
                var itemID      = $(this).attr('id');
                $(document).ready(function  (){
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
                                url: '/Kitchen/taken/ajaxRequest/' + itemID,
                                success: function (Response) {

                                    console.log(Response);
                                    //Socket Emit
                                    var socketKey        = "taken_by";
                                    var socketValue      = "taken_by";
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
            //Taken order socket
            var taken_by_waiter  = 'take';
            socketOn(taken_by_waiter,url,div);

            noti();

            function noti(){
                var socket  = io.connect( 'http://'+window.location.hostname  +':' + 3334);
                socket.on( invoice_update, function( data ) {
                    console.log('zinthutun');
                });
            }
        });
    </script>
    <script>

        function printElement(e) {
            var ifr = document.createElement('iframe');
            ifr.style='height: auto; width: 0px; position: absolute';

            document.body.appendChild(ifr);
            $(e).append('<style rel="stylesheet" type="text/css" media="print">.modal-body {text-align:center !important;font-size:15px;font-weight:bolder;width:300px;margin:auto !important;}table {width:300px !important;}table .right {float:right !important;}table td {padding: 8px !important}</style>');
            $(e).clone().appendTo(ifr.contentDocument.body);
            ifr.contentWindow.print();

            ifr.parentElement.removeChild(ifr);
        }

        function print_click(clicked_id)
        {
            var clickID     = clicked_id;
            var printID     = clickID + "-print-table";
            var test        = document.getElementById(printID);
            printElement(document.getElementById(printID));
        }

        function print_chief(order) {
            var id      = order;
            var modal   = id + '-print-chef';
            $('#' + modal).modal('show');
        }

        function print_waiter(order) {

            var id      = order;
            var modal   = id + '-print-waiter';
            $('#' + modal).modal('show');
        }
    </script>
@endsection
<?php
ini_set('memory_limit', '-1');
?>
