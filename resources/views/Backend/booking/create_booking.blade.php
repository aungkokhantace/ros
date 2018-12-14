@extends('Backend.layouts.master')
@section('title','Booking Listing')
@section('content')
<div class="content-wrapper">
     
    <div class="row">
        <div class="container">
            <div class="col-md-12 " style="margin-top:100px">

                {!! Form::open(array('url' => 'Backend/Booking/search', 'class'=> 'form-horizontal','id'=>'bookingForm')) !!}

                 <!-- restaturant session -->
        @if (Auth::guard('Cashier')->user()->restaurant_id == null)
         <div class="form-group">
            <label for="member-type" class="col-sm-3 control-label"><b>Restaurant<span class="require">*</span></b> </label>
              <div class="col-sm-5">           
                 @if(isset($from))
                    @foreach($restaurants as $restaurant)
                        @if($restaurant->id == $from->restaurant_id)
                         <input type="text" class="form-control" value="{{ $restaurant->name }}" readonly />
                         <input type="hidden" class="form-control" id="restaurant" name="restaurant" value="{{ $restaurant->id }}" />                         
                       
                        @endif
                    @endforeach                 
                @else
                <select class="form-control" name="restaurant" id="restaurant">            
                <option selected disabled>Select Restaurant </option>
                    @foreach($restaurants as $restaurant)
                      <option value="{{$restaurant->id}}">{{$restaurant->name}}</option>                
                    @endforeach
             
                </select>
                   @endif
              
            </div>
        </div>
     

         <div class="form-group">
            <label for="member-type" class="col-sm-3 control-label"><b>Branch <span class="require">*</span></b> </label>
             <div class="col-sm-5">            
                 @if(isset($from))
                    @foreach($branchs as $branch)
                        @if($branch->id == $from->branch_id)
                         <input type="text" class="form-control" value="{{ $branch->name }}" readonly />
                         <input type="hidden" class="form-control" id="branch" name="branch" value="{{ $branch->id }}" />                         
                       
                        @endif
                    @endforeach                 
                @else
                <select class="form-control" name="branch" id="branch">            
                <option selected disabled>Select Branch </option>
                   
                @endif
                </select>
              
            </div>
        </div>
         @elseif (Auth::guard('Cashier')->user()->branch_id == null || Auth::guard('Cashier')->user()->branch_id == 0 )

        <div class="form-group">
            <label for="member-type" class="col-sm-3 control-label">Branch<b><span class="require">*</span></b></label>
              <div class="col-sm-5">    
                 @if(isset($room))
                    @foreach($branchs as $branch)
                        @if($branch->id == $room->branch_id)
                         <input type="text" class="form-control" value="{{ $branch->name }}" readonly />
                         <input type="hidden" class="form-control" id="branch" name="branch" value="{{ $branch->id }}" />                         
                       
                        @endif
                    @endforeach                 
                @else
                <select class="form-control" name="branch" id="branch" >            
                <option selected disabled>Select Branch </option>
                    @foreach($branchs as $branch)
                      <option value="{{$branch->id}}">{{$branch->name}}</option>                
                    @endforeach
                @endif
                </select>
              
            </div>
        </div>
        @endif
        <!--end restaturant session -->

                    <div class="form-group">
                        <label class="col-sm-3 control-label"><b>Date:<span class="require">*</span></b></label>
                        <div class="col-sm-5">
                            
                            <div class="input-group date " >
                                <input  type="text" class="form-control  booking-create" id="date1" name="date" placeholder="Enter Booking Date" value="{{isset($date)? $date:Request::old('date')}}" readonly="">
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </div>
                            </div>
                        </div>
                    </div>


                   

                    <div class="form-group">
                        <label class="col-sm-3 control-label"><b>From Time:<span class="require">*</span></b></label>
                        <div class="col-sm-5">
                            
                            <div class="input-group bootstrap-timepicker timepicker">
                                <input id="from_time" name="from_time" type="text" class="form-control input-small" value="{{isset($from)? $from:Request::old('from_time')}}" readonly="">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                            </div>
                           
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-sm-3 control-label"><b>Number of People:<span class="require">*</span></b></label>
                        <div class="col-sm-5">
                            <input type="text" name="quantity" class="form-control" placeholder="Enter Capacity" id="capacity" value="{{isset($quantity)? $quantity:Request::old('quantity')}}">
                            <p class="text-danger">{{$errors->first('quantity')}}</p>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-5">
                            <input type="checkbox" name="check" value="room" @if(Request::old('check') AND Request::old('check') == 'room') checked @endif>
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
    </div>

    <script type="text/javascript">
       
        $(document).ready(function() {
            $('#from_time').timepicker();
            $('#to_time').timepicker();
            $('#datepicker').datepicker({
             autoclose: true
            });
        });
    </script>
<script src="/assets/backend_js/branch/branch.js"></script>
@endsection
