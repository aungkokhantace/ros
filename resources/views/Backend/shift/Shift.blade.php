@extends('Backend.layouts.master')
@section('title',isset($shift)?'Edit Shift':'New Shift')
@section('content')
<div class="content-wrapper">
      <div class="box">
       <div class="box-header">
        <div class="row">
   
        {{--title--}}
        <h3 class="font">{{isset($shift)? "Edit Shift":"Create New Shift"}}</h3>
        {{--title--}}
    </div>
   </div>
  
    <div class="col-md-8" style="margin-top:30px">
         <div class="container">
        @if(isset($shift))
            {!! Form::open(array('url' => 'Backend/Shift/update', 'method' => 'post','class'=> 'form-horizontal', 'id'=>'shift-validate')) !!}
        @else
            {!! Form::open(array('url' => 'Backend/Shift/store', 'method' => 'post','class'=> 'form-horizontal', 'id'=>'shift-validate', 'onsubmit' => 'return validate();')) !!}
        @endif

        @if(isset($shift))
        <input type="hidden" name="id" value="{{$shift->id}}">
        @endif

        <!-- For Restaurant -->
            @if (Auth::guard('Cashier')->user()->restaurant_id == null)
                <div class="form-group">
                    <label for="item-restaurant" class="col-sm-3 control-label left-align label-font">Restaurant <span class="require">*</span></label>
                    <div class="col-sm-7">
                        @if(isset($shift))
                            @foreach($restaurants as $restaurant)
                                @if($restaurant->id == $shift->restaurant_id)
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
                            </select>
                        @endif
                    </div>
                </div>
                <!--end restaurant -->
                <!--For branch-->
                <div class="form-group">
                    <label for="item-branch" class="col-sm-3 control-label left-align label-font">Branch <span class="require">*</span></label>
                    <div class="col-sm-7">
                        @if(isset($shift))
                            @foreach($branchs as $branch)
                                @if($branch->id == $shift->branch_id)
                                    <input type="text" class="form-control" value="{{ $branch->name }}" readonly />
                                    <input type="hidden" class="form-control" id="branch" name="branch" value="{{ $branch->id }}" />

                                @endif
                            @endforeach
                        @else
                            <select class="form-control" name="branch" id="branch">
                                <option selected disabled>Select Restaurant </option>
                                @foreach($branchs as $branch)
                                    <option value="{{$branch->id}}">{{$branch->name}}</option>
                                @endforeach
                            </select>
                        @endif
                    </div>
                </div>
            @endif
        <!--end branch -->
        <div class="form-group">
            <label for="item-name" class="col-sm-3 control-label">Shift Name<span class="require">*</span></label>
            <div class="col-sm-7">
                <input type="text" class="form-control" id="shift-name" name="name" placeholder="Enter Shift Name"
                       value="{{isset($shift)? $shift->name:Input::old('name')}}" />
                <p class="text-danger">{{$errors->first('name')}}</p>
            </div>
        </div>

        <div class="form-group">
            <label for="item-description" class="col-sm-3 control-label">Shift Description<span class="require">*</span></label>
            <div class="col-sm-7">
                <textarea class="form-control" id="shift-description" name="description" placeholder="Enter Shift Description" rows="7" cols="40">{{isset($shift)? $shift->description:Input::old('description')}}</textarea>
                <p class="text-danger">{{$errors->first('description')}}</p>
            </div>
        </div>

        {{--End item Status--}}
        <div class="form-group">
            <div class="col-sm-7 col-sm-offset-3">
                <input type="submit" name="submit" value="{{isset($shift)? 'UPDATE' : 'ADD'}}" class="user-button-ok"> {{--Add Button--}}
                <input type="reset" value="CANCEL" class="user-button-cancel" onclick="show_shift_list();"> {{--Cancel Button--}}
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
</div>
</div>
<script src="/assets/backend_js/branch/branch.js"></script>
<script type="text/javascript">
    $("#branch").change(function(){
        var branch     =$("#branch").val();
        var restaurant = $("#restaurant").val();
        $.ajax({
            type: "GET",

            url: "/Backend/get_addon/ajaxRequest/"+branch+"/"+restaurant,

        }).done( function(data){
            $('#product').empty();
            $('#product').append("<option disabled selected>Select Category</option>");
            $(data).each(function(){
                // console.log(this.id,this.name);
                $('#product').append($('<option>',{
                    value : this.id,
                    text: this.name,
                }));
            })

        })

    });
</script>
@endsection