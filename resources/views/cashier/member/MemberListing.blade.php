@extends('cashier.layouts.master')
@section('title','Member Listing')
@section('content')

    <div class="container">
        <div class="row">
            {{--heading title--}}
            <div class="col-md-12">
                <div class="col-md-3">
                    <h3 class="h3 list-heading-align"><strong>Member Listing</strong></h3>
                    @if(count(Session::get('message')) != 0)
                        <div ></div>
                    @endif
                </div>
                <div class="col-md-9">
                    <div class="buttons">
                        <button type="button" class="btn btn-default btn-md first_btn" onclick="New_Member_Form();">
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        </button>

                        <button type="button" class="btn btn-default btn-md second_btn" onclick="MemberEdit();">
                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                        </button>

                        <button type="button" class="btn btn-default btn-md third_btn" onclick="MemberDelete();">
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
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                {{--<th>Birth Date</th>--}}
                                <th>Favourite Food</th>
                                <th>Member type</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($joinType as $member)
                                <tr class="active">
                                    <td><input type="checkbox" class="source" name="member-check" value="{{ $member->id }}" id="all" ></td>
                                    <td></td>
                                    <td> <a href="/Cashier/Member/edit/{{$member->id}}">{{ $member->name }}</a> </td>
                                    <td> {{ $member->phone }}</td>
                                    <td> {{ $member->email }} </td>
                                    
                                    <td> @foreach($member->favourite as $fav)
                                            @foreach($Item as $item)
                                                @if( $fav->item_id == $item->id)
                                                    {{$item->name}},
                                                @endif
                                            @endforeach
                                        @endforeach
                                    </td>
                                    <td> {{ $member->member_type->type }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
@endsection
