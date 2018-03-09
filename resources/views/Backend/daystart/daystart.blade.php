@extends('cashier.layouts.master')
@section('title','Day Start Listing')
@section('content')
    <div class="row">
        <div class="container">
            <div class="col-md-12">
            <h3 class="font">{{isset($record)? "Edit Item":"Create New Day Start"}}</h3>
            @if (isset($recode))
                {!! Form::open(array('url' => 'Cashier/DayStart/update', 'class'=> 'form-horizontal','id'=>'daystartForm')) !!}
            @else 
                {!! Form::open(array('url' => 'Cashier/DayStart/store', 'class'=> 'form-horizontal','id'=>'daystartForm')) !!}
            @endif
                    <div class="form-group">
                        <label class="col-sm-3 control-label"><b>Date:<span class="require">*</span></b></label>
                        <div class="col-sm-7">
                            
                            <div class="input-group date dateTimePicker" data-provide="datepicker">
                                <input  type="text" class="form-control" id="date1" name="start_date" placeholder="Enter Date Start" >
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </div>
                            </div>
                            <p class="text-danger">{{$errors->first('start_date')}}</p>
                        </div>
                    </div>
                   
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-8 pop-up-linespace">
                            <input type="submit" name="submit" value="ADD" class="user-button-ok">
                            <input type="reset" value="CANCEL" class="user-button-cancel" onclick="day_start_back()" }}>
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
          
        </div>
       
    </div>
@endsection
