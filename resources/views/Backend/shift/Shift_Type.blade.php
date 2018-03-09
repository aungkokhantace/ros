@extends('Backend/layouts.master')
@section('title',(isset($shift)) ?  'Edit Day Shift' : 'Edit Night Shift')
@section('content')
<div class="content-wrapper">
      <div class="box">
       <div class="box-header">
    
        <h3 class="h3-font"><b>Shift Permission</b></h3>
     </div>
 </div>
        <div class="col-md-8 user-border-left">
        {{--check new or edit--}}
        {!! Form::open(array('url' => 'Backend/Shift/Permission/update', 'class'=> 'form-horizontal user-form-border', 'id'=>'staffTypeEntry')) !!}
        <input type="hidden" name="id" value="{{ $shift->id }}"/>

        <div class="form-group">
            <label for="shift-name" class="col-sm-3 control-label">Shift Name<span class="require">*</span></label>
            <div class="col-sm-7">
                <input type="text" class="form-control" id="shift-name" name="name"
                       value="{{isset($shift)? $shift->name:Input::old('name')}}" disabled />
            </div>
        </div>

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
                <input type="button" value="CANCEL" class="user-button-cancel" onclick="show_shift_list()">
            </div>
        </div>
        {!! Form::close() !!}
    </div>
    </div>
@endsection