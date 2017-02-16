@extends('cashier.layouts.master')
@section('title',isset($tables)?'Edit Table':'New Table')
@section('content')
    <div class="col-md-8 user-border-left">
        <h3 class="h3-font"><b>{{isset($tables) ?  'Edit Table' : 'Create New Table' }}</b></h3>
        @if(isset($tables))
            {!! Form::open(array('url' => 'Cashier/Table/update','class' => 'form-horizontal user-form-border', 'id'=>'table-form-entry')) !!}
        @else
            {!! Form::open(array('url' => 'Cashier/Table/store','class' => 'form-horizontal user-form-border','id'=>'table-form-entry')) !!}
        @endif
        <input type="hidden" name="id" value="{{isset($tables)? $tables->id:''}}">
        <div class="form-group">
            <label for="member-type" class="col-sm-3 control-label left-align label-font">Table No<span class="require">*</span> </label>
            <div class="col-sm-7">
                <input type="text" class="form-control" id="table" name="table_no" placeholder="Enter table name" value="{{ isset($tables)? $tables->table_no:Request::old('table_no') }}"/>
                <p class="text-danger">{{$errors->first('table_no')}}</p>
            </div>
        </div>

        <div class="form-group ">
            <label for="description" class="col-sm-3 control-label left-align label-font">Capacity<span class="require">*</span></label>
            <div class="col-sm-7">
                <input type="text" class="form-control" name="capacity"  placeholder="Enter capacity" value="{{ isset($tables)? $tables->capacity:Request::old('capacity') }}">
                <p class="text-danger">{{$errors->first('capacity')}}</p>
            </div>
        </div>
        <div class="form-group">
            <label for="description" class="col-sm-3 control-label left-align label-font">Location<span class="require">*</span></label>
            <div class="col-sm-7">
                <select name="location" class="form-control">
                    @foreach($locations as $location)
                        @if(isset($tables))
                            @if($tables->location_id == $location->id)
                                <option value="{{$location->id}}" selected>{{ $location->location_type}}</option>
                            @else
                                <option value="{{$location->id}}">{{ $location->location_type}}</option>
                            @endif
                        @else
                            <option value="{{$location->id}}">{{ $location->location_type}}</option>
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
    <script>
        //to select only one checkbox
        $('.one-check input:checkbox').click(function(){
            $('.one-check input:checkbox').not(this).prop('checked',false);
        });
    </script>
@endsection