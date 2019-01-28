@extends('Backend/layouts.master')
@section('title',isset($user) ?  'Edit Staff' : 'New Staff')
@section('content')
  <div class="content-wrapper">
      <div class="box">
       <div class="box-header">
        <div class="row">
         
        <h3 class="h3-font User_list"><b>{{isset($user) ?  'Edit Staff' : 'Create New Staff' }}</b></h3>


    </div>
  </div>
</div>
   <div class="container">    
        {{--check new or edit--}}
        @if(isset($user))
            {!! Form::open(array('url' => 'Backend/Staff/update', 'class'=> 'form-horizontal user-form-border','id' => 'staffEditForm','autocomplete'=>'off')) !!}

        @else
            {!! Form::open(array('url' => 'Backend/Staff/store', 'class'=> 'form-horizontal user-form-border','id' => 'staffEntryForm','autocomplete'=>'off')) !!}
        @endif

         <input type="hidden" name="id" id ="user" value="{{isset($user)? $user->id:''}}"/>
         <div class="form-group">            
            <label for="discount" class="col-sm-3 control-label left-align label-font">Staff Type<span class="require">*</span></label>
            <div class="col-sm-7">
              @if(isset($user))    
                 @foreach($roles as $role)
                      @if(($role->id == $user->role_id))
                         <input type="text" class="form-control " id="userType" name="userType" value="{{ $user->roles->name }}" readonly />       
                         @endif
                    @endforeach
                    <!-- </select> -->
                @else
                    <select class="form-control" name="userType" id="userType">
                        <option value="" selected disabled>Select Staff Type</option>

                        @foreach($roles as $role)
                            <option value="{{$role->id }}" {{ (old('userType') == $role->id) ? "selected": ""}}>{{$role->name}}</option>
                        @endforeach
                    </select>
                @endif
                <p class="text-danger">{{$errors->first('userType')}}</p>
            </div>
        </div>        
        @include ('Backend/restaurant_branch/branch_layout')
        <div class="form-group">
            <label for="member-type" class="col-sm-3 control-label left-align label-font">Staff Name<span class="require">*</span></label>
            <div class="col-sm-7">
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Staff Name" value="{{ isset($user)? $user->user_name:Request::old('name') }}"/>
                <p class="text-danger">{{$errors->first('name')}}</p>
            </div>
        </div>
        @if(!isset($user))
        <div class="form-group">
            <label for="discount" class="col-sm-3 control-label left-align label-font">Password<span class="require">*</span></label>
            <div class="col-sm-7">
                <input type="password" class="form-control" id="login_password" name="login_password" autocomplete="off"
                       placeholder="Enter Password"/>

                <p class="text-danger">{{$errors->first('login_password')}}</p>
            </div>
        </div>
        <div class="form-group">
            <label for="discount" class="col-sm-3 control-label left-align label-font">Confirm Password<span class="require">*</span></label>
            <div class="col-sm-7">
                <input type="password" class="form-control" id="conpassword" name="conpassword" placeholder="Enter Confirm Password"/>
                <p class="text-danger">{{$errors->first('conpassword')}}</p>
            </div>
        </div>
        @endif
       

        {{--when the form is edit form and the user type is kitchen, the kitchen dropdown will be shown--}}
        @if((isset($user)) && ($user->roles->name == "Kitchen"))
            <div class="form-group" id="kitchen" style="display: block;">
        @else
            <div class="form-group" id="kitchen" style="display: none;">
        @endif
        <label for="kitchen" class="col-sm-3 control-label left-align label-font">Kitchen<span class="require">*</span></label>
        <div class="col-sm-7">
                @if(isset($user))
                    <select class="form-control" name="kitchen">
                        @foreach($kitchens as $kitchen)
                            @if($kitchen->id == $user->kitchen_id)
                                <option value="{{$user->kitchen_id}}" selected>{{$user->kitchen->name}}</option>
                            @else
                                <option value="{{$kitchen->id}}">{{$kitchen->name}}</option>
                            @endif
                        @endforeach
                    </select>
                @else
                    <select class="form-control" name="kitchen">

                        @foreach($kitchens as $kitchen)
                            <option value="{{$kitchen->id}}">{{$kitchen->name}}</option>
                        @endforeach
                    </select>
                @endif
                <p class="text-danger">{{$errors->first('kitchen')}}</p>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-8 col-sm-offset-3">
                <input type="submit" name="submit" value="{{isset($user)? 'Update' : 'ADD'}}" class="user-button-ok">
                <input type="button" value="CANCEL" class="user-button-cancel" onclick="user_cancel()">
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
</div>
<script>
        $("#userType").change(function(){
//            var tmp=$('#userType').val();
            var tmp=$(this).find("option:selected").text();
            console.log(tmp);
            if(tmp == "Kitchen"){
                $('#kitchen').show();
            }
            else{
                $('#kitchen').hide();
            }
             if(tmp == "Super Admin"){
                
                $('.branch').hide();
                $('.restaurant').show();
            }
            else{    
                $('.branch').show();
                $('.restaurant').hide();
            }
        });



        if($("#user").val()  !== null ){
            console.log($("#user").val());
            var restaurant =$('#restaurant').val();
            var branch =$('#branch').val();
            if(restaurant !== 0){
                $('.restaurant').hide();
            }
            else{
                $('.restaurant').show();
            }
             if(branch !== 0){
                $('.branch').hide();
            }
            else{
                $('.branch').show();
            }

        }

</script>
<script src="/assets/backend_js/branch/branch.js"></script>
@endsection
