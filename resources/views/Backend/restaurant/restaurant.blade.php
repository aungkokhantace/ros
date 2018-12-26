@extends('Backend.layouts.master')
@section('title',isset($editrestaurant)?'Edit Restaurant':'New Restaurant')
@section('content')
    <div class="content-wrapper">
      <div class="box">
       <div class="box-header">
    <div class="col-md-8 user-border-left">
        <h3 class="h3-font"><b>{{isset($editrestaurant)? "Edit":"New"}}</b></h3>
     </div>
 </div>
</div>
   <div class="container">
        @if(isset($editrestaurant))
            {!! Form::open(array('url' => '/Backend/Restaurant/update', 'method' => 'post', 'files' => true, 'class'=> 'form-horizontal user-form-border','id'=>'restaurantForm')) !!}
        @else
            {!! Form::open(array('url' => '/Backend/Restaurant/store','method' => 'post', 'files' => true, 'class'=> 'form-horizontal user-form-border','id'=>'restaurantForm')) !!}
        @endif

        @if(isset($editrestaurant))
            {{ Form::hidden('id', $editrestaurant->id) }}
        @endif
           

        <div class="form-group">
            <label for="category-name" class="col-sm-3 control-label left-align label-font">Restaurant Name<span class="require">*</span></label>
            <div class="col-sm-7">
                <input type="text" class="form-control" id="category-name" name="name" placeholder="Enter Category Name" value="{{isset($editrestaurant)? $editrestaurant->name:Request::old('name')}}"  />
                <p class="text-danger">{{$errors->first('name')}}</p>
            </div>
        </div>
        
        <div class="form-group">
            <label for="product" class="col-sm-3 form-label left-align label-font">Mobile Logo</label>
            <div class="col-sm-7">
            <input type="file" id="category_browse_mobile" class="form-control" onchange="restaurant_mobile();" name="fileupload_mobile" style="display: none"/>
                <input type="text" id="mobile_image" name="mobile_image" placeholder="Choose Mobile Logo" class="form-control" readonly="true" value="{{isset($editrestaurant)? $editrestaurant->logo:""}}"/><br>
                @if(isset($editrestaurant))
                    <img id="img" class="bottom image" src= "../../../uploads/{{$editrestaurant->logo}}" width="240" height="57">
                @endif
                <p class="text-danger">{{$errors->first('fileupload')}}</p>
          
            </div>
             <div class="col-sm-1">
                <span for="camera" class="col-md-1 glyphicon glyphicon-camera camera" onclick="MobileBrowseClick();"></span>
            </div>
        </div>
    
        <div class="form-group">
            <label for="category-image"  class="col-sm-3 form-label left-align label-font"> Logo <span class="require">*</span></label>
            <div class="col-sm-7">
                <input type="file" id="category_browse" class="form-control" onchange="restaurant_upload();" name="fileupload" style="display: none"/>
                <input type="text" id="filename1" name="image" placeholder="Choose Restaurant Logo" class="form-control" readonly="true" value="{{isset($editrestaurant)? $editrestaurant->mobile_logo:""}}" /><br>
                @if(isset($editrestaurant))
                    <img id="img" class="bottom image" src= "../../../uploads/{{$editrestaurant->mobile_logo}}"  width="240" height="57">
                @endif
                <p class="text-danger">{{$errors->first('fileupload')}}</p>
            </div>
            <div class="col-sm-1">
                <span for="camera" class="col-md-1 glyphicon glyphicon-camera camera" onclick="category_HandleBrowseClick();"></span>
            </div>
        </div> 
        <div class="form-group">
            <label for="website" class="col-sm-3 control-label left-align label-font">Restaurant Website</label>
            <div class="col-sm-7">
                <input type="text" class="form-control" id="website" name="website" placeholder="Enter Restaurant Website" value="{{ isset($editrestaurant)? $editrestaurant->website : Request::old('website') }}"/>
                <p class="text-danger">{{$errors->first('website')}}</p>
            </div>
        </div>

        <div class="form-group">
            <label for="website" class="col-sm-3 control-label left-align label-font">Restaurant Email</label>
            <div class="col-sm-7">
                <input type="text" class="form-control" id="email" name="email" placeholder="Enter Restaurant Email" value="{{ isset($editrestaurant)? $editrestaurant->email : Request::old('email') }}"/>
                <p class="text-danger">{{$errors->first('email')}}</p>
            </div>
        </div>

        <div class="form-group">
            <label for="phone" class="col-sm-3 control-label left-align label-font">Restaurant Phone</label>
            <div class="col-sm-7">
                <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter Restaurant Phone" value="{{ isset($editrestaurant)? $editrestaurant->phone_no : Request::old('phone') }}"/>
                <p class="text-danger">{{$errors->first('phone')}}</p>
            </div>
        </div>

        <div class="form-group">
            <label for="description" class="col-sm-3 form-label left-align label-font">Restaurant Address</label>
            <div class="col-sm-7">
                <textarea class="form-control" id="address" name="address" placeholder="Enter Restaurant Address" rows="7" cols="40">{{isset($editrestaurant)? $editrestaurant->address:Request::old('address')}}</textarea>
                <p class="text-danger">{{$errors->first('address')}}</p>
            </div>

        </div>

      

        <div class="form-group">
            <label for="description" class="col-sm-3 form-label left-align label-font">Description</label>
            <div class="col-sm-7">
                <textarea class="form-control" id="Category-description" name="description" placeholder="Enter Category Description" rows="7" cols="40">{{isset($editrestaurant)? $editrestaurant->description:Input::old('description')}}</textarea>
                <p class="text-danger">{{$errors->first('description')}}</p>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-8 col-sm-offset-3">
                <input type="submit" name="submit" value="{{isset($editrestaurant)? 'UPDATE' : 'ADD'}}" class="user-button-ok">
                <input type="reset" value="CANCEL" class="user-button-cancel" onclick="{{ "RestaurantList();" }}">
            </div>
        </div>
        {!! Form::close() !!}
    </div>
  </div>
</div>

@endsection