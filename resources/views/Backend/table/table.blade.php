@extends('Backend.layouts.master')
@section('title',isset($tables)?'Edit Table':'New Table')
@section('content')
<div class="content-wrapper">
      <div class="box">
       <div class="box-header">
    
        <h3 class="h3-font"><b>{{isset($tables) ?  'Edit Table' : 'Create New Table' }}</b></h3>
     </div>
 </div>
        <div class="container">
        <div class="col-md-8 user-border-left">
        @if(isset($tables))
            {!! Form::open(array('url' => 'Backend/Table/update','class' => 'form-horizontal user-form-border', 'id'=>'table-form-entry')) !!}
        @else
            {!! Form::open(array('url' => 'Backend/Table/store','class' => 'form-horizontal user-form-border','id'=>'table-form-entry')) !!}
        @endif
        <input type="hidden" name="id" value="{{isset($tables)? $tables->id:''}}">
        <div class="form-group">
            <label for="member-type" class="col-sm-3 control-label left-align label-font">Table No<span class="require">*</span> </label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="table" name="table_no" placeholder="Enter table name" value="{{ isset($tables)? $tables->table_no:Request::old('table_no') }}"/>
                <p class="text-danger">{{$errors->first('table_no')}}</p>
            </div>
        </div>

         <!-- <div class="form-group ">
            <label for="description" class="col-sm-3 control-label left-align label-font">Capacity<span class="require">*</span></label>
            <div class="col-sm-7">
                <input type="text" class="form-control" name="capacity"  placeholder="Enter capacity" value="{{ isset($tables)? $tables->capacity:Request::old('capacity') }}">
                <p class="text-danger">{{$errors->first('capacity')}}</p>
            </div>
        </div>  -->

        <div class="form-group ">
            <label for="description" class="col-sm-3 control-label left-align label-font">Capacity<span class="require">*</span></label>
            <div class="col-sm-8">
                <select name="capacity" class="form-control">
                @if(isset($tables))
                    <option value="1" @if ($tables->capacity == '1') {{"selected"}} @endif >1</option>
                    <option value="2" @if ($tables->capacity == '2') {{"selected"}} @endif >2</option>
                    <option value="3" @if ($tables->capacity == '3') {{"selected"}} @endif>3</option>
                    <option value="4" @if ($tables->capacity == '4') {{"selected"}} @endif >4</option>
                    <option value="5" @if ($tables->capacity == '5') {{"selected"}} @endif>5</option>
                    <option value="6" @if ($tables->capacity == '6') {{"selected"}} @endif>6</option>
                    <option value="7" @if ($tables->capacity == '7') {{"selected"}} @endif>7</option>
                    <option value="8" @if ($tables->capacity == '8') {{"selected"}} @endif>8</option>
                    <option value="9" @if ($tables->capacity == '9') {{"selected"}} @endif>9</option>
                    <option value="10" @if ($tables->capacity == '10') {{"selected"}} @endif>10</option>
                @else
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                @endif
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="description" class="col-sm-3 control-label left-align label-font">Location<span class="require">*</span></label>
            <div class="col-sm-8">
                <select name="location" class="form-control">
                    @foreach($locations as $location)
                        @if(isset($tables))
                            @if($tables->location_id == $location->id)
                                <option value="{{$location->id}}" selected>{{ $location->location_type}}</option>
                            @else
                                <option value="{{$location->id}}">{{ $location->location_type}}</option>
                            @endif
                        @else
                            <option value="{{$location->id}}" {{ (Input::old("location") == $location->id ? "selected":"") }}>{{ $location->location_type}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group ">
            <label for="area" class="col-sm-3 control-label left-align label-font">Area<span class="require">*</span></label>
            <div class="col-sm-7">
                @if(isset($tables))
                    @if($tables->area == 'Smoking')
                        <input type="radio" name="area" value="Smoking" checked>Smoking
                    @else
                        <input type="radio" name="area" value="Smoking">Smoking
                    @endif
                    @if($tables->area == 'Non-Smoking')
                        <input type="radio" name="area" value="Non-Smoking" checked>Non-Smoking
                    @else
                         <input type="radio" name="area" value="Non-Smoking">Non-Smoking
                    @endif
                @else
                    <input type="radio" name="area" value="Smoking" checked>Smoking
                    <input type="radio" name="area" value="Non-Smoking">Non-Smoking
                @endif
                <p class="text-danger">{{$errors->first('area')}}</p>
            </div>
        </div>
        <div class="col-sm-8 col-sm-offset-3">
            <input type="submit" name="submit" value="{{isset($tables)? 'UPDATE':'ADD'}}" class="user-button-ok">
            <input type="reset" value="CANCEL" class="user-button-cancel" onclick="table_cancel()">
        </div>

        {!! Form::close() !!}

    </div>
</div>
</div>
    <script>
        //to select only one checkbox
        $('.one-check input:checkbox').click(function(){
            $('.one-check input:checkbox').not(this).prop('checked',false);
        });
    </script>
@endsection