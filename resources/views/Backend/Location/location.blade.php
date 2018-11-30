@extends('Backend/layouts.master')
@section('title',isset($location)?'Edit Location':'New Location')
@section('content')
<div class="content-wrapper">
      <div class="box">
       <div class="box-header">
    
        <h3 class="h3-font"><b>{{isset($location) ?  'Edit Location' : 'Create New Location' }}</b></h3>
      </div>
  </div>
     <div class="container">
      <div class="col-md-8 user-border-left">
        {{--check new or edit--}}
        @if(isset($location))
            {!! Form::open(array('url' => 'Backend/Location/update', 'class'=> 'form-horizontal user-form-border','id'=>'kitchenForm')) !!}
        @else
            {!! Form::open(array('url' => 'Backend/Location/store', 'class'=> 'form-horizontal user-form-border','id'=>'kitchenForm')) !!}
        @endif

        <input type="hidden" name="id" value="{{isset($location)? $location->id:''}}"/>

                                      <!-- restaturant session -->
        @if (Auth::guard('Cashier')->user()->restaurant_id == null)
         <div class="form-group">
            <label for="member-type" class="col-sm-3 control-label left-align label-font">Restaurant <span class="require">*</span></label>
            <div class="col-sm-7">                 
                 @if(isset($location))
                    @foreach($restaurants as $restaurant)
                        @if($restaurant->id == $location->restaurant_id)
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
                @endif
                </select>
              
            </div>
        </div>
     

         <div class="form-group">
            <label for="member-type" class="col-sm-3 control-label left-align label-font">Branch <span class="require">*</span></label>
            <div class="col-sm-7">                 
                 @if(isset($location))
                    @foreach($branchs as $branch)
                        @if($branch->id == $location->branch_id)
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
                 @if(isset($location))
                    @foreach($branchs as $branch)
                        @if($branch->id == $location->branch_id)
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
            <label for="location_name" class="col-sm-3 control-label left-align label-font">Location Name<span class="require">*</span></label>
            <div class="col-sm-7">
                <input type="text" class="form-control" id="location_type" name="location_type" placeholder="Enter Location Name" value="{{ isset($location)? $location->location_type:Request::old('location_type') }}"/>
                <p class="text-danger">{{$errors->first('location_type')}}</p>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-8 col-sm-offset-3">
                <input type="submit" name="submit" value="{{isset($location)? 'UPDATE' : 'ADD'}}" class="user-button-ok">
                <input type="button" value="CANCEL" class="user-button-cancel" onclick="location_cancel();">
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
</div>
<script src="/assets/backend_js/branch/branch.js"></script>
@endsection