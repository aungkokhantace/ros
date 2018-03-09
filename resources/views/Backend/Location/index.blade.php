@extends('Backend.layouts.master')
@section('title','Location Listing')
@section('content')
     <div class="content-wrapper">
      <div class="box">
       <div class="box-header">
        <div class="row">
            {{--heading title--}}
            <div class="col-md-12">
                <div class="col-md-3">
                    <h3 class="h3 list-heading-align"><strong>Location Listing</strong></h3>
                    @if(count(Session::get('message')) != 0)
                        <div ></div>
                    @endif
                </div>
            </div>
            
                <div class="col-md-9 pull-right">
                    <div class="buttons">
                        <button type="button"  onclick='location_create();' class="btn btn-default btn-md first_btn">
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        </button>
                        <button type="button" onclick='location_edit();'class="btn btn-default btn-md second_btn">
                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                        </button>
                        <button type="button" onclick="location_delete();" class="btn btn-default btn-md third_btn">
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
                        <th><input type="checkbox" id="check_all"></th>
                        <th>No</th>
                        <th>Location Name</th>
                    </tr>
                    </thead>
                    <tbody>

                        @foreach($locations as $location)
                            <tr class="active">
                                <td> <input class="source" type="checkbox" name="location_check" value="{{ $location->id }}" id="all" />
                                </td>
                                <td></td>
                                <td><a href="/Backend/Location/edit/{{$location->id}}">{{ $location->location_type}}</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

