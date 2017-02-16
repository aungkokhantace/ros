@extends('cashier.layouts.master')
@section('title','Profile')
@section('content')
    <div class="container">
        <div class="row">
            {{--heading title--}}
            <div class="col-md-12">
                <div class="col-md-3">
                    <h3 class="h3 list-heading-align"><strong>Change Password</strong></h3>
                    @if(count(Session::get('message')) != 0)
                        <div ></div>
                    @endif
                </div>
                <div class="col-md-9 ">
                    
                </div>
            </div>

        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-12 tbl-container">
               
                {!! Form::open(array('url' => 'Cashier/Password/Change', 'class'=> 'form-horizontal user-form-border','id' => 'profileEditForm','autocomplete'=>'off')) !!}
                    <input type="hidden" name="staff_id" value="{{ $user->id}}"/>
                    <div class="form-group">
                        <label for="discount" class="col-sm-3 control-label left-align label-font">Name<span class="require">*</span></label>
                        <div class="col-sm-7">
                            <input type="test" class="form-control" id="staff_name" name="staff_name" autocomplete="off" value="{{ $user->user_name }}" readonly />
                        </div>
                    </div>
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
                    <div class="form-group">
                    <div class="col-sm-8 col-sm-offset-3">
                        <input type="submit" name="submit" value="Update" class="user-button-ok">
                        <input type="button" value="CANCEL" class="user-button-cancel" onclick="user_cancel()">
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
