@extends('Backend.layouts.master')
@section('title','Booking Edit')
@section('content')
<div class="content-wrapper">

    <div class="row">
        <div class="container">
            <div class="col-md-12">

                {!! Form::open(array('url' => 'Cashier/Booking/update', 'class'=> 'form-horizontal','id'=>'bookingForm')) !!}
                <input type="hidden" name="id" value="{{$booking->id}}">
                <div class="form-group">
                    <label class="col-sm-3 control-label"><b>Date:<span class="require">*</span></b></label>
                    <div class="col-sm-7">

                        <div class="input-group date dateTimePicker" data-provide="datepicker">
                            <input  type="text" class="form-control" id="date" name="date" placeholder="Enter Booking Date" value="{{isset($booking)? date('d-m-Y',strtotime($booking->booking_date)):Request::old('date')}}" >
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label"><b>From Time:<span class="require">*</span></b></label>
                    <div class="col-sm-7">

                        <div class="input-group bootstrap-timepicker timepicker">
                            <input id="from_time" name="from_time" type="text" class="form-control input-small" value="{{isset($booking)? date('h:i:s A',strtotime($booking->from_time)):Request::old('from_time')}}" >
                            <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                        </div>

                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label"><b>Number of People:<span class="require">*</span></b></label>
                    <div class="col-sm-7">
                        <input type="text" name="quantity" class="form-control" placeholder="Enter Capacity" id="capacity" value="{{isset($booking)? $booking->capacity:Request::old('quantity')}}">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label"><b>Name:<span class="require">*</span></b></label>
                    <div class="col-sm-7">
                        <input type="text" name="name" class="form-control" placeholder="Enter Name" id="name" value="{{isset($booking)? $booking->customer_name:Request::old('name')}}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label"><b>Phone Number:<span class="require">*</span></b></label>
                    <div class="col-sm-7">
                        <input type="text" name="phone_no" class="form-control" placeholder="Enter Phone Number" id="phone_no" value="{{isset($booking)? $booking->phone:Request::old('phone_no')}}" required>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-7">
                        @if(isset($booking_rooms) && count($booking_rooms) > 0)
                            <input type="checkbox" name="check" value="room" id="check_room" checked>
                        @else
                            <input type="checkbox" name="check" value="room" id="check_room">
                        @endif
                            <label class="control-label"><b>Private Room</b></label>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-3"></div>
                    <div class="col-md-7">
                        <div class="row" id="div_table">
                        @if(isset($tables) && count($tables) > 0)
                            @foreach($tables as $table)
                                <div class="col-md-4">
                                    <div class="info-box">
                                            <span class="info-box-icon bg-lred" >
                                                @if(isset($booking_tables) && count($booking_tables) > 0 && in_array($table->id,$booking_tables))
                                                    <input type="checkbox" name="table_check[]" value="{{$table->id}}" style="margin-top: 29px;position: absolute;margin-left: -15px;" checked class="class_table"/>
                                                @else
                                                    <input type="checkbox" name="table_check[]" value="{{$table->id}}" style="margin-top: 29px;position: absolute;margin-left: -15px;" class="class_table"/>
                                                @endif
                                                    <i class="ion ion-fork"></i><i class="ion ion-knife"></i>

                                            </span>

                                        <div class="info-box-content">

                                            <span class="info-box-text"><b>Table Name: </b></span>{{$table->table_no}}
                                            <span class="info-box-text"><b>Capacity:</b></span>{{$table->capacity}}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-3"></div>
                    <div class="col-md-7">
                        <div class="row" id="div_room">
                        @if(isset($rooms) && count($rooms) > 0)
                            @foreach($rooms as $room)
                                <div class="col-md-4">
                                    <div class="info-box">
                                            <span class="info-box-icon bg-lred" >
                                                @if(in_array($room->id,$booking_rooms))
                                                    <input type="checkbox" name="room_check[]" value="{{$room->id}}" style="margin-top: 29px;position: absolute;margin-left: -15px;" class="class_room" checked/>
                                                @else
                                                    <input type="checkbox" name="room_check[]" value="{{$room->id}}" style="margin-top: 29px;position: absolute;margin-left: -15px;" class="class_room"/>
                                                @endif
                                                    <i class="ion ion-fork"></i><i class="ion ion-knife"></i>

                                            </span>

                                        <div class="info-box-content">

                                            <span class="info-box-text"><b>Room Name: </b></span>{{$room->room_name}}
                                            <span class="info-box-text"><b>Capacity:</b></span>{{$room->capacity}}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-8 pop-up-linespace">
                        <input type="submit" name="submit" value="UPDATE" class="user-button-ok">
                        <input type="reset" value="CANCEL" class="user-button-cancel" onclick={{ "booking_listing_form_back();" }}>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>

        </div>
    </div>

    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#from_time').timepicker();
            $('#to_time').timepicker();

            //////////////////////////
            if($('#check_room').attr('checked')){
                $('#div_table').hide();
                $('#div_room').show();
            }
            else{
                $('#div_room').hide();
                $('#div_table').show();
            }
            $('#date').change(showTablesOrRooms);
            $('#from_time').change(showTablesOrRooms);
            $('#check_room').change(showTablesOrRooms);
            /////////////////////////
        });
        function showTablesOrRooms(){
            var date    = $('#date').val();
            var time    = $('#from_time').val();
            if($('#check_room').attr('checked')){
//                    $('.class_table').removeAttr('checked');
                $('#div_table').hide();
                var request = $.get('/Cashier/Booking/getRooms/'+date+'/'+time);
                var div = "";
                request.done(function(rooms){
                    console.log('success',rooms);
                    $.each(rooms,function(i,room){

                        div += "<div class='col-md-4'><div class='info-box'><span class='info-box-icon bg-lred'><input type='checkbox' name='room_check[]' value='"+room.id+"' style='margin-top: 29px;position: absolute;margin-left: -15px;' class='class_table'/><i class='ion ion-fork'></i><i class='ion ion-knife'></i></span><div class='info-box-content'><span class='info-box-text'><b>Room Name: </b></span>"+room.room_name+"<span class='info-box-text'><b>Capacity:</b></span>"+room.capacity+"</div></div></div>";

                    });
                    $('#div_room').html(div);
                    $('#div_room').show();
                });
            }
            else{
//                    $('.class_room').removeAttr('checked');
                $('#div_room').hide();
                var request = $.get('/Cashier/Booking/getTables/'+date+'/'+time);
                var div = "";
                request.done(function(tables){
                    $.each(tables,function(i,table){

                        div += "<div class='col-md-4'><div class='info-box'><span class='info-box-icon bg-lred'><input type='checkbox' name='table_check[]' value='"+table.id+"' style='margin-top: 29px;position: absolute;margin-left: -15px;' class='class_table'/><i class='ion ion-fork'></i><i class='ion ion-knife'></i></span><div class='info-box-content'><span class='info-box-text'><b>Table Name: </b></span>"+table.table_no+"<span class='info-box-text'><b>Capacity:</b></span>"+table.capacity+"</div></div></div>";

                    });
                    $('#div_table').html(div);
                    $('#div_table').show();
                });

            }
        }
    </script>
@endsection
