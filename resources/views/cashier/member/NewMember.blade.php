@extends('Cashier.layouts.master')
@section('title', isset($member) ? 'Edit Member' : 'New Member')
@section('content')
    <div class="col-md-6">
    <div id="cust"><b>{{ isset($member) ? 'Edit Member' : 'Create New Member' }}</b></div>
    <br>
        @if(isset($member))
            {!! Form::open(array('url' => 'Cashier/Member/update', 'class'=> 'form-horizontal','id'=>'customer-entry', 'method'=>'post')) !!}

        @else
            {!! Form::open(array('url' => 'Cashier/Member/store', 'class'=> 'form-horizontal','id'=>'customer-entry', 'method'=>'post')) !!}
        @endif

        <input type="hidden" name="id" value="{{isset($member)? $member->id:''}}"/>


    <div class="form-group">
        <label for="name" class="col-sm-3 control-label left-label">Name<span class="require">*</span></label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Member Name"
                   value="{{ isset($member)? $member->name:Request::old('name') }}"/>
            <p class="text-danger">{{ $errors->first('name') }}</p>
        </div>
    </div>

    <div class="form-group">
        <label for="phone" class="col-sm-3 control-label left-label">Phone<span class="require">*</span></label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter Member's Phone"
                   value="{{ isset($member)? $member->phone: Request::old('phone') }}"/>
            <p class="text-danger">{{ $errors->first('phone') }}</p>
        </div>
    </div>

    <div class="form-group">
        <label for="email" class="col-sm-3 control-label left-label">Email</label>
        <div class="col-sm-9">
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email Address"
                   value="{{ isset($member)? $member->email:Request::old('email') }}"/>
            <p class="text-danger">{{ $errors->first('email') }}</p>
        </div>
    </div>

    <div class="form-group">
        <label for="birthday" class="col-sm-3 control-label left-label">Date of Birth<span class="require">*</span></label>
        <div class="col-sm-9">
            <div class="input-group date dateTimePicker" data-provide="datepicker">
                <input  type="text" class="form-control" id="birthday" name="birthday" placeholder="Choose Birthday" value="{{ isset($member)? \Carbon\Carbon::parse($member->birthdate)->format('d-m-Y'):Request::old('birthday')}}">
                <div class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </div>
            </div>
           
            <p class="text-danger">{{ $errors->first('birthday') }}</p>
        </div>
    </div>

    <div class="form-group">
        <label for="food" class="col-sm-3 control-label left-label">Favourite Food</label>
        <div class="col-sm-9">
            <select name="food[]" id="fav" multiple="multiple" placeholder="Choose Member Favourite Food">
                @if(isset($member))
                    {!! generateFoodCategoryListsEdit($categories,$items,$parentId=0, $indent=0,$favourite) !!}
                @else
                    {!! generateFoodCategoryLists($categories,$items,$parentId=0, $indent=0) !!}
                @endif
            </select>
        </div>
    </div>

    <div class="form-group">
        <label for="type" class="col-sm-3 control-label left-label">Member Type<span class="require">*</span></label>
        <div class="col-sm-9">
            <select name="member_type" class="form-control">
                @if(isset($member))
                    <option value="{{ $member->member_type_id }}" selected>{{$member->member_type->type}}</option>
                @else
                    <option value="" selected disabled>Select Member Type</option>
                @endif
                @foreach($member_type as $data)
                <option value="{{ $data->id }}">{{ $data->type }}</option>
                @endforeach
            </select>
        </div>
        <p class="text-danger">{{ $errors->first('member-type') }}</p>
    </div>

    <div class="form-group">
        <label for="member_card_no" class="col-sm-3 control-label left-label">Member Card No.<span class="require">*</span></label>
        <div class="col-sm-9">
            <input type="text" name="member_card_no" class="form-control" id="member_card_no"  placeholder="Enter Member Card No."
                   value="{{ isset($member)? $member->member_card_no:Request::old('member_card_no')}}">
            <p class="text-danger">{{ $errors->first('member_card_no') }}</p>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-10">
            <input type="submit" name="submit" value="{{isset($member)? 'UPDATE':'ADD'}}" class="user-button-ok">
            <input type="reset" value="CANCEL" class="user-button-cancel" onclick="Member_Cancel_Form()">
        </div>
    </div>

    {!! Form::close() !!}


    </div>
    <script>
        $(function() {
            $('#fav').change(function() {
                //var dd = $('#Category').val();
                //console.log(dd);
            }).multipleSelect({
                width: '100%'
            });
        });
    </script>

@endsection

