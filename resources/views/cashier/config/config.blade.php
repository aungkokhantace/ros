@extends('cashier.layouts.master')
@section('title',isset($config)?'Edit General Setting':'New General Setting')
@section('content')

    <div class="col-md-12 user-border-left">
        <ul class="nav nav-tabs">
            <li role="presentation" class="active"><a href="#">General Setting</a></li>
            <li role="presentation"><a href="/Cashier/Profile/company_profile">Restaurant Profile</a></li>
        </ul>
    </div>

    <div class="col-md-8 user-border-left">

        <h3 class="h3-font"><b>{{isset($config) ?  'Edit' : 'New' }}</b></h3>
        <br>

        {{--if profile is already filled and config has not filled yet,DB must be updated(not insert)--}}
        @if(isset($record))
            {!! Form::open(array('url' => 'Cashier/Config/update','method' => 'post','id'=>'config' ,'class'=> 'form-horizontal user-form-border','id'=>'general')) !!}
        @endif

        {{--check whether update or insert--}}
        @if(isset($config))
            {!! Form::open(array('url' => 'Cashier/Config/update','method' => 'post','id'=>'config', 'class'=> 'form-horizontal user-form-border','id'=>'general')) !!}
        @else
            {!! Form::open(array('url' => 'Cashier/Config/store','method' => 'post','id'=>'config', 'class'=> 'form-horizontal user-form-border','id'=>'general')) !!}
        @endif

        @if(isset($record))
            <input type="hidden" name="id" value="{{$record}}">
        @endif

        @if(isset($config))
            <input type="hidden" name="id" value="{{$config->id}}">
        @endif

        <div class="form-group">
            <label for="tax" class="col-sm-3 control-label left-align label-font">Tax (%)</label>
            <div class="col-sm-7">
                <input type="text" class="form-control" id="tax" name="tax" placeholder="Enter Tax" value="{{ isset($config)? $config->tax : Request::old('tax') }}"/>
                <p class="text-danger">{{$errors->first('tax')}}</p>
            </div>
        </div>

        <div class="form-group">
            <label for="service" class="col-sm-3 control-label left-align label-font">Service Charge(%)</label>
            <div class="col-sm-7">
                <input type="text" class="form-control" id="service" name="service" placeholder="Enter Service Charge" value="{{ isset($config)? $config->service:Request::old('service') }}"/>
                <p class="text-danger">{{$errors->first('service')}}</p>
            </div>
        </div>

        <div class="form-group">
            <label for="service" class="col-sm-3 control-label left-align label-font">Room Charge(Cash)</label>
            <div class="col-sm-7">
                <input type="text" class="form-control" id="room_charge" name="room_charge" placeholder="Enter Room Charge" value="{{ isset($config)? $config->room_charge:Request::old('room_charge') }}"/>
                <p class="text-danger">{{$errors->first('room_charge')}}</p>
            </div>
        </div>

        <div class="form-group">
            <label for="before" class="col-sm-3 control-label left-align label-font">Booking Warning Time</label>
            <div class="col-sm-7">
                @if(isset($config))
                <select class="form-control" name="before" id="before">
                    <option value="0">Select Booking Warning Time</option>
                    @if($warning_time == 900)
                        <option value="900" selected>15 minutes</option>
                    @else
                        <option value="900">15 minutes</option>
                    @endif
                    @if($warning_time == 1800)
                        <option value="1800" selected>30 minutes</option>
                    @else
                        <option value="1800">30 minutes</option>
                    @endif
                    @if($warning_time == 2700)
                        <option value="2700" selected>45 minutes</option>
                    @else
                        <option value="2700">45 minutes</option>
                    @endif
                    @if($warning_time == 3600)
                        <option value="3600" selected>1 hour</option>
                    @else
                        <option value="3600">1 hour</option>
                    @endif
                    @if($warning_time == 5400)
                        <option value="5400" selected>1 hour and 30 minutes</option>
                    @else
                        <option value="5400">1 hour and 30 minutes</option>
                    @endif
                    @if($warning_time == 7200)
                        <option value="7200" selected>2 hours</option>
                    @else
                        <option value="7200">2 hours</option>
                    @endif
                    @if($warning_time == 9000)
                        <option value="9000" selected>2 hours and 30 minutes</option>
                    @else
                        <option value="9000">2 hours and 30 minutes</option>
                    @endif
                    @if($warning_time == 10800)
                        <option value="10800" selected>3 hours</option>
                    @else
                        <option value="10800">3 hours</option>
                    @endif
                </select>
                @else
                    <select class="form-control" name="before" id="before">
                        <option selected disabled>Select Booking Warning Time</option>
                        <option value="900">15 minutes</option>
                        <option value="1800">30 minutes</option>
                        <option value="2700">45 minutes</option>
                        <option value="3600">1 hour</option>
                        <option value="5400">1 hour and 30 minutes</option>
                        <option value="7200">2 hours</option>
                        <option value="9000">2 hours and 30 minutes</option>
                        <option value="10800">3 hours</option>
                    </select>
                @endif
                <p class="text-danger">{{$errors->first('before')}}</p>
            </div>
        </div>

        <div class="form-group">
            <label for="after" class="col-sm-3 control-label left-align label-font">Booking Waiting Time</label>
            <div class="col-sm-7">
                @if(isset($config))
                    <select class="form-control" name="after" id="after">
                        <option value="0">Select Booking Waiting Time</option>
                        @if($waiting_time == 900)
                            <option value="900" selected>15 minutes</option>
                        @else
                            <option value="900">15 minutes</option>
                        @endif
                        @if($waiting_time == 1800)
                            <option value="1800" selected>30 minutes</option>
                        @else
                            <option value="1800">30 minutes</option>
                        @endif
                        @if($waiting_time == 2700)
                            <option value="2700" selected>45 minutes</option>
                        @else
                            <option value="2700">45 minutes</option>
                        @endif
                        @if($waiting_time == 3600)
                            <option value="3600" selected>1 hour</option>
                        @else
                            <option value="3600">1 hour</option>
                        @endif
                        @if($waiting_time == 5400)
                            <option value="5400" selected>1 hour and 30 minutes</option>
                        @else
                            <option value="5400">1 hour and 30 minutes</option>
                        @endif
                        @if($waiting_time == 7200)
                            <option value="7200" selected>2 hours</option>
                        @else
                            <option value="7200">2 hours</option>
                        @endif
                        @if($waiting_time == 9000)
                            <option value="9000" selected>2 hours and 30 minutes</option>
                        @else
                            <option value="9000">2 hours and 30 minutes</option>
                        @endif
                        @if($waiting_time == 10800)
                            <option value="10800" selected>3 hours</option>
                        @else
                            <option value="10800">3 hours</option>
                        @endif
                    </select>
                @else
                    <select class="form-control" name="after" id="after">
                        <option selected disabled>Select Booking Waiting Time</option>
                        <option value="900">15 minutes</option>
                        <option value="1800">30 minutes</option>
                        <option value="2700">45 minutes</option>
                        <option value="3600">1 hour</option>
                        <option value="5400">1 hour and 30 minutes</option>
                        <option value="7200">2 hours</option>
                        <option value="9000">2 hours and 30 minutes</option>
                        <option value="10800">3 hours</option>
                    </select>
                @endif
                <p class="text-danger">{{$errors->first('after')}}</p>
            </div>
        </div>

        <div class="form-group">
            <label for="service_time" class="col-sm-3 control-label left-align label-font">Booking Service Time</label>
            <div class="col-sm-7">
                @if(isset($config))
                    <select class="form-control" name="service_time" id="service_time">
                        <option value="0">Select Booking Service Time</option>
                        @if($service_time == 900)
                            <option value="900" selected>15 minutes</option>
                        @else
                            <option value="900">15 minutes</option>
                        @endif
                        @if($service_time == 1800)
                            <option value="1800" selected>30 minutes</option>
                        @else
                            <option value="1800">30 minutes</option>
                        @endif
                        @if($service_time == 2700)
                            <option value="2700" selected>45 minutes</option>
                        @else
                            <option value="2700">45 minutes</option>
                        @endif
                        @if($service_time == 3600)
                            <option value="3600" selected>1 hour</option>
                        @else
                            <option value="3600">1 hour</option>
                        @endif
                        @if($service_time == 5400)
                            <option value="5400" selected>1 hour and 30 minutes</option>
                        @else
                            <option value="5400">1 hour and 30 minutes</option>
                        @endif
                        @if($service_time == 7200)
                            <option value="7200" selected>2 hours</option>
                        @else
                            <option value="7200">2 hours</option>
                        @endif
                        @if($service_time == 9000)
                            <option value="9000" selected>2 hours and 30 minutes</option>
                        @else
                            <option value="9000">2 hours and 30 minutes</option>
                        @endif
                        @if($service_time == 10800)
                            <option value="10800" selected>3 hours</option>
                        @else
                            <option value="10800">3 hours</option>
                        @endif
                        @if($service_time == 12600)
                            <option value="12600" selected>3 hours and 30 minutes</option>
                        @else
                            <option value="12600">3 hours and 30 minutes</option>
                        @endif
                        @if($service_time == 14400)
                            <option value="14400" selected>4 hours</option>
                        @else
                            <option value="14400">4 hours</option>
                        @endif
                        @if($service_time == 16200)
                            <option value="16200" selected>4 hours and 30 minutes</option>
                        @else
                            <option value="16200">4 hours and 30 minutes</option>
                        @endif
                        @if($service_time == 18000)
                            <option value="18000" selected>5 hours</option>
                        @else
                            <option value="18000">5 hours</option>
                        @endif
                    </select>
                @else
                    <select class="form-control" name="service_time" id="service_time">
                        <option selected disabled>Select Booking Service Time</option>
                        <option value="900">15 minutes</option>
                        <option value="1800">30 minutes</option>
                        <option value="2700">45 minutes</option>
                        <option value="3600">1 hour</option>
                        <option value="5400">1 hour and 30 minutes</option>
                        <option value="7200">2 hours</option>
                        <option value="9000">2 hours and 30 minutes</option>
                        <option value="10800">3 hours</option>
                        <option value="12600">3 hours and 30 minutes</option>
                        <option value="14400">4 hours</option>
                        <option value="16200">4 hours and 30 minutes</option>
                        <option value="18000">5 hours</option>
                    </select>
                @endif
                <p class="text-danger">{{$errors->first('service_time')}}</p>
            </div>
        </div>

        <div class="form-group">
            <label for="message" class="col-sm-3 form-label left-align label-font">Message</label>
            <div class="col-sm-7">
                <textarea class="form-control" id="message" name="message" placeholder="Enter Message" rows="7" cols="40">{{isset($config)? $config->message:Input::old('message')}}</textarea>
                <p class="text-danger">{{$errors->first('message')}}</p>
            </div>
        </div>

        <div class="form-group">
            <label for="remark" class="col-sm-3 form-label left-align label-font">Remark</label>
            <div class="col-sm-7">
                <textarea class="form-control" id="remark" name="remark" placeholder="Enter Remark" rows="7" cols="40">{{isset($config)? $config->remark:Input::old('remark')}}</textarea>
                <p class="text-danger">{{$errors->first('remark')}}</p>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-8 col-sm-offset-3">
                <input type="submit" name="submit" value="{{isset($config)? 'UPDATE' : 'ADD'}}" class="user-button-ok">
                <input type="button" value="CANCEL" class="user-button-cancel" onclick="config_cancel();">
            </div>
        </div>
        {!! Form::close() !!}
    </div>

    <script>
        $( document ).ready(function() {
            $( "#tax" ).validate({
                rules: {
                    field: {
                        min: 0,
                        max: 100
                    }
                }
            });
        });

    </script>
@endsection