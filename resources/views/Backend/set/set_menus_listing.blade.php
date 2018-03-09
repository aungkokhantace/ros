@extends('Backend.layouts.master')
@section('title','Set menu Listing')
@section('content')
    <div class="content-wrapper">
      <div class="box">
       <div class="box-header">
        <div class="row">
            {{--heading title--}}
            <div class="col-md-12">
                <div class="col-md-3">
                    <h3 class="h3 list-heading-align"><strong>Set Menu Listing</strong></h3>
                    @if(count(Session::get('message')) != 0)
                        <div ></div>
                    @endif
                </div>
            </div>
       
                <div class="col-md-9 pull-right">
                    <div class=" buttons">
                        <button type="button"  onclick='set_create();' class="btn btn-default btn-md first_btn">
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        </button>
                        <button type="button" onclick='sub_menus_edit();'class="btn btn-default btn-md second_btn">
                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                        </button>
                        <button type="button" onclick="sub_menus_delete();" class="btn btn-default btn-md third_btn">
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
                    <table id="example1" class="table table-striped list-table">

                        <thead>
                        <tr class="active">
                            <th><input type='checkbox' name='check_all' id='check_all'  onclick="check(value);" /> </th>
                            <th>No</th>
                            <th>Set menu Name</th>
                            <th>Items</th>
                            <th>Price</th>
                            <th>Image</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($set_menu as $set)
                            <tr class="active">
                                <input type="hidden" value="{{$set->id}}">
                                <td> <input class="source" type="checkbox" name="sub_check" value="{{ $set->id }}" id="check" />

                                </td>
                                <td></td>
                                <td><a href="/Backend/SetMenu/edit/{{$set->id}}">{{ $set->set_menus_name }}</a> </td>
                                <td>
                                    @foreach($set->set_item as $sitem)
                                        @foreach($items as $item)
                                            @if($sitem->item_id == $item->id)
                                                {{ $item->name }},
                                            @endif
                                        @endforeach
                                    @endforeach
                                </td>
                                <td>{{ $set->set_menus_price}}</td>
                                <td>{{ $set->image }}</td>
                                <td>
                                    @if( $set->status==0)
                                        {{"Not Available"}}
                                    @else
                                        {{"Available"}}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
