@extends('Backend/layouts.master')
@section('title',isset($remark)?'Edit remark':'New Remark')
@section('content')
<div class="content-wrapper">
      <div class="box">
       <div class="box-header">
    
        <h3 class="h3-font"><b>{{isset($remark) ?  'Edit' : 'New' }}</b></h3>
     </div>
</div> 
       <div class="container">

        <div class="col-md-8 user-border-left">
        {{--check new or edit--}}
        @if(isset($remark))
            {!! Form::open(array('url' => 'Backend/Remark/update', 'class'=> 'form-horizontal user-form-border','id'=>'remarkForm')) !!}
        @else
            {!! Form::open(array('url' => 'Backend/Remark/store', 'class'=> 'form-horizontal user-form-border','id'=>'remarkForm')) !!}
        @endif

        <input type="hidden" name="id" value="{{isset($remark)? $remark->id:''}}"/>
        <div class="form-group">
            <label for="member-type" class="col-sm-3 control-label left-align label-font">Remark Name<span class="require">*</span></label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="remark_name" name="remark_name" placeholder="Enter remark Name" value="{{ isset($remark)? $remark->name:Request::old('remark_name') }}"/>
                <p class="text-danger">{{$errors->first('remark_name')}}</p>
            </div>
        </div>
         <div class="form-group">
            <label for="description" class="col-sm-3 form-label left-align label-font">Description</label>
            <div class="col-sm-8">
                <textarea class="form-control" id="Category-description" name="description" placeholder="Enter Category Description" rows="7" cols="40">{{isset($remark)? $remark->description:Input::old('description')}}</textarea>
                <p class="text-danger">{{$errors->first('description')}}</p>
            </div>
        </div>

        

        <div class="form-group">
            <div class="col-sm-8 col-sm-offset-3">
                <input type="submit" name="submit" value="{{isset($remark)? 'UPDATE' : 'ADD'}}" class="user-button-ok">
                <input type="button" value="CANCEL" class="user-button-cancel" onclick="remark_cancel();">
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
</div>
@endsection