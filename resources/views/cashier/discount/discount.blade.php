@extends('cashier/layouts.master')
@section('title',isset($resource)?'Edit Discount':'New Discount')
@section('content')
    <div class="col-md-8 user-border-left">
        <h3 class="h3-font"><b>{{isset($resource) ?  'Edit Discount' : 'Create New Discount ' }}</b></h3>
       @if(isset($resource))
            {!! Form::open(array('url' => 'Cashier/Discount/update','method' => 'post', 'class'=> 'form-horizontal user-form-border','id'=>"discount")) !!}

        @else
            {!! Form::open(array('url' => 'Cashier/Discount/store', 'method' => 'post', 'class'=> 'form-horizontal user-form-border','id'=>"discount")) !!}
        @endif

        <div class="form-group">
            <label for="discount" class="col-sm-3 control-label left-align label-font">Discount Name  <span class="require">*</span></label>
            <div class="col-sm-7">
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Discount Name" value= "{{isset($resource)? $resource->name:Input::old('name')}}">
                <p class="text-danger">{{$errors->first('name')}}</p>
            </div>
        </div>

        <input type="hidden" name="id" value="{{isset($resource)? $discount_edit->id:''}} "/>

        <div class="form-group">
            <label for="discount" class="col-sm-3 control-label left-align label-font">Start Date<span class="require">*</span></label>
            <div class="col-sm-7">
                <div class="input-group date dateTimePicker" data-provide="datepicker">
                    <input  type="text" class="form-control" id="from_date" name="from_date" placeholder="Choose Start Date" value= "{{isset($resource)? \Carbon\Carbon::parse($resource->start_date)->format('d-m-Y'):Input::old('from_date')}}">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </div>
                </div>
                
                <p class="text-danger">{{$errors->first('from_date')}}</p>
            </div>
        </div>

        <div class="form-group">
            <label for="discount" class="col-sm-3 control-label left-align label-font">End Date<span class="require">*</span></label>
            <div class="col-sm-7">
                <div class="input-group date dateTimePicker" data-provide="datepicker">
                    <input  type="text" class="form-control" id="to_date" name="to_date" placeholder="Choose Start Date" value= "{{isset($resource)? \Carbon\Carbon::parse($resource->end_date)->format('d-m-Y'):Input::old('to_date')}}">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </div>
                </div>

                <p class="text-danger">{{$errors->first('to_date')}}</p>
            </div>
        </div>

        <div class="form-group">
            <label for="discount" class="col-sm-3 control-label left-align label-font" >Item<span class="require">*</span></label>
            <div class="col-sm-7">
                <select id="product" class="form-control" name="product"  onchange="discount_check(value)">
                    <option value="">Select Item</option>
                    <?php foreach ($items as $item) : ?>
                    <?php if(isset($resource)) : ?>
                    <option  value="<?php echo $item->id; ?>" <?php echo $item->id == $resource->item_id ? 'selected' : '' ?>>
                        <?php echo $item->name; ?>
                    </option>
                    <?php else : ?>
                    <option  value="<?php echo $item->id; ?>">   <?php echo $item->name; ?> </option>
                    <?php endif; ?>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="place_for_text"></div>

        <div class="form-group">
            <label for="member-type" class="col-sm-3 control-label left-align label-font"></label>
            <div class="col-sm-7" id="disc_check">
                <p class="text-danger">{{$errors->first('product')}}</p>
            </div>
        </div>

        <div class="form-group">
            <label for="discount-type" class="col-sm-3 control-label left-align label-font">Discount Type</label>
            <div class="col-sm-7">
                @if(isset($resource))
                    <label class="radio-inline">
                        @if($resource->type == "%")
                            <input type="radio" name="choose" id="per" value="%" checked class="check">Percentage %
                        @else
                            <input type="radio" name="choose" id="per" value="%" class="check">Percentage %
                        @endif
                    </label>
                    <label class="radio-inline">
                        @if($resource->type == "ks(kyats)")
                            <input type="radio" name="choose" id="curr" value="ks(kyats)" checked class="check">Amount
                        @else
                            <input type="radio" name="choose" id="curr" value="ks(kyats)" class="check">Amount
                        @endif
                    </label>
                @else
                    <label class="radio-inline">
                        <input type="radio" name="choose" id="per" value="%" checked  class="check">Percentage %
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="choose" id="curr" value="ks(kyats)" class="check">Amount
                    </label>
                @endif
            </div>
        </div>

        <div class="form-group">
            <label for="discount" class="col-sm-3 control-label left-align label-font" >Discount Amount<span class="require">*</span></label>
            <div class="col-sm-7">
                <input type="text" class="form-control" id="amount" name="amount" placeholder="Enter Discount Amount" value="{{isset($resource)? $resource->amount: Input::old('amount') }}">
                <p class="text-danger">{{$errors->first('amount')}}</p>
            </div>
        </div>
        <div class="form-group">
           <div class="col-sm-8 col-sm-offset-3">
               <input type="submit" name="submit" value="{{isset($resource)? 'UPDATE' : 'ADD'}}" class="user-button-ok" >
               <input type="reset" value="CANCEL" class="user-button-cancel" onclick={{ "discount_listing_form_back();" }}>
           </div>
       </div>
        {!! Form::close() !!}
    </div>
    
@endsection