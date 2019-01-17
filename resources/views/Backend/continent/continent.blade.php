@extends('Backend/layouts.master')
@section('title',isset($continent)?'Edit continent':'New Continent')
@section('content')
<div class="content-wrapper">
      <div class="box">
       <div class="box-header">
    
        <h3 class="h3-font"><b>{{isset($continent) ?  'Edit Continent' : 'Setup New Continent' }}</b></h3>
     </div>
</div> 
       <div class="container">

        <div class="col-md-8 user-border-left">
        {{--check new or edit--}}
        @if(isset($continent))
            {!! Form::open(array('url' => 'Backend/Continent/update', 'class'=> 'form-horizontal user-form-border','id'=>'continentForm')) !!}
        @else
            {!! Form::open(array('url' => 'Backend/Continent/store', 'class'=> 'form-horizontal user-form-border','id'=>'continentForm')) !!}
        @endif

        <input type="hidden" name="id" value="{{isset($continent)? $continent->id:''}}"/>
        <div class="form-group">
            <label for="member-type" class="col-sm-3 control-label left-align label-font">Continent Name<span class="require">*</span></label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="continent_name" name="continent_name" placeholder="Enter Continent Name" value="{{ isset($continent)? $continent->name:Request::old('continent_name') }}"/>
                <p class="text-danger">{{$errors->first('continent_name')}}</p>
            </div>
        </div>
        <div class="form-group">
            <label for="items" class="col-sm-3 control-label left-align label-font">Category<span class="require">*</span></label>
            <div class="col-sm-8">
             <div>
                <select name="category[]" id="Category" multiple="multiple" class=col-md-12>
                        @foreach($categories as $category)
                        <option value="{{$category['id']}}" @if(isset($continent) && $continent->category_continent->contains($category['id'])){{'selected'}}@endif>{{$category['name']}}</option>
                        @endforeach
                </select>
                <p class="text-danger" id="items_err">{{ $errors->first("category[]") }}</p>
                </div>
            </div>
        </div>
         <div class="form-group">
            <label for="description" class="col-sm-3 form-label left-align label-font">Description</label>
            <div class="col-sm-8">
                <textarea class="form-control" id="Category-description" name="description" placeholder="Enter Category Description" rows="7" cols="40">{{isset($continent)? $continent->description:Input::old('description')}}</textarea>
                <p class="text-danger">{{$errors->first('description')}}</p>
            </div>
        </div>

        

        <div class="form-group">
            <div class="col-sm-8 col-sm-offset-3">
                <input type="submit" name="submit" value="{{isset($continent)? 'UPDATE' : 'ADD'}}" class="user-button-ok">
                <input type="button" value="CANCEL" class="user-button-cancel" onclick="continent_cancel();">
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
</div>
@endsection