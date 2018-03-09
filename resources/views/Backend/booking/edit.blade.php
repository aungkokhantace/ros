@extends('cashier.layouts.master')
@section('title','Booking Listing')
@section('content')
    <div class="row">
        <div class="container">
            <div class="col-md-12">
                {!! Form::open(array('url' => 'Cashier/Booking/update', 'class'=> 'form-horizontal','id'=>'bookingEditForm')) !!}
                    <input type="hidden" name="bid" class="form-control" id="bid" value="{{$booking->id}}">
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><b>Name:<span class="require">*</span></b></label>
                            <div class="col-sm-7">
                                <input type="text" name="bname" class="form-control booking_width" id="bname" value="{{$booking->customer_name}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><b>Date:<span class="require">*</span></b></label>
                            <div class="col-sm-7">
                                <div class="input-group date dateTimePicker" data-provide="datepicker">
                                    <input  type="text" class="form-control" id="date1" name="bdate" placeholder="Enter Booking Date" value="{{\Carbon\Carbon::parse($booking->booking_date)->format('d-m-Y')}}">
                                    <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><b>Table:</b></label>
                            <div class="col-sm-7">
                                 <select name="btable[]"  id="booking_table" multiple="multiple" placeholder="Choose Tables">
                                   @foreach($tables as $table) 
                                        @if(in_array($table->id,$booking_tables))
                                            <option value="{{$table->id}}" selected>{{$table->table_no}}</option>
                                        @else
                                        <option value="{{$table->id}}">{{$table->table_no}}</option>
                                        @endif
                                   @endforeach
                                </select>
                                
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><b>Room:</b></label>
                            <div class="col-sm-7">
                                <select name="broom[]" id="booking_room" multiple="multiple" placeholder="Choose Rooms" >
                                    @foreach($rooms as $room)
                                        @if(in_array($room->id, $booking_rooms))
                                            <option value="{{$room->id}}" selected>
                                            {{$room->room_name}}</option>
                                        @else
                                            <option value="{{$room->id}}">{{$room->room_name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><b>From Time:<span class="require">*</span></b></label>
                            <div class="col-sm-7">
                                <div class="input-group bootstrap-timepicker timepicker">
                                <input id="from_time" name="bfrom_time" type="text" class="form-control input-small" value="{{ date('h:i:s A',strtotime($booking->from_time))}}"  >
                                <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                            </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><b>To Time:</b></label>
                            <div class="col-sm-7">
                                <div class="input-group bootstrap-timepicker timepicker">
                                    <input id="to_time" name="bto_time" type="text" class="form-control input-small" value="{{ date('h:i:s A',strtotime($booking->to_time))}}"  >
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                </div>
                                
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><b>Capacity:<span class="require">*</span></b></label>
                            <div class="col-sm-7">
                                <input type="text" name="bquantity" class="form-control booking_width" id="bquantity" value="{{$booking->capacity}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><b>Phone:<span class="require">*</span></b></label>
                            <div class="col-sm-7">
                                <input type="text" name="bphone" class="form-control booking_width" id="bphone" value="{{$booking->phone}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-8 pop-up-linespace">
                                <input type="submit" name="submit" value="ADD" class="user-button-ok">
                                <input type="reset" value="CANCEL" class="user-button-cancel" onclick={{ "booking_listing_form_back();" }}>
                            </div>
                        </div>
                    {!! Form::close() !!}
            </div>
          
        </div>
    </div>
   
   <script type="text/javascript">
        $(document).ready(function() {
            $('#from_time').timepicker();
            $('#to_time').timepicker();
        });
    </script>
@endsection
