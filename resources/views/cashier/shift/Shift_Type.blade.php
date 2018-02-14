@extends('cashier/layouts.master')
@section('title',($shift_name == 'DAY SHIFT') ?  'Edit Day Shift' : 'Edit Night Shift')
@section('content')

    <div class="col-md-8 user-border-left">
        <h3 class="h3-font"><b>{{($shift_name == 'DAY SHIFT') ?  'Edit Day Shift' : 'Edit Night Shift' }}</b></h3>
        {{--check new or edit--}}
        {!! Form::open(array('url' => 'Cashier/Shift/update', 'class'=> 'form-horizontal user-form-border', 'id'=>'staffTypeEntry')) !!}
        <input type="hidden" name="shift" value="{{ $shift_name }}"/>

        <div class="form-group">
            <label for="discount" class="col-sm-3 control-label left-align label-font permission">Category<span class="require">*</span></label>
            <div class="col-sm-7">
                <div class="shift-checkbox">
                @foreach($category as $cat)
                    <div class="col-md-6"> 
                        <input type="checkbox" name="category[]" value="{{ $cat->id }}" @if(in_array($cat->id,$shift_category)) {{ 'checked' }} @endif >&nbsp;&nbsp;{{ $cat->name }}
                    </div>
                @endforeach

                @foreach($setmenu as $set)
                    <div class="col-md-6"> 
                        <input type="checkbox" name="setmenu[]" value="{{ $set->id }}" @if(in_array($set->id,$shift_setmenu)) {{ 'checked' }} @endif>&nbsp;&nbsp;{{ $set->set_menus_name }}
                    </div>
                @endforeach
                <div class="clear"></div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="discount" class="col-sm-3 control-label left-align label-font permission">Users<span class="require">*</span></label>
            <div class="col-sm-7">
                <div class="shift-checkbox">
                @foreach($users as $user)
                    <div class="col-md-6"> 
                        <input type="checkbox" name="user[]" value="{{ $user->id }}" @if(in_array($user->id,$shift_user)) {{ 'checked' }} @endif>&nbsp;&nbsp;{{ $user->user_name }}
                    </div>
                @endforeach
                <div class="clear"></div>
                </div>
            </div>
        </div>

         <div class="form-group">
            <div class="col-sm-8 col-sm-offset-3">
                <input type="submit" name="submit" value="Update" class="user-button-ok">
                <input type="button" value="CANCEL" class="user-button-cancel" onclick="shift_cancel()">
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection