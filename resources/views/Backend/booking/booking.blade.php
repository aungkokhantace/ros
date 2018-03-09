@extends('Backend.layouts.master')
@section('title','Booking Listing')
@section('content')
<div class="content-wrapper">
      
    <div class="row">
        <div class="container">
            <div class="col-md-12">

                {!! Form::open(array('url' => 'Backend/Booking/store', 'class'=> 'form-horizontal','id'=>'bookingForm')) !!}

                    <div class="form-group">
                        <label class="col-sm-3 control-label"><b>Date:<span class="require">*</span></b></label>
                        <div class="col-sm-7">
                            
                            <div class="input-group date dateTimePicker" data-provide="datepicker">
                                <input  type="text" class="form-control datepicker" id="date1" name="date" placeholder="Enter Booking Date" value="{{isset($date)? $date:Request::old('date')}}" >
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
                                <input id="from_time" name="from_time" type="text" class="form-control input-small" value="{{isset($from)? $from:Request::old('from')}}" >
                                <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                            </div>
                           
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-sm-3 control-label"><b>Number of People:<span class="require">*</span></b></label>
                        <div class="col-sm-7">
                            <input type="text" name="quantity" class="form-control" placeholder="Enter Capacity" id="capacity" value="{{isset($quantity)? $quantity:Request::old('quantity')}}">
                        </div>
                    </div>

                     <div class="form-group">
                        <label class="col-sm-3 control-label"><b>Name:<span class="require">*</span></b></label>
                        <div class="col-sm-7">
                            <input type="text" name="name" class="form-control" placeholder="Enter Name" id="name" value="{{isset($name)? $name:Request::old('name')}}" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label"><b>Phone Number:<span class="require">*</span></b></label>
                        <div class="col-sm-7">
                            <input type="text" name="phone_no" class="form-control" placeholder="Enter Phone Number" id="phone_no" value="{{isset($phone_no)? $phone_no:Request::old('phone_no')}}" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-3"></div>
                        <div class="col-md-7">
                            @if(isset($tables))
                                @foreach($tables as $table)
                                    <div class="col-md-4">
                                        <div class="info-box">
                                            <span class="info-box-icon bg-lred" >
                                                <input type="checkbox" name="table_check[]" value="{{$table->id}}" style="margin-top: 29px;position: absolute;margin-left: -18px;"/>
                                              <i class="fa fa-cutlery"></i>

                                            </span>

                                            <div class="info-box-content">

                                                <span class="info-box-text"><b>Table Name: </b></span>{{$table->table_no}}
                                                <span class="info-box-text"><b>Capacity:</b></span>{{$table->capacity}}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                            @if(isset($rooms))
                                @foreach($rooms as $room)
                                    <div class="col-md-5">
                                        <div class="info-box">
                                            <span class="info-box-icon bg-lred" >
                                                <input type="checkbox" name="room_check[]" value="{{$room->id}}" style="margin-top: 29px;position: absolute;margin-left: -18px;"/>
                                               <i class="fa fa-cutlery"></i>

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
</div>
    
    <script type="text/javascript">
        $(document).ready(function() {
            $('#from_time').timepicker();
            $('#to_time').timepicker();
        });
    </script>
@endsection
