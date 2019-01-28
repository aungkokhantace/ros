@extends('Backend/layouts.master')
@section('title',isset($branch)?'Edit branch':'New branch')
@section('content')
<div class="content-wrapper">
      <div class="box">
       <div class="box-header">
    
        <h3 class="h3-font"><b>{{isset($branch) ?  'Edit branch' : 'Create New branch' }}</b></h3>
      </div>
  </div>
     <div class="container">
      <div class="col-md-8 user-border-left">
        {{--check new or edit--}}
        @if(isset($branch))
            {!! Form::open(array('url' => 'Backend/Branch/update', 'class'=> 'form-horizontal user-form-border','id'=>'branch')) !!}
        @else
            {!! Form::open(array('url' => 'Backend/Branch/store', 'class'=> 'form-horizontal user-form-border','id'=>'branch')) !!}
        @endif

        <input type="hidden" name="id" value="{{isset($branch)? $branch->id:''}}"/>

                                      <!-- restaturant session -->
        @if (Auth::guard('Cashier')->user()->restaurant_id == null)
         <div class="form-group">
            <label for="member-type" class="col-sm-3 control-label left-align label-font">Restaurant <span class="require">*</span></label>
            <div class="col-sm-7">                 
                 @if(isset($branch))
                    @foreach($restaurants as $restaurant)
                        @if($restaurant->id == $branch->restaurant_id)
                         <input type="text" class="form-control" value="{{ $restaurant->name }}" readonly />
                         <input type="hidden" class="form-control" id="restaurant" name="restaurant" value="{{ $restaurant->id }}" />                         
                       
                        @endif
                    @endforeach                 
                @else
                <select class="form-control" name="restaurant" id="restaurant">            
                <option selected disabled>Select Restaurant </option>
                    @foreach($restaurants as $restaurant)
                      <option value="{{$restaurant->id}}">{{$restaurant->name}}</option>                
                    @endforeach
                @endif
                </select>
              
            </div>
        </div>
     

        @endif
        <!--end restaturant session -->

        <div class="form-group">
            <label for="branch_name" class="col-sm-3 control-label left-align label-font">Name<span class="require">*</span></label>
            <div class="col-sm-7">
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="{{ isset($branch)? $branch->name:Request::old('name') }}"/>
                <p class="text-danger">{{$errors->first('name')}}</p>
            </div>
        </div>

         <div class="form-group">
            <label for="description" class="col-sm-3 control-label left-align label-font">Description</label>
            <div class="col-sm-7">
                <textarea class="form-control" id="item-description" name="description" placeholder="Enter Branch Description" rows="7" cols="40">{{isset($branch)? $branch->description:Input::old('description')}}</textarea>
                <p class="text-danger">{{$errors->first('description')}}</p>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-8 col-sm-offset-3">
                <input type="submit" name="submit" value="{{isset($branch)? 'UPDATE' : 'ADD'}}" class="user-button-ok">
                <input type="button" value="CANCEL" class="user-button-cancel" onclick="branch_cancel();">
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
</div>

@endsection