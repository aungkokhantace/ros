@extends('kitchen.kitchen_header')
@section('title','Order View')
@section('content')
<head>
  <style>
  .modal-header {
    border-radius: 5px 5px 0 0 !important;
  }
  .modal-header h4 {
    color: white;
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
    width: 120px;
    background: #eb9605;
    border-color: #eb9605;
    font-weight: bolder;
    color: white;
    padding-top: 10px !important;
  }
  .modal-body table input[type=button] {
    width: 120px !important;
    font-weight: bolder;
    padding-top: 10px !important;
  }
  .modal-foot {
    padding: 15px;
    font-weight: bolder !important;
    color :white;
    background: #5cb85c;
    border-radius: 0 0 5px 5px !important;
  }
  </style>
</head>
    <div id="body">
        <div class="container product">
            <div class="row" id="autoDiv">
                @foreach($product as $orderKey => $p)
                    <div class="col-md-12 tbl-container">
                        <div class="table-responsive">
                            <table class="table to-down">
                                <thead class="header">
                                <tr>
                                    <td class="tdname">
                                        <h4>{{$p['item_name']}}
                                            @if ($p['has_continent'] == 1 && $p['continent'] != null)
                                                ( {{ $p['continent']}} )
                                            @endif
                                        </h4>
                                    </td>
                                    <!-- <td colspan="3" class="txt-l">
                                        <img src="/uploads/{{$p['item_image']}}" alt="food">
                                    </td> -->
                                </tr>
                                <tr class="tr_header">
                                    <td>Table/Room Name/Take Away</td>
                                    <td>Quantity</td>
                                    <!-- <td>Exception</td> -->
                                    <td>Remark</td>
                                    <td class="min-width">Add On</td>
                                    <!-- <td>StartTime</td> -->
                                    <td class="order-min-width">Order Time</td>
                                    <!--  <td>Cooking Duration</td> -->
                                    <td class="order-min-width">Order Status</td>
                                    <td colspan="2">Action</td>
                                </tr>
                                </thead>
                                <tbody class="body">
                                @if(count($p['product_order']) != 0)
                                    @foreach($p['product_order'] as $item)
                                        @if($p['item_id'] == $item->id)
                                            <tr class="tr-row" data-ordertime = "{{$item->order_time}}">
                                                <td class="tr_right">
                                                    @if($item->take_id == 1)
                                                        Take Away
                                                    @endif
                                                    @if(isset($tables) && count($tables) >0 )
                                                        @foreach($tables as $table)
                                                            @if($table->order_id == $item->order_id)
                                                                {{$table->table_no}}&nbsp;[ Stand No : {{ $item->stand_number }}]
                                                            @endif
                                                        @endforeach
                                                    @endif

                                                    @if(isset($rooms) && count($rooms) > 0)
                                                        @foreach($rooms as $room)
                                                            @if($room->order_id == $item->order_id)
                                                                {{ $room->room_name }}
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </td>
                                                <td class="tr_right">{{ $item->quantity }}</td>
                                            <!-- <td class="tr_right">{{ $item->exception }}</td> -->
                                                <td class="tr_right">
                                                  {{ $item->remark }}
                                                </td>
                                                <td class="tr_right">
                                                  @php $extra_array = []; @endphp
                                                  @foreach($extra as $ex)
                                                    @if($ex->order_detail_id == $item->order_detail_id)
                                                      @php $extra_array[] = $ex->food_name @endphp
                                                    @endif
                                                  @endforeach
                                                  <span>{{ implode(',', $extra_array) }}</span>
                                                </td>
                                                <td class="td-row tr_right" data-ordertime = "{{ $item->order_time}}">
                                                    {{ date('h:i:s A', strtotime($item->order_time)) }}
                                                </td>
                                                <td>
                                                    @if($item->status_id == '1')
                                                        Order

                                                    @endif
                                                    @if($item->status_id =='2')
                                                        Cooking
                                                    @elseif($item->status_id =='3')
                                                        Ready
                                                    @endif

                                                </td>

                                                <td class="tr_right" style="border-right: none !important;">
                                                    @if($item->status_id == '1' && !$item->is_ready_food)
                                                        <input type="submit" class="start start_duration_item btn_k btn btn-info" id="{{$item->order_detail_id}}" name="start" value="စခ်က္မယ္">
                                                    @endif
                                                    @if($item->status_id == '1' && $item->is_ready_food)
                                                        <input type="submit" class="taken complete_taken_item btn_k btn btn-info" id="{{$item->order_detail_id}}" name="start" value="ဟင္းပြဲရၿပီ">
                                                    @endif

                                                    @if($item->status_id =='2')
                                                        <input type="submit" class="taken complete_taken_item btn_k btn btn-success" id="{{$item->order_detail_id}}" name="complete" value="ၿပီးၿပီ">
                                                    @endif
                                                    {{--
                                                    @if($item->status_id == '3')
                                                        <input type="submit" class="taken complete_taken_item btn_k btn btn-info" id="{{$item->order_detail_id}}" value="ယူမယ္"/>

                                                    @endif
                                                    --}}
                                                </td>

                                                @if($item->status_id == '1')
                                                    <td class="tr_right" style="border-left: none !important;">
                                                        <input type="button" class="cancel btn_k btn btn-danger" id="{{$item->order_detail_id}}-{{$item->setmenu_id}}" name="cancel" value="မလုပ္ဘူး" data-toggle="modal" data-target="#{{$item->order_detail_id}}-{{$item->setmenu_id}}modal">
                                                        <div class="modal fade" id="{{$item->order_detail_id}}-{{$item->setmenu_id}}modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                          <div class="modal-dialog cancle-modal" role="document">
                                                            <div class="modal-content">
                                                              <div class="modal-header">
                                                                  <h4 class="modal-title" id="myModalLabel">ဖ်က္မယ့္အေၾကာင္းရင္း</h4>
                                                              </div>
                                                              <div class="modal-body">
                                                                {!! Form::open(array('url' => 'Kitchen/getCancelID/ProductView', 'class'=> 'form-horizontal','onsubmit'=>'return false;', 'id' => $item->order_detail_id . "-" . $item->setmenu_id . "form")) !!}

                                                                @if(isset($item->setmenu_id) && $item->setmenu_id != 0)
                                                                    <input type="hidden" name="order_details_id" value="{{$item->order_detail_id}}">
                                                                @else
                                                                    <input type="hidden" name="order_details_id" value="{{$item->order_detail_id}}">
                                                                @endif
                                                                <input type="hidden" name="setmenu_id" value="{{$item->setmenu_id}}">
                                                                <table class="table">
                                                                  <tr>
                                                                    <td>စာရိုက္ပါ</td>
                                                                    <td><input type="text" name="message" class="form-control"></td>
                                                                  </tr>
                                                                  <tr>
                                                                    <td></td>
                                                                    <td></td>
                                                                  </tr>
                                                                  <tr>
                                                                    <td>
                                                                      <input type="button" name="submit" value="သိမ္းမယ္" class="btn btn-info cancel_product" id="{{$item->order_detail_id}}-{{$item->setmenu_id}}">
                                                                    </td>
                                                                    <td>
                                                                      <button type="button" class="btn" data-dismiss="modal">ပိတ္မယ္</button>
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
                                                        <!-- Modal -->
                                                    </td>
                                                @elseif($item->status_id != '1')
                                                    <td style="border-left: none !important;"></td>
                                                @endif
                                            </tr>
                                        @endif
                                    @endforeach
                                @endif

                                <!-- For Set Menu -->
                                @if(count($p['setmenu']) != 0)
                                    @foreach($p['setmenu'] as $setmenu)
                                        @if($p['item_id'] == $setmenu->item_id)
                                            <tr class="tr-row"  data-ordertime = "{{$setmenu->order_time}}">
                                                <td>
                                                    @if($setmenu->take_id == 1)
                                                        Take Away
                                                    @endif
                                                    @if(isset($tables) && count($tables) >0 )
                                                        @foreach($tables as $table)
                                                            @if($table->order_id == $setmenu->order_id)
                                                                {{$table->table_no}}
                                                            @endif
                                                        @endforeach
                                                    @endif

                                                    @if(isset($rooms) && count($rooms) > 0)
                                                        @foreach($rooms as $room)
                                                            @if($room->order_id == $setmenu->order_id)
                                                                {{ $room->room_name }}
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </td>
                                                <td>{{ $setmenu->quantity }}</td>
                                            <!-- <td>{{ $setmenu->exception }}</td> -->
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
                                                <td>
                                                    @if($setmenu->status_id == '1')
                                                        Order
                                                    @endif
                                                    @if($setmenu->status_id =='2')
                                                        Cooking
                                                    @elseif($setmenu->status_id =='3')
                                                        Ready
                                                    @endif
                                                </td>
                                            <!-- <td>
                                                        @if($setmenu->status_id =='2')
                                                <input type="hidden" name="order_duration" value="{{ $setmenu->order_duration }}"/>
                                                            <span class="cooking_duration"></span>
                                                            <input type="hidden" name="duration" class="txt_cooking_duration"/>
                                                        @endif
                                                    </td> -->
                                                <td>
                                                    @if($setmenu->status_id == '1' && !$setmenu->is_ready_food)
                                                        <input type="submit" class="start start_duration_setmenu btn_k btn btn-info" id="{{$setmenu->id}}" name="start" value="စခ်က္မယ္">
                                                    @endif
                                                    @if($setmenu->status_id == '1' && $setmenu->is_ready_food)
                                                        <input type="submit" class="taken complete_taken_setmenu btn_k btn btn-info" id="{{$setmenu->id}}" name="start" value="ဟင္းပြဲရၿပီ">
                                                    @endif

                                                    @if($setmenu->status_id =='2')
                                                        <input type="submit" class="taken complete_taken_setmenu btn_k btn btn-success" id="{{$setmenu->id}}" name="complete" value="ၿပီးၿပီ">

                                                    @endif
                                                    {{--
                                                    @if($setmenu->status_id =='3')
                                                        <input type="submit" class="taken complete_taken_setmenu btn_k btn btn-info" id="{{$setmenu->order_detail_id}}" name="complete" value="ယူမယ္">
                                                    @endif
                                                    --}}
                                                </td>
                                                @if($setmenu->status_id == '1')
                                                    <td>
                                                        <input type="button" class="cancel btn_k btn btn-danger" id="{{$setmenu->order_detail_id}}-{{$setmenu->setmenu_id}}" name="cancel" value="မလုပ္ဘူး" data-toggle="modal" data-target="#{{$setmenu->order_detail_id}}-{{$setmenu->setmenu_id}}modal">
                                                        <div class="modal fade" id="{{$setmenu->order_detail_id}}-{{$setmenu->setmenu_id}}modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                          <div class="modal-dialog cancle-modal" role="document">
                                                            <div class="modal-content">
                                                              <div class="modal-header">
                                                                  <h4 class="modal-title" id="myModalLabel">ဖ်က္မယ့္အေၾကာင္းရင္း</h4>
                                                              </div>
                                                              <div class="modal-body">
                                                                {!! Form::open(array('url' => 'Kitchen/getCancelID/ProductView', 'class'=> 'form-horizontal','onsubmit'=>'return false;', 'id' => $setmenu->order_detail_id . "-" . $setmenu->setmenu_id . "form")) !!}

                                                                @if(isset($setmenu->setmenu_id) && $setmenu->setmenu_id != 0)
                                                                    <input type="hidden" name="order_details_id" value="{{$setmenu->order_detail_id}}">
                                                                @else
                                                                    <input type="hidden" name="order_details_id" value="{{$setmenu->order_detail_id}}">
                                                                @endif
                                                                <input type="hidden" name="setmenu_id" value="{{$setmenu->setmenu_id}}">
                                                                <table class="table">
                                                                  <tr>
                                                                    <td>စာရိုက္ပါ</td>
                                                                    <td><input type="text" name="message" class="form-control"></td>
                                                                  </tr>
                                                                  <tr>
                                                                    <td></td>
                                                                    <td></td>
                                                                  </tr>
                                                                  <tr>
                                                                    <td>
                                                                      <input type="button" name="submit" value="သိမ္းမယ္" class="btn btn-info cancel_product">
                                                                    </td>
                                                                    <td>
                                                                      <button type="button" class="btn" data-dismiss="modal">ပိတ္မယ္</button>
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
                                                        <!-- Modal -->
                                                    </td>
                                                @else
                                                    <td style="border-left: none !important;"></td>
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
                        title: "ေသခ်ာလား?",
                        text: "You will not be able to recover this item!",
                        type: "success",
                        showCancelButton: true,
                        confirmButtonColor: "#86CCEB",
                        confirmButtonText: "Confirm",
                        closeOnConfirm: false
                    }, function(isConfirm){
                        if (isConfirm) {
                            $('#' + itemID).attr('disabled', true);
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
                        title: "ေသခ်ာလား?",
                        text: "You will not be able to recover this item!",
                        type: "success",
                        showCancelButton: true,
                        confirmButtonColor: "#86CCEB",
                        confirmButtonText: "Confirm",
                        closeOnConfirm: false
                    }, function(isConfirm){
                        if (isConfirm) {
                            $('#' + itemID).attr('disabled', true);
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


            $('#autoDiv').on('click','.complete_taken_item', function (e) {
                // window.location.href = "/Kitchen/productView/CookedItem/" + $(this).attr('id');
                var itemID      = $(this).attr('id');

                $(document).ready(function(){
                    swal({
                        title: "ေသခ်ာလား?",
                        text: "You will not be able to recover this item!",
                        type: "success",
                        showCancelButton: true,
                        confirmButtonColor: "#86CCEB",
                        confirmButtonText: "Confirm",
                        closeOnConfirm: false
                    }, function(isConfirm){
                        if (isConfirm) {
                            $('#' + itemID).attr('disabled', true);
                            $.ajax({
                                type: 'GET',
                                url: '/Kitchen/productView/taken/' + itemID,
                                success: function (Response) {

                                    var returnResp        = Response.message;
                                    console.log(returnResp);
                                    if (returnResp == 'success') {
                                        //Socket Emit
                                        var socketKey        = "taken_by";
                                        var socketValue      = "taken_by";
                                        socketEmit(socketKey,socketValue);
                                        swal.close();
                                    }
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
                        title: "ေသခ်ာလား?",
                        text: "You will not be able to recover this item!",
                        type: "success",
                        showCancelButton: true,
                        confirmButtonColor: "#86CCEB",
                        confirmButtonText: "Confirm",
                        closeOnConfirm: false
                    }, function(isConfirm){
                        if (isConfirm) {
                            $('#' + itemID).attr('disabled', true);
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

            $('#autoDiv').on('click','.complete_taken_setmenu', function (e) {
                // window.location.href = "/Kitchen/productView/CookedItem/" + $(this).attr('id');
                var itemID      = $(this).attr('id');

                $(document).ready(function(){
                    swal({
                        title: "ေသခ်ာလား?",
                        text: "You will not be able to recover this item!",
                        type: "success",
                        showCancelButton: true,
                        confirmButtonColor: "#86CCEB",
                        confirmButtonText: "Confirm",
                        closeOnConfirm: false
                    }, function(isConfirm){
                        if (isConfirm) {
                            $('#' + itemID).attr('disabled', true);
                            $.ajax({
                                type: 'GET',
                                url: '/Kitchen/productView/taken/setmenu/' + itemID,
                                success: function (Response) {

                                    var returnResp        = Response.message;
                                    console.log(returnResp);
                                    if (returnResp == 'success') {
                                        //Socket Emit
                                        var socketKey        = "taken_by";
                                        var socketValue      = "taken_by";
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
                    title: "ေသခ်ာလား?",
                    text: "You will not be able to recover this item!",
                    type: "success",
                    showCancelButton: true,
                    confirmButtonColor: "#86CCEB",
                    confirmButtonText: "Confirm",
                    closeOnConfirm: false
                }, function(isConfirm){
                    if (isConfirm) {
                        $('#' + itemID).attr('disabled', true);
                        $.ajax({
                            type: 'GET',
                            url: '/Kitchen/productView/CookingSetMenuItem/' + itemID,
                            success: function (Response) {
                                var returnResp        = Response.message;
                                if (returnResp == 'success') {
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
            $('#autoDiv').on('click','.complete_duration_setmenu',function(e){
                var itemID      = $(this).attr('id');
                swal({
                    title: "ေသခ်ာလား?",
                    text: "You will not be able to recover this item!",
                    type: "success",
                    showCancelButton: true,
                    confirmButtonColor: "#86CCEB",
                    confirmButtonText: "Confirm",
                    closeOnConfirm: false
                }, function(isConfirm){
                    if (isConfirm) {
                        $('#' + itemID).attr('disabled', true);
                        $.ajax({
                            type: 'GET',
                            url: '/Kitchen/productView/CookedSetMenuItem/' + itemID,
                            success: function (Response) {
                                var returnResp        = Response.message;
                                if (returnResp == 'success') {
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

            var taken_by_waiter  = 'take';
            socketOn(taken_by_waiter,url,div);

            //Table Transfer
            var tableChange      = "tableChange";
            socketOn(tableChange,url,div);

            //Order Edit
            var edit      = "edit";
            socketOn(edit,url,div);
        });
    </script>
@endsection
