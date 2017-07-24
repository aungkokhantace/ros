@extends('cashier.layouts.master')
@section('title','Table Listing')
@section('content')
    <div class="container">
        <div class="row">
            {{--heading title--}}
            <div class="col-md-12">
                <div class="col-md-3">
                    <h3 class="h3 list-heading-align"><strong>Table Listing</strong></h3>
                    @if(count(Session::get('message')) != 0)
                        <div ></div>
                    @endif
                </div>
                <div class="col-md-9">
                    <div class=" buttons">
                        <button type="button"  onclick='table_create();' class="btn btn-default btn-md first_btn">
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        </button>
                        <button type="button" onclick='table_edit();'class="btn btn-default btn-md second_btn">
                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                        </button>
                        <button type="button" onclick="table_delete();" class="btn btn-default btn-md third_btn">
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
                    
                    <table id="example1" class="table table-striped list-table">

                        <thead>
                            <tr class="active">
                                <th><input type="checkbox" id="table_check_all"></th>
                                <th>No</th>
                                <th>Table Name</th>
                                <th>Table Capacity</th>
                                <th>Area</th>
                                <th>Table Status</th>
                            </tr>
                        </thead>
                        <tbody>

                        @foreach($tables as $table)

                            <tr class="active">
                                <td> <input class="table_source" type="checkbox" name="table_check" value="{{ $table->id }}" id="all" />
                                </td>
                                <td></td>
                                <td><a href="/Cashier/Table/edit/{{$table->id}}">{{ $table->table_no }}</a></td>
                                <td>{{ $table->capacity }}</td>
                                <td>{{$table->area}}</td>
                                <td>
                                    @if($table->status == 0) {{"Available"}}
                                    @else{{"Serve"}}
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
