@extends('cashier.layouts.master')
@section('title',isset($record)?'Edit Item':'New Item')
@section('content')

    <div class="col-md-8">
        {{--title--}}
        <h3 class="font">{{isset($record)? "Edit Item":"Create New Item"}}</h3>
        {{--title--}}
        @if(isset($record))
            {!! Form::open(array('url' => 'Cashier/Item/update', 'method' => 'post', 'files' => true, 'class'=> 'form-horizontal', 'id'=>'item-validate')) !!}
        @else
            {!! Form::open(array('url' => 'Cashier/Item/store', 'method' => 'post', 'files' => true, 'class'=> 'form-horizontal', 'id'=>'item-validate')) !!}
        @endif

        @if(isset($record))
        <input type="hidden" name="id" value={{$record->id}}>
        @endif

        <div class="form-group">
            <label for="item-name" class="col-sm-3 control-label">Item Name<span class="require">*</span></label>
            <div class="col-sm-7">
                <input type="text" class="form-control" id="item-name" name="name" placeholder="Enter Item Name"
                       value="{{isset($record)? $record->name:Input::old('name')}}" />
                <p class="text-danger">{{$errors->first('name')}}</p>
            </div>
        </div>

        <div class="form-group">
            <label for="category" class="col-sm-3 control-label">Item Category<span class="require">*</span></label>
            <div class="col-sm-7">
                <select name="parent_category" id="" class="form-control ">
                    @if(isset($record))
                        <option value="{{$record->category_id}}" selected>{{$r_cat}}</option>

                        {!! generateItemCategoryList($categories, $parentId=0, $indent=0,$parent_id_arr) !!}

                    @else
                        <option value="0" selected disabled>Select Item Category</option>
                        {!! generateItemCategoryList($categories, $parentId=0, $indent=0,$parent_id_arr) !!}
                    @endif
                </select>
                <p class="text-danger">{{$errors->first('parent_category')}}</p>
            </div>
        </div>

        <div class="form-group">
            <label for="item-description" class="col-sm-3 control-label">Item Description<span class="require">*</span></label>
            <div class="col-sm-7">
                <textarea class="form-control" id="item-description" name="description" placeholder="Enter Item Description" rows="7" cols="40">{{isset($record)? $record->description:Input::old('description')}}</textarea>
                <p class="text-danger">{{$errors->first('description')}}</p>
            </div>
        </div>

        <div class="form-group">
            <label for="item-price" class="col-sm-3 control-label">Item Price<span class="require">*</span></label>
            <div class="col-sm-7">
                <input type="text" class="form-control" id="item-price" name="price" placeholder="Enter Item Price" value="{{isset($record)? $record->price:Input::old('price')}}" />
                <p class="text-danger">{{$errors->first('price')}}</p>
            </div>
        </div>

        <div class="form-group">
            <label for="item-image" class="col-sm-3 control-label">Item Image<span class="require">*</span></label>
            <div class="col-sm-7">
                <input type="file" class="form-control" id="item_browse" onchange="item_upload();"
                       name="fileupload" style="display: none"/>
                <input type="text" class="form-control" name="filename" id="filename1" placeholder="Choose Item Image" readonly="true" value="{{isset($record)? $record->image :  Request::old('image')}}"/><br>
                @if(isset($record))
                    <img id="img_filename" class="bottom image" src= "../../../uploads/{{$record->image}}" width="385px" height="270px">
                @endif
                <p class="text-danger">{{$errors->first('fileupload')}}</p>
            </div>
            <span for="camera" class="col-md-1 glyphicon glyphicon-camera camera" onclick="item_HandleBrowseClick();"></span>
        </div>

        <div class="form-group">
            <label for="item-status" class="col-sm-3 control-label">Item Status</label>
            <div class="col-sm-7">
                <select class="form-control" id="item-status" name="status">
                    @if(isset($record)){
                        @if( $record->status == 1 )
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
            <label for="item-price" class="col-sm-3 control-label">Standard Cooking Time<span class="require">*</span></label>
            <div class="col-sm-7">
                <input type="number" class="form-control" id="item-price" name="standard_cooking_time" placeholder="Enter Standard Cooking Time" value="{{isset($record)? $record->standard_cooking_time:Input::old('standard_cooking_time')}}" />
              
            </div>
            <div class="col-sm-1">Minutes</div>
        </div>
        {{--End item Status--}}
        <div class="form-group">
            <div class="col-sm-7 col-sm-offset-3">
                <input type="submit" name="submit" value="{{isset($record)? 'UPDATE' : 'ADD'}}" class="user-button-ok"> {{--Add Button--}}
                <input type="reset" value="CANCEL" class="user-button-cancel" onclick="show_item_list();"> {{--Cancel Button--}}
            </div>
        </div>
        {!! Form::close() !!}
    </div>

@endsection