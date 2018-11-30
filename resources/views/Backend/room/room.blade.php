@extends('Backend/layouts.master')
@section('title',isset($room)?'Edit Room':'New Room')
@section('content')
<div class="content-wrapper">
      <div class="box">
       <div class="box-header">
    
        <h3 class="h3-font"><b>{{isset($room) ?  'Edit' : 'New' }}</b></h3>
     </div>
</div> 
       <div class="container">

        <div class="col-md-8 user-border-left">
        {{--check new or edit--}}
        @if(isset($room))
            {!! Form::open(array('url' => 'Backend/Room/update', 'class'=> 'form-horizontal user-form-border','id'=>'roomForm')) !!}
        @else
            {!! Form::open(array('url' => 'Backend/Room/store', 'class'=> 'form-horizontal user-form-border','id'=>'roomForm')) !!}
        @endif
        <!-- restaturant session -->
        @if (Auth::guard('Cashier')->user()->restaurant_id == null)
         <div class="form-group">
            <label for="member-type" class="col-sm-3 control-label left-align label-font">Restaurant <span class="require">*</span></label>
            <div class="col-sm-8">                 
                 @if(isset($room))
                    @foreach($restaurants as $restaurant)
                        @if($restaurant->id == $room->restaurant_id)
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
            <label for="member-type" class="col-sm-3 control-label left-align label-font">Branch <span class="require">*</span></label>
            <div class="col-sm-8">                 
                 @if(isset($room))
                    @foreach($branchs as $branch)
                        @if($branch->id == $room->branch_id)
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
            <label for="member-type" class="col-sm-3 control-label left-align label-font">Branch <span class="require">*</span></label>
            <div class="col-sm-8">                 
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

        <input type="hidden" name="id" value="{{isset($room)? $room->id:''}}"/>
        <div class="form-group">
            <label for="member-type" class="col-sm-3 control-label left-align label-font">Room Name<span class="require">*</span></label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="room_name" name="room_name" placeholder="Enter Room Name" value="{{ isset($room)? $room->room_name:Request::old('room_name') }}"/>
                <p class="text-danger">{{$errors->first('room_name')}}</p>
            </div>
        </div>
        <div class="form-group">
            <label for="capacity" class="col-sm-3 control-label left-align label-font">Capacity<span class="require">*</span></label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="capacity" name="capacity" placeholder="Enter Capacity" value="{{ isset($room)? $room->capacity:Request::old('capacity') }}"/>
                <p class="text-danger">{{$errors->first('capacity')}}</p>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-8 col-sm-offset-3">
                <input type="submit" name="submit" value="{{isset($room)? 'UPDATE' : 'ADD'}}" class="user-button-ok">
                <input type="button" value="CANCEL" class="user-button-cancel" onclick="room_cancel();">
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
</div>
<script src="/assets/backend_js/branch/branch.js"></script>
@endsection