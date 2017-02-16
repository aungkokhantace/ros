@extends('cashier.layouts.master')
@section('title','Item Listing')
@section('content')
    <div class="container">
        <div class="row">
            {{--Start heading title--}}
            <div class="col-md-12">
                <div class="col-md-3">
                    <h3 class="h3 list-heading-align"><strong>Item Listing</strong></h3>
                    @if(count(Session::get('message')) != 0)
                        <div ></div>
                    @endif
                </div>
                {{--End heading title--}}
                <div class="col-md-9">
                    <div class="buttons">
                        <input type="image" class="img_btn" src="../../../assets/images/enable.png" onclick="enable();">
                        <input type="image" class="img_btn" src="../../../assets/images/disable.png" onclick="disable();">
                        <button type="button" class="btn btn-default btn-md first_btn" onclick="item_create();">
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        </button>
                        <button type="button" class="btn btn-default btn-md second_btn" onclick="item_edit();">
                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                        </button>
                        <button type="button" class="btn btn-default btn-md third_btn" onclick="item_delete();">
                            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        {{--End Buttons--}}
    </div>
        {{--Start table--}}
        <div class="container">
            <div class="row">
                <div class="col-md-12 tbl-container">
                    <div class="col-md-12"></div>
                    <table id="example1" class="table table-striped list-table">
                        <thead>

                        <tr class="active">

                            <th> <input type='checkbox' name='check' id='check_all'/></th>
                            <th>No</th>
                            <th>Item Name</th>
                            <th>Item Category</th>
                            <th>Item Image</th>
                            <th>Item Description</th>
                            <th>Item Price</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($items as $item)
                            <tr class="active">
                                <td>
                                    <input type="checkbox" class="source" name="check_item" value="{{$item->id}}">
                                </td>
                                <td></td>
                                <td><a href="/Cashier/Item/edit/{{$item->id}}">{{ $item->name}}</a></td>
                                <td>{{ $item->Category->name}}</td>
                                <td>{{ $item->image}}</td>
                                <td>{{ $item->description}}</td>
                                <td>{{ $item->price}}</td>
                                <td>
                                    @if($item->status == 1)
                                        {{'Available'}}
                                    @else
                                        {{'Not Available'}}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
@endsection
