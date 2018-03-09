@extends('Backend.layouts.master')
@section('title','Member Type Listing')
@section('content')
  
    <div class="content-wrapper">
      <div class="box">
       <div class="box-header">
        <div class="row">
            {{--heading title--}}
            <div class="col-md-12">
                <div class="col-md-3">
                    <h3 class="h3 list-heading-align"><strong>Member Type Listing</strong></h3>
                    @if(count(Session::get('message')) != 0)
                        <div ></div>
                    @endif
                </div>
          </div>
           
                <div class="col-md-9 pull-right">
                    <div class=" buttons ">
                        <button type="button"  onclick='member_type_form_create();' class="btn btn-default btn-md first_btn">
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        </button>
                        <button type="button" onclick='member_type_edit();'class="btn btn-default btn-md second_btn">
                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                        </button>
                        <button type="button" onclick="member_type_delete();" class="btn btn-default btn-md third_btn">
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
                <div class="col-md-12 ">
                    <div class="col-md-12"></div>
                    <table id="example1" class="table table-striped ">

                        <thead>
                            <tr class="active">
                                <th> <input type='checkbox' name='check' id='check_all'/></th>
                                <th>No</th>
                                <th>Member Type</th>
                                <th>Member Type Description</th>
                                <th>Discount</th>
                                <th>Life Time</th>
                            </tr>
                        </thead>
                        <tbody>

                        @foreach($member_types as $member_type)
                            <tr class="active">
                                <td> <input class="source" type="checkbox" name="member_type_check" value="{{ $member_type->id }}" id="all" />
                                </td>
                                <td></td>
                                <td><a href="/Cashier/MemberType/edit/{{$member_type->id}}">{{ $member_type->type }}</a></td>
                                <td>{{ $member_type->description }}</td>
                                <td>{{ $member_type->discount_amount }}%</td>
                                <td>{{$member_type->life_time}} years</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
             </div>
            </div>
       </div>
     
@endsection