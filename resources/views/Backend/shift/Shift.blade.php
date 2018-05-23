@extends('Backend.layouts.master')
@section('title',isset($shift)?'Edit Shift':'New Shift')
@section('content')
<div class="content-wrapper">
      <div class="box">
       <div class="box-header">
        <div class="row">
   
        {{--title--}}
        <h3 class="font">{{isset($shift)? "Edit Shift":"Create New Shift"}}</h3>
        {{--title--}}
    </div>
   </div>
  
    <div class="col-md-8" style="margin-top:30px">
         <div class="container">
        @if(isset($shift))
            {!! Form::open(array('url' => 'Backend/Shift/update', 'method' => 'post','class'=> 'form-horizontal', 'id'=>'shift-validate')) !!}
        @else
            {!! Form::open(array('url' => 'Backend/Shift/store', 'method' => 'post','class'=> 'form-horizontal', 'id'=>'shift-validate', 'onsubmit' => 'return validate();')) !!}
        @endif

        @if(isset($shift))
        <input type="hidden" name="id" value="{{$shift->id}}">
        @endif

        <div class="form-group">
            <label for="item-name" class="col-sm-3 control-label">Shift Name<span class="require">*</span></label>
            <div class="col-sm-7">
                <input type="text" class="form-control" id="shift-name" name="name" placeholder="Enter Shift Name"
                       value="{{isset($shift)? $shift->name:Input::old('name')}}" />
                <p class="text-danger">{{$errors->first('name')}}</p>
            </div>
        </div>

        <div class="form-group">
            <label for="item-description" class="col-sm-3 control-label">Shift Description<span class="require">*</span></label>
            <div class="col-sm-7">
                <textarea class="form-control" id="shift-description" name="description" placeholder="Enter Shift Description" rows="7" cols="40">{{isset($shift)? $shift->description:Input::old('description')}}</textarea>
                <p class="text-danger">{{$errors->first('description')}}</p>
            </div>
        </div>
        {{--End item Status--}}
        <div class="form-group">
            <div class="col-sm-7 col-sm-offset-3">
                <input type="submit" name="submit" value="{{isset($shift)? 'UPDATE' : 'ADD'}}" class="user-button-ok"> {{--Add Button--}}
                <input type="reset" value="CANCEL" class="user-button-cancel" onclick="show_shift_list();"> {{--Cancel Button--}}
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
</div>
</div>
@endsection