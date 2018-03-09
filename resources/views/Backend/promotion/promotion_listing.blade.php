@extends('cashier.layouts.master')
@section('title','Promotion Listing')
@section('content')

    <div class="container">
        <div class="row">
            {{--heading title--}}
            <div class="col-md-12">
                <div class="col-md-3">
                    <h3 class="h3 list-heading-align"><strong>Promotion Listing</strong></h3>
                    @if(count(Session::get('message')) != 0)
                        <div ></div>
                    @endif
                </div>
                <div class="col-md-9">
                    <div class="buttons">
                        <button type="button" class="btn btn-default btn-md first_btn" onclick="New_Promotion_Form();">
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        </button>
                        <button type="button" class="btn btn-default btn-md second_btn" onclick="PromotionEdit();">
                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                        </button>
                        <button type="button" class="btn btn-default btn-md third_btn" onclick="PromotionDelete();">
                            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--tables--}}

    <div class="container">
        <div class="row">
            <div class="col-md-12 tbl-container">
                <div class="col-md-12"></div>
                <table class="table table-striped list-table" id="example1">
                  <thead>
                        <tr class="active">
                            <th><input type='checkbox' name='check' id='check_all'/></th>
                            <th>No</th>
                            <th>Promotion Type</th>
                            <th>From Date</th>
                            <th>To Date</th>
                            <th>From Time</th>
                            <th>To Time</th>
                            <th>Selling Item</th>
                            <th>Sell Item Quantity</th>
                            <th>Present Item</th>
                            <th>Present Item Quantity</th>
                        </tr>
                  </thead>
                  <tbody>

                    @foreach($promotion as $pro)
                        <tr class="active">
                            <td><input type="checkbox" class="source" name="promotion-check" value="{{ $pro->id }}" id="all" >

                            </td>
                            <td></td>
                            <td> <a href="/Cashier/Promotion/edit/{{$pro->id}}">{{ $pro->promotion_type }}</a> </td>
                            <td> {{ $pro->from_date }} </td>
                            <td> {{ $pro->to_date }}</td>
                            <td>
                                @if($pro->from_time != "00:00:00")
                                    {{Carbon\Carbon::parse($pro->from_time)->format('h:i A')}}
                                @endif
                            </td>
                            <td>
                                @if($pro->to_time != "00:00:00")
                                    {{Carbon\Carbon::parse($pro->to_time)->format('h:i A')}}
                                @endif
                            </td>
                            <td>
                                @foreach($promotion_item as $item)
                                    @if($item->promotion_id == $pro->id)
                                        {{ $item->items->name }}
                                    @endif
                                @endforeach
                            </td>
                            <td> {{ $pro->sell_item_qty }}</td>
                            <td> {{ $pro->items->name }}</td>
                            <td> {{ $pro->present_item_qty }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
   </div>
@endsection
