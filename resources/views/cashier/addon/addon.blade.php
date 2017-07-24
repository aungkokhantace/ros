@extends('cashier/layouts.master')
@section('title',isset($resource)?'Edit Add-on':'New Add-on')
@section('content')
    <div class="col-md-8 user-border-left">
        <h3 class="h3-font"><b>{{isset($resource) ?'Edit' : 'New' }}</b></h3>
        @if(isset($resource))
            {!! Form::open(array('url' => 'Cashier/AddOn/update', 'files' => true, 'class'=> 'form-horizontal user-form-border','id'=>"extraForm")) !!}
        @else
            {!! Form::open(array('url' => 'Cashier/AddOn/store', 'files' => true, 'class'=> 'form-horizontal user-form-border','id'=>"extraForm")) !!}
        @endif

        <input  type="hidden" name="id" value="{{isset($resource)? $resource->id:""}}">
        <div class="form-group">
            <label for="discount" class="col-sm-3 control-label left-align label-font">Add-on Name<span class="require">*</span></label>
            <div class="col-sm-7">
                <input type="text" class="form-control" id="food_name" placeholder="Enter Add-on Name" name="food_name"  value="{{isset($resource)? $resource->food_name:Input::old('food_name')}}">
                <p class="text-danger">{{$errors->first('food_name')}}</p>
            </div>
        </div>

        <div class="form-group">
            <label for="discount" class="col-sm-3 control-label left-align label-font" >Category<span class="require">*</span></label>
            <div class="col-sm-7">
                <select id="product" class="form-control" name="category_id"  >
                    <option value="">Select Category</option>
                    <?php foreach ($category as $category) : ?>
                    <?php if(isset($resource)) : ?>
                    <option  value="<?php echo $category->id; ?>" <?php echo $category->id == $resource->category_id ? 'selected' : '' ?>>
                        <?php echo $category->name; ?>
                    </option>
                    <?php else : ?>
                    <option  value="<?php echo $category->id; ?>">   <?php echo $category->name; ?> </option>
                    <?php endif; ?>
                    <?php endforeach; ?>

                </select>
                <p class="text-danger">{{$errors->first('category_id')}}</p>
            </div>
        </div>

        <div class="form-group">
            <label for="description" class="col-sm-3 control-label left-align label-font">Description<span class="require">*</span></label>
            <div class="col-sm-7">
                <textarea class="form-control" id="item-description" name="description" placeholder="Enter Add-on Description" rows="7" cols="40">{{isset($resource)? $resource->description:Input::old('description')}}</textarea>
                <p class="text-danger">{{$errors->first('description')}}</p>
            </div>
        </div>

        <div class="form-group">
            <label for="image" class="col-sm-3 control-label left-align label-font">Add-on Image<span class="require">*</span></label>
                <div class="col-sm-7">
                    <input type="file" class="form-control" id="extra_browse" onchange="extra_upload();" name="fileupload" style="display: none"/>
                    <input type="text" class="form-control" name="filename" id="filename1" readonly="true" placeholder="Choose Add-on Image" value="{{isset($resource)? $resource->image:""}}"/><br>
                    @if (isset($resource))
                        <img src= "../../../uploads/{{ $resource->image }}" width="400px" height="270px">
                        @endif
                    <p class="text-danger">{{$errors->first('fileupload')}}</p>
                </div>
                <span for="camera" class="col-md-1 glyphicon glyphicon-camera camera" onclick="extra_HandleBrowseClick();"></span>
            </div>

            <div class="form-group">
                <label for="discount" class="col-sm-3 control-label left-align label-font">Price<span class="require">*</span></label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" id="price" placeholder="Enter Add-on Price" name="price"  value= "{{isset($resource)? $resource->price:Input::old('price')}}">
                    <p class="text-danger">{{$errors->first('price')}}</p>
                </div>
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
                   <input type="submit" name="submit" value="{{isset($resource)? 'Update' : 'ADD'}}" class="user-button-ok" >
                   <input type="reset" value="CANCEL" class="user-button-cancel" onclick="extra_listing_form_back();">
               </div>
           </div>
        {!! Form::close() !!}

    </div>
@endsection