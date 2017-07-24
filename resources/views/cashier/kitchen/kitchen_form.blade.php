@extends('cashier/layouts.master')
@section('title',isset($kitchen)?'Edit Kitchen':'New Kitchen')
@section('content')
    <div class="col-md-8 user-border-left">
        <h3 class="h3-font"><b>{{isset($kitchen) ?  'Edit Kitchen' : 'Create New Kitchen' }}</b></h3>

        {{--check new or edit--}}
        @if(isset($kitchen))
            {!! Form::open(array('url' => 'Cashier/Kitchen/update', 'class'=> 'form-horizontal user-form-border','id'=>'kitchenForm')) !!}
        @else
            {!! Form::open(array('url' => 'Cashier/Kitchen/store', 'class'=> 'form-horizontal user-form-border','id'=>'kitchenForm')) !!}
        @endif

        <input type="hidden" name="id" value="{{isset($kitchen)? $kitchen->id:''}}"/>
        <div class="form-group">
            <label for="kitchen_name" class="col-sm-3 control-label left-align label-font">Kitchen Name<span class="require">*</span></label>
            <div class="col-sm-7">
                <input type="text" class="form-control" id="kitchen_name" name="name" placeholder="Enter Kitchen Name" value="{{ isset($kitchen)? $kitchen->name:Request::old('kitchen_name') }}"/>
                <p class="text-danger">{{$errors->first('name')}}</p>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-8 col-sm-offset-3">
                <input type="submit" name="submit" value="{{isset($kitchen)? 'UPDATE' : 'ADD'}}" class="user-button-ok">
                <input type="button" value="CANCEL" class="user-button-cancel" onclick="kitchen_cancel();">
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection