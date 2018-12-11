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
         <!-- restaturant session -->
        @if (Auth::guard('Cashier')->user()->restaurant_id == null)
         <div class="form-group">
            <label for="member-type" class="col-sm-3 control-label left-align label-font">Restaurant <span class="require">*</span></label>
            <div class="col-sm-8">                 
                 @if(isset($remark))
                    @foreach($restaurants as $restaurant)
                        @if($restaurant->id == $remark->restaurant_id)
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
     

         <div class="form-group">
            <label for="member-type" class="col-sm-3 control-label left-align label-font">Branch <span class="require">*</span></label>
            <div class="col-sm-8">                 
                 @if(isset($remark))
                    @foreach($branchs as $branch)
                        @if($branch->id == $remark->branch_id)
                         <input type="text" class="form-control" value="{{ $branch->name }}" readonly />
                         <input type="hidden" class="form-control" id="branch" name="branch" value="{{ $branch->id }}" />                         
                       
                        @endif
                    @endforeach                 
                @else
                <select class="form-control" name="branch" id="branch">            
                <option selected disabled>Select Branch </option>
                   
                @endif
                </select>
              
            </div>
        </div>
         @elseif (Auth::guard('Cashier')->user()->branch_id == null || Auth::guard('Cashier')->user()->branch_id == 0 )

        <div class="form-group">
            <label for="member-type" class="col-sm-3 control-label left-align label-font">Branch <span class="require">*</span></label>
            <div class="col-sm-8">                 
                 @if(isset($remark))
                    @foreach($branchs as $branch)
                        @if($branch->id == $remark->branch_id)
                         <input type="text" class="form-control" value="{{ $branch->name }}" readonly />
                         <input type="hidden" class="form-control" id="branch" name="branch" value="{{ $branch->id }}" />                         
                       
                        @endif
                    @endforeach                 
                @else
                <select class="form-control" name="branch" id="branch" >            
                <option selected disabled>Select Branch </option>
                    @foreach($branchs as $branch)
                      <option value="{{$branch->id}}">{{$branch->name}}</option>                
                    @endforeach
                @endif
                </select>
              
            </div>
        </div>
        @endif
        <!--end restaturant session -->
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
<script src="/assets/backend_js/branch/branch.js"></script>

@endsection
