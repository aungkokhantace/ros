@extends('cashier.layouts.master')
@section('title',isset($module)?'Edit Permission':'New Permission')
@section('content')

    <div class="col-md-8">
        {{--title--}}
        <div id="cust"><b>{{isset($module)? "Edit Permission":"Create Permission"}}</b></div>
        {{--title--}}
        <br/>
        @if(isset($module))
            {!! Form::open(array('url' => 'Cashier/Permission/update', 'method' => 'post', 'files' => true, 'class'=> 'form-horizontal', 'id'=>'permission-validate')) !!}
        @else
            {!! Form::open(array('url' => 'Cashier/Permission/store', 'method' => 'post', 'files' => true, 'class'=> 'form-horizontal', 'id'=>'permission-validate')) !!}
        @endif

        @if(isset($module))
            <input type="hidden" name="id" value={{$module->id}}>
        @endif

        <div class="form-group">
            <label for="item-name" class="col-sm-3 control-label">Module<span class="require">*</span></label>
            <div class="col-sm-7">
                <input type="text" class="form-control" id="module_name" name="module_name" placeholder="Enter Module Name"
                       value="{{isset($module)? $module->module:Input::old('module_name')}}" />
                <p class="text-danger">{{$errors->first('module_name')}}</p>
            </div>
        </div>

        {{--End item Status--}}
        <div class="form-group">
            <div class="col-sm-7 col-sm-offset-3">
                <input type="submit" name="submit" value="{{isset($module)? 'UPDATE' : 'ADD'}}" class="user-button-ok"> {{--Add Button--}}
                <input type="reset" value="CANCEL" class="user-button-cancel" onclick="permission_cancel();"> {{--Cancel Button--}}
            </div>
        </div>
        {!! Form::close() !!}
    </div>

@endsection