@extends('cashier/layouts.master')
@section('title','Permission Listing')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-3">
                    <h3 class="h3 list-heading-align"><strong>Permission Listing</strong></h3>
                    @if(count(Session::get('message')) != 0)
                        <div ></div>
                    @endif
                </div>
                <div class="col-md-9">
                    <div class="buttons">
                        <button name="create module" type="button" class="btn btn-default btn-md first_btn" onclick="permission_create();">
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        </button>
                        <button name="edit module" type="button" class="btn btn-default btn-md second_btn" onclick="permission_edit();">
                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
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
                        <th><input type='checkbox' name='check_all' id='check_all'  onclick="check(value);" />  </th>
                        <th>No</th>
                        <th>Module Name</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(isset($modules) && count($modules) > 0)
                        @foreach($modules as $module)
                            <tr class="active">
                                <input type="hidden" value="{{$module->id}}">

                                <td> <input class="source" type="checkbox" name="module_check" value="{{ $module->id }}" id="check" />

                                </td>
                                <td></td>
                                <td><a href="/Cashier/Permission/edit/{{$module->id}}">{{ $module->module }}</a></td>

                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>

    </div>
    </div>
    </div>
@endsection
