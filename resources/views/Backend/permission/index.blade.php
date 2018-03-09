@extends('Backend/layouts.master')
@section('title','Permission Listing')
@section('content')
<div class="content-wrapper">
        <div class="box">
            <div class="box-header">
              <h3 class="h3 list-heading-align"><strong> &nbspPermission Listing</strong></h3>
                
                @if(count(Session::get('message')) != 0)
                        <div ></div>
                @endif
            </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body col-md-*">
              <table  id="example1" class="table table-striped list-table" ">
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
                                <td>{{ $module->module }}</td>

                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
   </div>

   
   @endsection  



   
