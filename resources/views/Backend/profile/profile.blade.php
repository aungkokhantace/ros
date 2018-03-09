@extends('Backend.layouts.master')
@section('title', isset($profile) ? 'Edit Profile' : 'Restaurant Profile')
@section('content')
 <div class="content-wrapper">
      <div class="box">
       <div class="box-header">
    <div class="col-md-12 user-border-left">
        <ul class="nav nav-tabs">
            <li role="presentation"><a href="/Backend/Config/general_config">General Setting</a></li>
            <li role="presentation" class="active"><a href="#">Restaurant Profile</a></li>
        </ul>
    </div>
</div>
  </div>
  <div class="container">
    <div class="col-md-8 user-border-left">

        <h3 class="h3-font"><b>{{isset($profile) ?  'Edit Restaurant Profile' : 'Restaurant Profile' }}</b></h3>
        <br>

        {{--if config is already filled and profile has not filled yet,DB must be updated(not insert)--}}
        @if(isset($record))

            {!! Form::open(array('url' => 'Backend/Profile/update','method' => 'post', 'class'=> 'form-horizontal user-form-border','files'=> true, 'id'=>'profile')) !!}

        @endif

        {{--check whether update or insert--}}
        @if(isset($profile))
            {!! Form::open(array('url' => 'Backend/Profile/update', 'class'=> 'form-horizontal user-form-border','files' => true, 'method'=>'post', 'id'=>'profile')) !!}
        @else
            {!! Form::open(array('url' => 'Backend/Profile/store', 'class'=> 'form-horizontal user-form-border','files' => true, 'method'=>'post', 'id'=>'profile')) !!}
        @endif

        @if(isset($record))
            <input type="hidden" name="id" value="{{$record->id}}">
        @endif

        @if(isset($profile))
            <input type="hidden" name="id" value="{{$profile->id}}">
        @endif

        <div class="form-group">
            <label for="name" class="col-sm-3 control-label left-align label-font">Restaurant Name</label>
            <div class="col-sm-7">
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Restaurant Name" value="{{ isset($profile)? $profile->restaurant_name : Input::old('name') }}"/>
                <p class="text-danger">{{$errors->first('name')}}</p>
            </div>
        </div>

        <div class="form-group">
            <label for="filename"  class="col-sm-3 form-label left-align label-font">Restaurant Logo</label>
            {{--start Logo image path textbox--}}
            <div class="col-sm-7">
                <input type="file" id="browse" class="form-control" onchange="logo();" name="fileupload" style="display: none"/>
                <input type="text" id="logo_filename" name="image" class="form-control" placeholder="Choose Restaurant Logo" readonly="true" value="{{isset($profile)? $profile->logo : Request::old('image')}}"/><br>
                <p class="text-danger">Image Size must be width 240px and height 57px</p>
                @if(isset($profile))
                    @if($profile->logo == "")
                        <img id="img" class="bottom image" style="display:none" src= "../../uploads/{{$profile->logo}}" width="240" height="57">
                    @else
                        <img id="img" class="bottom image" src= "../../uploads/{{$profile->logo}}" width="240" height="57">
                    @endif
                @endif
                <p class="text-danger">{{$errors->first('fileupload')}}</p>
            </div>

            <div class="col-sm-1">
                <span for="camera" class="col-md-1 glyphicon glyphicon-camera camera" onclick="HandleBrowseClickLogo();"></span>
            </div>

        </div>

        <div class="form-group">
            <label for="mobile_filename"  class="col-sm-3 form-label left-align label-font">Mobile Logo</label>
            {{--start Mobile Logo image path textbox--}}
            <div class="col-sm-7">
                <input type="file" id="mobile_browse" class="form-control" onchange="mobile_test();" name="mobile_fileupload" style="display: none"/>

                <input type="text" id="mobile_filename" name="mobile_image" class="form-control" placeholder="Choose Mobile Logo" readonly="true" value="{{isset($profile)? $profile->mobile_logo:Request::old('mobile_image')}}"/><br>

                @if(isset($profile))
                    @if($profile->mobile_logo == "")
                        <img id="mobile_img" class="bottom image" style="display:none" src= "../../uploads/{{$profile->mobile_logo}}" width="240" height="57">
                    @else
                        <img id="mobile_img" class="bottom image" src= "../../uploads/{{$profile->mobile_logo}}" width="240" height="57">
                    @endif
                @endif

                <p class="text-danger">{{$errors->first('mobile_fileupload')}}</p>
            </div>

            <div class="col-sm-1">
                <span for="camera" class="col-md-1 glyphicon glyphicon-camera camera" onclick="mobile_HandleBrowseClick();"></span>
            </div>

        </div>

        <div class="form-group">
            <label for="website" class="col-sm-3 control-label left-align label-font">Restaurant Website</label>
            <div class="col-sm-7">
                <input type="text" class="form-control" id="website" name="website" placeholder="Enter Restaurant Website" value="{{ isset($profile)? $profile->website : Request::old('website') }}"/>
                <p class="text-danger">{{$errors->first('website')}}</p>
            </div>
        </div>

        <div class="form-group">
            <label for="website" class="col-sm-3 control-label left-align label-font">Restaurant Email</label>
            <div class="col-sm-7">
                <input type="text" class="form-control" id="email" name="email" placeholder="Enter Restaurant Email" value="{{ isset($profile)? $profile->email : Request::old('email') }}"/>
                <p class="text-danger">{{$errors->first('email')}}</p>
            </div>
        </div>

        <div class="form-group">
            <label for="phone" class="col-sm-3 control-label left-align label-font">Restaurant Phone</label>
            <div class="col-sm-7">
                <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter Restaurant Phone" value="{{ isset($profile)? $profile->phone : Request::old('phone') }}"/>
                <p class="text-danger">{{$errors->first('phone')}}</p>
            </div>
        </div>

        <div class="form-group">
            <label for="description" class="col-sm-3 form-label left-align label-font">Restaurant Address</label>
            <div class="col-sm-7">
                <textarea class="form-control" id="address" name="address" placeholder="Enter Restaurant Address" rows="7" cols="40">{{isset($profile)? $profile->address:Request::old('address')}}</textarea>
                <p class="text-danger">{{$errors->first('address')}}</p>
            </div>

        </div>

        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-10">
                <input type="submit" name="submit" value="{{isset($profile)? 'UPDATE':'ADD'}}" class="user-button-ok">
                <input type="reset" value="CANCEL" class="user-button-cancel" onclick="profile_cancel()">
            </div>
        </div>
        {!! Form::close() !!}
    </div>
   </div>
</div>
    <script>
        $(function() {
            $('#Category').change(function() {
                var dd = $('#Category').val();
                console.log(dd);
            }).multipleSelect({
                width: '100%'
            });
        });

    </script>

@endsection

