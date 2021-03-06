@extends('cashier/layouts.master')
@section('title',isset($resource)?'Edit Set':'New Set')
@section('content')
    <div class="col-md-8 user-border-left">
        <h3 class="h3-font"><b>{{isset($resource) ?  'Edit SetMenu' : 'Create New SetMenu' }}</b></h3>

        @if(isset($resource))
            {!! Form::open(array('url' => 'Cashier/SetMenu/update', 'files' => true, 'class'=> 'form-horizontal user-form-border','id'=>"setForm")) !!}
        @else
            {!! Form::open(array('url' => 'Cashier/SetMenu/store', 'files' => true, 'class'=> 'form-horizontal user-form-border','id'=>"setForm")) !!}
        @endif
        <input type="hidden" name="id" value="{{isset($resource)?$resource->id:''}}">

        <div class="form-group">
            <label for="set_menus_name" class="col-sm-3 control-label left-align label-font">Set menu Name<span class="require">*</span></label>
            <div class="col-sm-7">
                <input type="text" class="form-control" id="set_menus_name" name="set_menus_name" placeholder="Enter Set Menu Name" value= "{{isset($resource)? $resource->set_menus_name:Input::old('set_menus_name')}}" >
                <p class="text-danger">{{$errors->first('set_menus_name')}}</p>
            </div>
        </div>

        <div class="form-group">
            <label for="items" class="col-sm-3 control-label left-align label-font">Items<span class="require">*</span></label>
            <div class="col-sm-7">
                <div>
                <select name="item[]" id="Category" multiple="multiple">
                    @if(isset($resource))
                        {!! submenusitemsEdit($category,$items,$parentId=0, $indent=0,$set_item) !!}
                    @else
                        {!! submenusitems($category,$items,$parentId=0,$index=0) !!}
                    @endif
                </select>
                <p class="text-danger" id="items_err">{{ $errors->first("item[]") }}</p>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="price" class="col-sm-3 control-label left-align label-font">Price<span class="require">*</span></label>
            <div class="col-sm-7">
                <input type="text" class="form-control" id="set_menus_price" name="set_menus_price" placeholder="Enter Set Menu Price" value= "{{isset($resource)? $resource->set_menus_price: Input::old('set_menus_price') }}" >
                <p class="text-danger">{{$errors->first('set_menus_price')}}</p>
            </div>
        </div>

        <div class="form-group">
            <label for="image" class="col-sm-3 control-label left-align label-font">Image<span class="require">*</span></label>
            <div class="col-sm-7">
                <input type="file" class="form-control" id="set_browse" onchange="set_upload();" name="fileupload" style="display: none"/>
                <input type="text" class="form-control" id="filename1" name="image" readonly="true" placeholder="Choose Set Menu Image" value="{{isset($resource)? $resource->image:""}}"/><br>
                <img id="filename" class="bottom image" src="<?php  ?>">
                @if (isset($resource))
                        <img src= "../../../uploads/{{ $resource->image }}" width="385px" height="270px">
                @endif
                <p class="text-danger">{{$errors->first('fileupload')}}</p>
            </div>
            <span for="camera" class="col-md-1 glyphicon glyphicon-camera camera" onclick="set_HandleBrowseClick();"></span>
        </div>

        <div class="form-group">
            <label for="status" class="col-sm-3 control-label left-align label-font">Status</label>
            <div class="col-sm-7">
                <select class="form-control" id="status" name="status">
                    @if(isset($resource)){
                    @if( $resource->status == 1 )
                        <option value="1" selected>Available </option>
                        <option value="0">Not Available </option>
                    @else
                        <option value="0" selected>Not Available </option>
                        <option value="1">Available </option>
                    @endif
                    @else
                        <option value="1">Available</option>
                        <option value="0">Not Available</option>
                    @endif
                </select>
                <p class="text-danger">{{$errors->first('status')}}</p>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-8 col-sm-offset-3">
                <input type="submit" name="submit" value="{{isset($resource)? 'UPDATE' : 'ADD'}}" class="user-button-ok">
                <input type="reset" value="CANCEL" class="user-button-cancel" onclick={{ "sub_listing_form_back();"}}>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection