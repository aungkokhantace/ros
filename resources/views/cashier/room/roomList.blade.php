@extends('cashier.layouts.master')
@section('title','Room Listing')
@section('content')
    <div class="container">
        <div class="row">
            {{--heading title--}}
            <div class="col-md-12">
                <div class="col-md-3">
                    <h3 class="h3 list-heading-align"><strong>Room Listing</strong></h3>
                    @if(count(Session::get('message')) != 0)
                        <div ></div>
                    @endif
                </div>
                <div class="col-md-9">
                    <div class="buttons">
                        <button type="button"  onclick='room_create();' class="btn btn-default btn-md first_btn">
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        </button>
                        <button type="button" onclick='room_edit();'class="btn btn-default btn-md second_btn">
                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                        </button>
                        <button type="button" onclick="room_delete();" class="btn btn-default btn-md third_btn">
                            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                        </button>
                    </div>
                </div>

            </div>

        </div>
    </div>
        <div class="container">
            <div class="row">
                <div class="col-md-12 tbl-container">
                    <div class="col-md-12"></div>
                    <table id="example1" class="table table-striped list-table">
                        <thead>
                        <tr class="active">
                            <th><input type="checkbox" id="room_check_all"></th>
                            <th>No</th>
                            <th>Room Name</th>
                            <th>Capacity</th>
                            <th>Room Status</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($rooms as $room)
                            <tr class="active">
                                <td> <input class="room_source" type="checkbox" name="room_check" value="{{ $room->id }}" id="all" />
                                </td>
                                <td></td>
                                <td><a href="/Cashier/Room/edit/{{$room->id}}">{{ $room->room_name}}</a></td>
                                <td>{{ $room->capacity }}</td>
                                <td>
                                    @if($room->status == 0) {{"Available"}}
                                    @else {{"Serve"}}
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

