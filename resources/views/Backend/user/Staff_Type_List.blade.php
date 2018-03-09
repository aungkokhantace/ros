


@extends('Backend/layouts.master')
@section('title','Permission Listing')
@section('content')
<div class="content-wrapper">
        <div class="box">
            <div class="box-header">
              <div class="row ">
            {{--heading title--}}
            <div class="col-md-12">
                <div class="col-md-3">
                    <h3 class="h3 list-heading-align"><strong>Staff Type Listing</strong></h3>
                    @if(count(Session::get('message')) != 0)
                        <div ></div>
                    @endif
                </div>
                <!-- <div class="col-md-9 list_edit">
                    <div class=" buttons pull-right">
                        <button type="button"  onclick='role_create();' class="btn btn-success btn-md first_btn">
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        </button>
                        <button type="button" onclick='role_edit();' class="btn btn-default btn-md second_btn">
                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                        </button>
                        <button type="button" onclick="role_delete();" class="btn btn-danger btn-md third_btn">
                            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                        </button>
                    </div>
                </div> -->
            </div>

        </div>
            </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body col-md-*">
              <table id="example1" class="table table-striped list-table table-responsive">
                   <thead>
                    <tr class="active">
                        <th><input type="checkbox" id="role_check_all" ></th>
                        <th class="data_table">No</th>
                        <th class="data_table_name">Staff Type Name </th>
                        <th>Description</th>
                        <th>Permission</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($roles as $role)
                            <tr class="active">
                                <td><input type="checkbox" class="role_source" name="row_check" value="{{ $role->id }}" id="all">
                                </td>
                                <td></td>
                                <td>{{ $role->name }}</td>
                                <td>{{ $role->description }}</td>
                                <td>
                                    @foreach( $permissions as $permission )
                                        @if($permission->role_id == $role->id)
                                            {{$permission->module}},
                                        @endif
                                    @endforeach
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
   </div>

  
   @endsection  