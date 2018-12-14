@extends('Backend.layouts.master')
@section('title','Booking Edit')
@section('content')
<div class="content-wrapper">

    <div class="row">
        <div class="container" style="margin-top: 30px">
            <div class="col-md-12">

                {!! Form::open(array('url' => 'Backend/Booking/update', 'class'=> 'form-horizontal','id'=>'bookingForm')) !!}
                  <!-- restaturant session -->
        @if (Auth::guard('Cashier')->user()->restaurant_id == null)
         <div class="form-group">
            <label for="member-type" class="col-sm-3 control-label"><b>Restaurant<span class="require">*</span></b> </label>
              <div class="col-sm-5">           
                 @if(isset($booking))
                    @foreach($restaurants as $restaurant)
                        @if($restaurant->id == $booking->restaurant_id)
                         <input type="text" class="form-control" value="{{ $restaurant->name }}" readonly />
                         <input type="hidden" class="form-control" id="restaurant" name="restaurant" value="{{ $restaurant->id }}" />                         
                       
                        @endif
                    @endforeach               
              
                   @endif
              
            </div>
        </div>
     

         <div class="form-group">
            <label for="member-type" class="col-sm-3 control-label"><b>Branch <span class="require">*</span></b> </label>
             <div class="col-sm-5">            
                 @if(isset($booking))
                    @foreach($branchs as $branch)
                        @if($branch->id == $booking->branch_id)
                         <input type="text" class="form-control" value="{{ $branch->name }}" readonly />
                         <input type="hidden" class="form-control" id="branch" name="branch" value="{{ $branch->id }}" />                         
                       
                        @endif
                    @endforeach              
                @endif
                </select>
              
            </div>
        </div>
         @elseif (Auth::guard('Cashier')->user()->branch_id == null || Auth::guard('Cashier')->user()->branch_id == 0 )

        <div class="form-group">
            <label for="member-type" class="col-sm-3 control-label">Branch<b><span class="require">*</span></b></label>
              <div class="col-sm-5">    
                 @if(isset($booking))
                    @foreach($branchs as $branch)
                        @if($branch->id == $booking->branch_id)
                         <input type="text" class="form-control" value="{{ $branch->name }}" readonly />
                         <input type="hidden" class="form-control" id="branch" name="branch" value="{{ $branch->id }}" />                         
                       
                        @endif
                    @endforeach                
                    @endif
                </select>
              
            </div>
        </div>
        @endif
        <!--end restaturant session -->

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
                    <label class="col-sm-3 control-label"><b>booking Time:<span class="require">*</span></b></label>
                    <div class="col-sm-7">

                        <div class="input-group bootstrap-timepicker timepicker">
                            <input id="booking_time" name="booking_time" type="text" class="form-control input-small" value="{{isset($booking)? date('h:i:s A',strtotime($booking->booking_time)):Request::old('booking_time')}}" >
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
                        @if(isset($booking_bookings) && count($booking_bookings) > 0)
                            <input type="checkbox" name="check" value="booking" id="check_booking" checked>
                        @else
                            <input type="checkbox" name="check" value="booking" id="check_booking">
                        @endif
                            <label class="control-label"><b>Private booking</b></label>
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
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-3"></div>
                    <div class="col-md-7">
                        <div class="row" id="div_booking">
                        @if(isset($bookings) && count($bookings) > 0)
                            @foreach($bookings as $booking)
                                <div class="col-md-4">
                                    <div class="info-box">
                                            <span class="info-box-icon bg-lred" >
                                                @if(in_array($booking->id,$booking_bookings))
                                                    <input type="checkbox" name="booking_check[]" value="{{$booking->id}}" style="margin-top: 29px;position: absolute;margin-left: -15px;" class="class_booking" checked/>
                                                @else
                                                    <input type="checkbox" name="booking_check[]" value="{{$booking->id}}" style="margin-top: 29px;position: absolute;margin-left: -15px;" class="class_booking"/>
                                                @endif
                                                    <i class="ion ion-fork"></i><i class="ion ion-knife"></i>

                                            </span>

                                        <div class="info-box-content">

                                            <span class="info-box-text"><b>booking Name: </b></span>{{$booking->booking_name}}
                                            <span class="info-box-text"><b>Capacity:</b></span>{{$booking->capacity}}
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
            $('#booking_time').timepicker();
            $('#to_time').timepicker();

            //////////////////////////
            if($('#check_booking').attr('checked')){
                console.log("bookign how");
                $('#div_table').hide();
                $('#div_booking').show();
            }
            else{
                $('#div_booking').hide();
                $('#div_table').show();
            }
            $('#date').change(showTablesOrbookings);
            $('#booking_time').change(showTablesOrbookings);
            $('#check_booking').change(showTablesOrbookings);
            /////////////////////////
        });
        function showTablesOrbookings(){
            var date    = $('#date').val();
            var time    = $('#booking_time').val();
            if($('#check_booking').attr('checked')){
//                    $('.class_table').removeAttr('checked');
                $('#div_table').hide();
                // var request = $.get('/Cashier/Booking/getbookings/'+date+'/'+time);
                var request = $.get('/Backend/Booking/getTables/'+date+'/'+time);
                
                var div = "";
                request.done(function(bookings){
                    console.log('success',bookings);
                    $.each(bookings,function(i,booking){

                        div += "<div class='col-md-4'><div class='info-box'><span class='info-box-icon bg-lred'><input type='checkbox' name='booking_check[]' value='"+booking.id+"' style='margin-top: 29px;position: absolute;margin-left: -15px;' class='class_table'/><i class='ion ion-fork'></i><i class='ion ion-knife'></i></span><div class='info-box-content'><span class='info-box-text'><b>booking Name: </b></span>"+booking.booking_name+"<span class='info-box-text'><b>Capacity:</b></span>"+booking.capacity+"</div></div></div>";

                    });
                    $('#div_booking').html(div);
                    $('#div_booking').show();
                });
            }
            else{
//                    $('.class_booking').removeAttr('checked');
                $('#div_booking').hide();
                // var request = $.get('/Cashier/Booking/getTables/'+date+'/'+time);
                 var request = $.get('/Backend/Booking/getRooms/'+date+'/'+time);
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
