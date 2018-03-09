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
@endsection