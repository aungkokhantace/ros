@extends('cashier.layouts.master')
@section('title','Booking Listing')
@section('content')
    <div class="row">
        <div class="container">
            <div class="col-md-12">

                {!! Form::open(array('url' => 'Cashier/Booking/search', 'class'=> 'form-horizontal','id'=>'bookingForm')) !!}

                    <div class="form-group">
                        <label class="col-sm-3 control-label"><b>Date:<span class="require">*</span></b></label>
                        <div class="col-sm-7">
                            
                            <div class="input-group date dateTimePicker" data-provide="datepicker">
                                <input  type="text" class="form-control" id="date1" name="date" placeholder="Enter Booking Date" >
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
                                <input id="from_time" name="from_time" type="text" class="form-control input-small" >
                                <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                            </div>
                           
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-sm-3 control-label"><b>Number of People:<span class="require">*</span></b></label>
                        <div class="col-sm-7">
                            <input type="text" name="quantity" class="form-control" placeholder="Enter Capacity" id="capacity" >
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-7">
                            <input type="checkbox" name="check" value="room">
                            <label class="control-label"><b>Private Room</b></label>
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
