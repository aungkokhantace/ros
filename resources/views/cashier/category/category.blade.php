@extends('cashier.layouts.master')
@section('title',isset($editcategory)?'Edit Category':'New Category')
@section('content')

    <div class="col-md-8 user-border-left">
        <h3 class="h3-font"><b>{{isset($editcategory)? "Edit":"New"}}</b></h3>

        @if(isset($editcategory))
            {!! Form::open(array('url' => '/Cashier/Category/update', 'method' => 'post', 'files' => true, 'class'=> 'form-horizontal user-form-border','id'=>'categoryForm')) !!}
        @else
            {!! Form::open(array('url' => '/Cashier/Category/store','method' => 'post', 'files' => true, 'class'=> 'form-horizontal user-form-border','id'=>'categoryForm')) !!}
        @endif

        @if(isset($editcategory))
            {{ Form::hidden('id', $editcategory->id) }}
        @endif

        <div class="form-group">
            <label for="category-name" class="col-sm-3 control-label left-align label-font">Category Name<span class="require">*</span></label>
            <div class="col-sm-7">
                <input type="text" class="form-control" id="category-name" name="name" placeholder="Enter Category Name" value="{{isset($editcategory)? $editcategory->name:Request::old('name')}}"  />
                <p class="text-danger">{{$errors->first('name')}}</p>
            </div>
        </div>

        <div class="form-group">
            <label for="product" class="col-sm-3 form-label left-align label-font">Parent Category</label>
            <div class="col-sm-7">
                <select name="parent_category" id="" class="form-control">
                    @if(isset($editcategory))
                       <option value="0">None</option>
                        {!! generateCategoryListsForEdit($categories,$editcategory->id,$selected,$subtree, $parentId=0, $indent=0) !!}
                    @else
                        <option value="0">None</option>
                        {!! generateCategoryLists($categories, $parentId=0, $indent=0) !!}
                    @endif
                </select>
                <p class="text-danger">{{$errors->first('parent_category')}}</p>
            </div>
        </div>

        <div class="form-group">
            <label for="product" class="col-sm-3 form-label left-align label-font">Kitchen<span class="require">*</span></label>
            <div class="col-sm-7">
                <select name="kitchen" id="kitchen" class="form-control">
                    @if(isset($editcategory))
                        @foreach($kitchen as $k)
                            @if($k->id == $editcategory->kitchen_id)
                                <option value="{{$k->id}}" selected>{{$k->name}}</option>
                            @else
                                <option value="{{$k->id}}">{{$k->name}}</option>
                            @endif
                        @endforeach
                    @else
                        <option selected disabled>Select Kitchen</option>
                        @foreach($kitchen as $k)
                            <option value="{{$k->id}}">{{$k->name}}</option>
                        @endforeach
                    @endif
                </select>
                <p class="text-danger">{{$errors->first('parent_category')}}</p>
            </div>
        </div>

        <div class="form-group">
            <label for="category-image"  class="col-sm-3 form-label left-align label-font">Category Image<span class="require">*</span></label>
            <div class="col-sm-7">
                <input type="file" id="category_browse" class="form-control" onchange="category_upload();" name="fileupload" style="display: none"/>
                <input type="text" id="filename1" name="image" placeholder="Choose Category Image" class="form-control" readonly="true" value="{{isset($editcategory)? $editcategory->image:""}}"/><br>
                @if(isset($editcategory))
                    <img id="img" class="bottom image" src= "../../../uploads/{{$editcategory->image}}" width="385px" height="270px">
                @endif
                <p class="text-danger">{{$errors->first('fileupload')}}</p>
            </div>
            <div class="col-sm-1">
                <span for="camera" class="col-md-1 glyphicon glyphicon-camera camera" onclick="category_HandleBrowseClick();"></span>
            </div>
        </div>

        <div class="form-group">
            <label for="status" class="col-sm-3 form-label left-align label-font">Status</label>
            <div class="col-sm-7">
                <select class="form-control" id="status" name="status">
                    @if(isset($editcategory)){
                    @if( $editcategory->status == 1 )
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
                <p class="text-danger"></p>
            </div>
        </div>

        <div class="form-group">
            <label for="description" class="col-sm-3 form-label left-align label-font">Description<span class="require">*</span></label>
            <div class="col-sm-7">
                <textarea class="form-control" id="Category-description" name="description" placeholder="Enter Category Description" rows="7" cols="40">{{isset($editcategory)? $editcategory->description:Input::old('description')}}</textarea>
                <p class="text-danger">{{$errors->first('description')}}</p>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-8 col-sm-offset-3">
                <input type="submit" name="submit" value="{{isset($editcategory)? 'UPDATE' : 'ADD'}}" class="user-button-ok">
                <input type="reset" value="CANCEL" class="user-button-cancel" onclick="{{ "categoryList();" }}">
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection