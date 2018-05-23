@extends('cashier.layouts.master')
@section('title','Shift')
@section('content')
    <div class="container">
        <div class="row">
            {{--heading title--}}
            <div class="col-md-12">
                <div class="col-md-3">
                    <h3 class="h3 list-heading-align"><strong>Shift Listing</strong></h3>
                    @if(count(Session::get('message')) != 0)
                        <div ></div>
                    @endif
                </div>
                <div class="col-md-9">
                    <div class=" buttons">
                        {{--create button--}}
                        <button name="create category" type="button" class="btn btn-default btn-md first_btn" onclick="shift_create();">
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        </button>

                        {{--edit button--}}
                        <button name="edit category" type="button" class="btn btn-default btn-md second_btn" onclick="shift_edit();">
                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                        </button>

                        {{--delete button--}}
                        <button name="delete category" type="button" class="btn btn-default btn-md third_btn" onclick="shift_delete();">
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
                                <th> <input type='checkbox' name='check' id='check_all'/></th>
                                <th>No</th>
                                <th>Shift Name</th>
                                <th>Last Shift</th>
                                <th>Shift Permission</th>
                                <th>Make Last</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($shifts as $shift)
                                <tr class="active">
                                    <td><input type="checkbox" name="shift-check" class="source" value="{{ $shift->id }}" id="all">

                                    </td>
                                    <td></td>
                                    <td>{{ $shift->name }}</td>
                                    <td>
                                        @if($shift->is_last_shift == 1)
                                            {{'Yes'}}

                                        @else
                                            {{'No'}}
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-warning" onclick="shift_permission_create({{ $shift->id }});">Permission</button>
                                    </td>

                                    <td>
                                        @if($shift->is_last_shift == 0)
                                        <button class="btn btn-success" onclick="shift_last_create({{ $shift->id }});">Make Last Shift</button>
                                        @else
                                        <p class="text-danger">Last Shift</p>
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
