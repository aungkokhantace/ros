@extends('Cashier.layouts.master')
@section('title', isset($promotion) ? 'Edit Promotion' : 'New Promotion')

@section('content')
    <div class="col-md-6">
        <div id="cust"><b>{{ isset($promotion) ? 'Promotion Edit' : 'Promotion Entry' }}</b></div>
        <br>
        @if(isset($promotion))
            {!! Form::open(array('url' => 'Cashier/Promotion/update', 'class'=> 'form-horizontal', 'method'=>'post','id'=>'promotion')) !!}

        @else
            {!! Form::open(array('url' => 'Cashier/Promotion/store', 'class'=> 'form-horizontal','id'=>'promotion', 'method'=>'post','id'=>'promotion')) !!}
        @endif

        <input type="hidden" name="id" value="{{isset($promotion)? $promotion->id:''}}"/>


        <div class="form-group">
            <label for="name" class="col-sm-4 control-label left-label">Promotion Type</label>
            <div class="col-sm-8">
                <select class="form-control" name="promotion_type">
                    <option value="Item Promotion">Item Promotion </option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="from_date" class="col-sm-4 control-label left-label">From Date</label>
            <div class="col-sm-8">
                <div class="input-group date dateTimePicker" data-provide="datepicker">
                    <input  type="text" class="form-control" id="from_date" name="from_date" placeholder="Choose From Date" value="{{ isset($promotion)? date('d-m-Y',strtotime($promotion->from_date)): Request::old('from_date') }}">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </div>
                </div>
                <p class="text-danger">{{ $errors->first('from_date') }}</p>
            </div>
        </div>

        <div class="form-group">
            <label for="to_date" class="col-sm-4 control-label left-label">To Date</label>
            <div class="col-sm-8">
                <div class="input-group date dateTimePicker" data-provide="datepicker">
                    <input  type="text" class="form-control" id="to_date" name="to_date" placeholder="Choose To Date" value="{{ isset($promotion)? date('d-m-Y',strtotime($promotion->to_date)):Request::old('to_date') }}">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </div>
                </div>
                <p class="text-danger">{{ $errors->first('to_date') }}</p>
            </div>
        </div>

        <div class="form-group">
            <label for="from_time" class="col-sm-4 control-label left-label">From Time</label>
            <div class="col-sm-8">
                <div class="input-group bootstrap-timepicker timepicker">
                    <input id="from_time" name="from_time" type="text" class="form-control input-small" value="{{isset($promotion)?date("h:i A", strtotime($promotion->from_time)):''}}" >
                    <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                </div>
                <p class="text-danger">{{ $errors->first('from_time') }}</p>
            </div>

        </div>

        <div class="form-group">
            <label for="to_time" class="col-sm-4 control-label left-label">To Time</label>
            <div class="col-sm-8">
                <div class="input-group bootstrap-timepicker timepicker">
                    <input id="to_time" name="to_time" type="text" class="form-control input-small" value="{{isset($promotion)?date("h:i A", strtotime($promotion->to_time)):''}}">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                </div>
                <p class="text-danger">{{ $errors->first('to_time') }}</p>
            </div>
        </div>

        <div class="form-group">
            <label for="sell_item" class="col-sm-4 control-label left-label">Selling Item<span class="require">*</span></label>
            <div class="col-sm-8">
                <div>
                @if(isset($promotion))
                    <select  name="sell_item[]" id="sell_item" multiple="multiple">
                        @foreach($items as $item)
                            @if(in_array($item->id,$pro_items))
                                <option value="{{$item->id}}" class="select" selected>{{$item->name}}</option>
                            @else
                                <option value="{{$item->id}}" class="select">{{$item->name}}</option>
                            @endif
                        @endforeach
                    </select>
                @else
                    <select  name="sell_item[]" id="sell_item" multiple="multiple">
                        {{--<option value="" selected disabled></option>--}}
                        @foreach($items as $item)
                            <option value="{{$item->id}}" class="select">{{$item->name}}</option>
                        @endforeach
                    </select>
                @endif

                    <p class="text-danger">{{ $errors->first('sell_item') }}</p>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="to_time" class="col-sm-4 control-label left-label">Selling Item Qty<span class="require">*</span></label>
            <div class="col-sm-8">
                <input type="text" name="sell_item_qty" class="form-control " id="sell_item_qty" placeholder="Enter Selling Item Quantity"

                       value="{{isset($promotion)?$promotion->sell_item_qty:Request::old('sell_item_qty')}}">

                <p class="text-danger">{{ $errors->first('sell_item_qty') }}</p>
            </div>
        </div>

        <div class="form-group">
            <label for="type" class="col-sm-4 control-label left-label">Present Item<span class="require">*</span></label>
            <div class="col-sm-8">
                @if(isset($promotion))
                    <select class="form-control" name="present_item" id="present_item">
                        @foreach($items as $item)
                            @if($item->id == $promotion->item_id)
                                <option value="{{$promotion->item_id}}" selected>{{$promotion->item->name}}</option>
                            @else
                                <option value="{{$item->id}}">{{$item->name}}</option>
                            @endif
                        @endforeach
                    </select>
                @else
                    <select class="form-control" name="present_item" id="item">
                        <option value="" selected disabled>Select Item </option>
                        @foreach($items as $item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                        @endforeach
                    </select>
                @endif
            </div>
            <p class="text-danger">{{ $errors->first('item') }}</p>
        </div>

        <div class="form-group">
            <label for="to_time" class="col-sm-4 control-label left-label">Present Item Qty<span class="require">*</span></label>
            <div class="col-sm-8">
                <input type="text" name="present_item_qty" class="form-control " id="present_item_qty" placeholder="Enter Present Item Quantity"
                       value="{{ isset($promotion)? $promotion->present_item_qty:Request::old('present_item_qty')}}">
                <p class="text-danger">{{ $errors->first('present_item_qty') }}</p>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-4 col-sm-10">
                <input type="submit" name="submit" value="{{isset($promotion)? 'UPDATE':'ADD'}}" class="user-button-ok">
                <input type="reset" value="CANCEL" class="user-button-cancel" onclick="Promotion_Cancel_Form()">
            </div>
        </div>
        {!! Form::close() !!}
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#from_time').timepicker();
            $('#to_time').timepicker();
        });
    </script>
@endsection

