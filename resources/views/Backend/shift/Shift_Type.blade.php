@extends('Backend/layouts.master')
@section('title',(isset($shift)) ?  'Edit Day Shift' : 'Edit Night Shift')
@section('content')
<div class="content-wrapper">
      <div class="box">
       <div class="box-header">

        <h3 class="h3-font"><b>Shift Permission</b></h3>
     </div>
 </div>
        <div class="col-md-10 user-border-left">
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
                        <input type="checkbox" name="category[]" id="cat_{{$cat->id}}" value="{{ $cat->id }}" @if(in_array($cat->id,$shift_category)) {{ 'checked' }} @endif > <label for="cat_{{$cat->id}}">&nbsp;&nbsp;{{ $cat->name }}</label>
                    </div>
                @endforeach

                @foreach($setmenu as $set)
                    <div class="col-md-6">
                        <input type="checkbox" name="setmenu[]" id="set_{{$set->id}}" value="{{ $set->id }}" @if(in_array($set->id,$shift_setmenu)) {{ 'checked' }} @endif> <label for="set_{{$set->id}}">&nbsp;&nbsp;{{ $set->set_menus_name }}</label>
                    </div>
                @endforeach
                <div class="clear"></div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="discount" class="col-sm-3 control-label left-align label-font permission">Staff<span class="require">*</span></label>
            <div class="col-sm-7">
                <div class="shift-checkbox">
                @if(count($users) > 0)
                <div class="col-md-12">
                    <input type="checkbox" id="select_all_user"><label for="select_all_user"><b>SELECT ALL</b></label>
                </div>
                @else
                <div class="col-md-12">
                    <span>No Staff To Display</span>
                </div>
                @endif
                @foreach($users as $user)
                    <div class="col-md-6">
                        <input type="checkbox" name="user[]" id="staff_{{ $user->id }}" value="{{ $user->id }}" @if(in_array($user->id,$shift_user)) {{ 'checked' }} @endif />
                        <label for="staff_{{ $user->id }}">&nbsp;&nbsp;[ ID : {{ $user->staff_id }} ] {{ $user->user_name }}</label>

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
    <script>
$(document).ready(function(){
    $('#select_all_user').change(function() {
    if($(this).is(':checked')) {
        $("input[name='user[]']").attr('checked', 'checked');
    } else {
        $("input[name='user[]']").removeAttr('checked');
    }
});
$("input[name='user[]']").not('#select_all').change( function() {
    $('#select_all_user').removeAttr('checked');
});
});
</script>
@endsection
