@extends('Backend/layouts.master')
@section('title',isset($kitchen)?'Edit Kitchen':'New Kitchen')
@section('content')
  <div class="content-wrapper">
      <div class="box">
       <div class="box-header">
    <div class="col-md-8 user-border-left">
        <h3 class="h3-font"><b>{{isset($kitchen) ?  'Edit Kitchen' : 'Create New Kitchen' }}</b></h3>
     </div>
 </div>
</div>

 <div class="container">
        {{--check new or edit--}}
        @if(isset($kitchen))
            {!! Form::open(array('url' => 'Backend/Kitchen/update', 'class'=> 'form-horizontal user-form-border','id'=>'kitchenForm')) !!}
        @else
            {!! Form::open(array('url' => 'Backend/Kitchen/store', 'class'=> 'form-horizontal user-form-border','id'=>'kitchenForm')) !!}
        @endif

        <input type="hidden" name="id" value="{{isset($kitchen)? $kitchen->id:''}}"/>
        @if (Auth::guard('Cashier')->user()->role_id == 1)
        <div class="form-group">
            <label for="member-type" class="col-sm-2 control-label left-align label-font">Branch <span class="require">*</span></label>
            <div class="col-sm-7">                 
                 @if(isset($kitchen))
                    @foreach($branchs as $branch)
                        @if($branch->id == $kitchen->branch_id)
                         <input type="text" class="form-control" value="{{ $branch->name }}" readonly />
                         <input type="hidden" class="form-control" id="branch" name="branch" value="{{ $branch->id }}" />                         
                       
                        @endif
                    @endforeach                 
                @else
                <select class="form-control" name="branch">            
                <option selected disabled>Select Branch </option>
                    @foreach($branchs as $branch)
                      <option value="{{$branch->id}}">{{$branch->name}}</option>                
                    @endforeach
                @endif
                </select>
              
            </div>
        </div>
        @endif
        <div class="form-group">
            <label for="kitchen_name" class="col-sm-2 control-label left-align label-font">Kitchen Name<span class="require">*</span></label>
            <div class="col-sm-5">
                <input type="text" class="form-control" id="kitchen_name" name="name" placeholder="Enter Kitchen Name" value="{{ isset($kitchen)? $kitchen->name:Request::old('kitchen_name') }}"/>
                <p class="text-danger">{{$errors->first('name')}}</p>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-6 col-sm-offset-2">
                <input type="submit" name="submit" value="{{isset($kitchen)? 'UPDATE' : 'ADD'}}" class="user-button-ok">
                <input type="button" value="CANCEL" class="user-button-cancel" onclick="kitchen_cancel();">
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
</div>
@endsection