@extends('cashier/layouts.master')
@section('title',isset($roles) ?  'Edit Staff Type' : 'New Staff Type')
@section('content')
    <div class="col-md-8 user-border-left">
        <h3 class="h3-font"><b>{{isset($roles) ?  'Edit Staff Type' : 'Create New StaffType' }}</b></h3>
        {{--check new or edit--}}
        @if(isset($roles))
            {!! Form::open(array('url' => 'Cashier/StaffType/update', 'class'=> 'form-horizontal user-form-border', 'id'=>'staffTypeEntry')) !!}
        @else
            {!! Form::open(array('url' => 'Cashier/StaffType/store', 'class'=> 'form-horizontal user-form-border', 'id'=>'staffTypeEntry')) !!}
        @endif
        <input type="hidden" name="id" value="{{isset($roles)? $roles->id:''}}"/>
        <div class="form-group">
            <label for="member-type" class="col-sm-3 control-label left-align label-font">Staff Type Name<span class="require">*</span></label>
            <div class="col-sm-7">
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Staff Type Name"
                       value="{{ isset($roles)? $roles->name:Request::old('name') }}"/>
                <p class="text-danger">{{$errors->first('name')}}</p>
            </div>
        </div>

        <div class="form-group">
            <label for="discount" class="col-sm-3 control-label left-align label-font permission">Permission<span class="require">*</span></label>
            <div class="col-sm-7">
                <div class="checkbox">
                    @if(isset($roles))
                        <!-- For Cashier View:<br/> -->
                           @foreach($modules as $module)
                                @if($module->view == 'cashier')
                                    @if(in_array($module->id,$permissions))
                                        <div class="col-md-6"> 
                                            <input type="checkbox" name="permission[]" checked
                                               value="{{$module->id}}">{{$module->module}}
                                        </div>   
                                    @else
                                        <div class="col-md-6">
                                            <input type="checkbox" name="permission[]"
                                           value="{{$module->id}}">{{$module->module}}
                                        </div>   
                                    @endif
                                @else

                            @endif

                        @endforeach

                        <!-- <br/><br/>For Kitchen View::<br/> -->
                        @foreach($modules as $module)
                            @if($module->view != 'cashier')
                                @if(in_array($module->id,$permissions))
                                    <div class="col-md-6">
                                        <input type="checkbox" name="permission[]" checked
                                           value="{{$module->id}}">{{$module->module}}
                                    </div>       
                                @else
                                    <div class="col-md-6">
                                        <input type="checkbox" name="permission[]"
                                           value="{{$module->id}}">{{$module->module}}
                                    </div>       
                                @endif
                            @else

                            @endif

                        @endforeach
                    @else
                        <!-- For Cashier View:<br/> -->
                        @foreach($modules as $module)
                           @if($module->view == 'cashier')
                               <div class="col-md-6">
                                    <input type="checkbox" name="permission[]"
                               value="{{$module->id}}">{{$module->module}}
                               </div>
                           @endif
                        @endforeach

                        <!-- <br/><br/>For Kitchen View::<br/> -->
                        @foreach($modules as $module)
                            @if($module->view != 'cashier')
                                <div class="col-md-6">
                                    <input type="checkbox" name="permission[]"
                                value="{{$module->id}}">{{$module->module}}
                                </div>
                            @endif
                        @endforeach

                            <p class="text-danger">{{$errors->first('permission')}}</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="description" class="col-sm-3 control-label left-align label-font">Description<span class="require">*</span></label>
            <div class="col-sm-7">
                <textarea class="form-control" id="description" name="description" placeholder="Enter Description" rows="7" cols="40">{{ isset($roles)? $roles->description:Request::old('description') }}</textarea>
                <p class="text-danger">{{$errors->first('description')}}</p>
            </div>
        </div>
         <div class="form-group">
            <div class="col-sm-8 col-sm-offset-3">
                <input type="submit" name="submit" value="{{isset($roles)? 'Update' : 'ADD'}}" class="user-button-ok">
                <input type="button" value="CANCEL" class="user-button-cancel" onclick="role_cancel()">
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection