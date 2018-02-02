@extends('cashier.layouts.master')
@section('title','Day Start Listing')
@section('content')
    <div class="container">
        <div class="row">
            {{--Start heading title--}}
            <div class="col-md-12">
                <div class="col-md-3">
                    <h3 class="h3 list-heading-align"><strong>Day Start Listing</strong></h3>
                    @if(count(Session::get('message')) != 0)
                        <div ></div>
                    @endif
                </div>
                {{--End heading title--}}
                <div class="col-md-9">
                    <div class="buttons">
                        <button type="button" class="btn btn-default btn-md first_btn" onclick="day_create();">
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        </button>
                        <button type="button" class="btn btn-default btn-md third_btn" onclick="day_delete();">
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
                            <th> <input type='checkbox' name='day_check' id='check_all'/></th>
                            <th>No</th>
                            <th>Day Code</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($daystarts as $daystart)
                             <tr class="active">
                                <td>
                                    <input type="checkbox" class="source" name="day_check" value="{{ $daystart->id }}">
                                </td>
                                <td></td>
                                <td>{{ $daystart->day_code }}</td>
                                <td>{{ $daystart->start_date }}</td>
                                <td>
                                    @if($daystart->status == 1)
                                        Opening
                                    @else
                                        Close
                                    @endif 
                                </td>
                                <td>
                                    <button type="button" class="btn btn-success">Day End</button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
@endsection
