@extends('cashier/layouts.master')
@section('title',isset($resource)?'Edit Member Type':'New Member Type')
@section('content')
    <div class="col-md-8 user-border-left">
        <h3 class="h3-font"><b>{{isset($resource) ?  'Edit Member Type' : 'Create New Member Type' }}</b></h3>
        @if(isset($resource))
            {!! Form::open(array('url' => 'Cashier/MemberType/update','id'=>'member_type_validate', 'class'=> 'form-horizontal user-form-border')) !!}
        @else
            {!! Form::open(array('url' => 'Cashier/MemberType/store','id'=>'member_type_validate', 'class'=> 'form-horizontal user-form-border')) !!}
               @endif

        <div class="form-group">
            <label for="member-type" class="col-sm-3 control-label left-align label-font">Member Type<span class="require">*</span></label>
            <div class="col-sm-7">
                <input type="hidden" name="id" value="{{isset($resource)? $member_type_edit->id:''}} "/>
                <input type="text" class="form-control" id="member-type" placeholder="Enter Member Type" name="type" value="{{isset($resource)? $resource->type:Input::old('type')}}" required/>
                <p class="text-danger">{{$errors->first('type')}}</p>

            </div>
        </div>

        <div class="form-group">
            <label for="description" class="col-sm-3 control-label left-align label-font">Description<span class="require">*</span></label>
            <div class="col-sm-7">
                <textarea class="form-control" name="description" placeholder="Enter Member Type Description" rows="7" cols="40">{{isset($resource)? $resource->description:Input::old('description')}}</textarea>
                <p class="text-danger">{{$errors->first('description')}}</p>
            </div>
        </div>

        <div class="form-group">
            <label for="discount" class="col-sm-3 control-label left-align label-font">Discount Percent(%)<span class="require">*</span></label>
            <div class="col-sm-7">
                <input type="text" class="form-control" id="discount" name="discount_amount" placeholder="Enter Discount Percent"  value="{{isset($resource)? $resource->discount_amount:Input::old('discount_amount') }}"/>
                <p class="text-danger"></p>
                <p class="text-danger">{{$errors->first('discount_amount')}}</p>
            </div>
        </div>

        <div class="form-group">
            <label for="discount" class="col-sm-3 control-label left-align label-font">Life Time<span class="require">*</span></label>
            <div class="col-sm-5">
                <input type="number" class="form-control" name="life_time" placeholder="Enter Life Time" value="{{isset($resource)? $resource->life_time:Input::old('life_time') }}" min="1" step="1"/>
            </div>
            years
        </div>

        <div class="form-group">
            <div class="col-sm-8 col-sm-offset-3">
                <input type="submit" name="submit" value="{{isset($resource)? 'UPDATE' : 'ADD'}}" class="user-button-ok" >
                <input type="reset" value="CANCEL" class="user-button-cancel" onclick={{"member_type_cancel();"}}>
            </div>
        </div>

        {!! Form::close() !!}
    </div>

@endsection