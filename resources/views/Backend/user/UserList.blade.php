@extends('Backend.layouts.master')
@section('title','User Listing')
@section('content')
    <div class="content-wrapper">
      <div class="box">
       <div class="box-header">
        <div class="row">
            {{--heading title--}}
            <div class="col-md-12">
                <div class="col-md-3">
                    <h3 class="h3 list-heading-align"><strong>Staff Listing</strong></h3>
                    @if(count(Session::get('message')) != 0)
                        <div ></div>
                    @endif
                </div>
            </div>

                <div class="col-md-9 pull-right">
                   <div class="buttons ">
                        @if (Auth::guard('Cashier')->user()->role_id == 1)
                            <input class="img_btn" src="../../../assets/images/enable.png" onclick="user_active();" type="image">
                            <input class="img_btn" src="../../../assets/images/disable.png" onclick="user_disable();" type="image">
                        @endif
                        <button type="button"  onclick='user_create();' class="btn btn-default btn-md first_btn">
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        </button>
                        <button type="button" onclick='user_edit();'class="btn btn-default btn-md second_btn">
                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                        </button>
                        <button type="button" onclick="user_delete();" class="btn btn-default btn-md third_btn">
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
                    <table id="example1" class="table table-striped list-table">

                        <thead>
                            <tr class="active">
                                <th><input type="checkbox" id="user_check_all" ></th>
                                <th>No</th>
                                <th>Staff Name</th>
                                <th>Staff ID</th>
                                <th>Status</th>
                                <th>Staff Type</th>
                                <th>Change Password</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                        @foreach($users as $user)
                            <tr class="active">
                                <td><input type="checkbox" class="user_source" name="usercheck" value="{{ $user->id }}" id="all">
                                </td>
                                <td></td>
                                <td><a href="/Backend/Staff/edit/{{$user->id}}">{{ $user->user_name }}</a></td>
                                <td>{{ $user->staff_id }}</td>
                                <td>
                                    {{--@if($user->status == 1 && time() - date('H:i:s',strtotime($user->last_activity)) <= 3600)--}}

                                   {{--@if(Auth::guard('Cashier')->user()->id == $user->id)--}}
                                    @if($user->status == 1 &&
                                    \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$cur_time)
                                    ->diffInMinutes(\Carbon\Carbon::createFromFormat
                                    ('Y-m-d H:i:s',$user->last_activity)) <= 3600)
                                        <img src="/assets/images/Circle_Green.png" class="circle-image">
                                    @else
                                        <img src="/assets/images/Circle_Red.png" class="circle-image">
                                    @endif
                                </td>
                                <td>{{ $user->roles->name }}</td>
                                <td><a href="/Backend/Password/{{$user->id}}">{{ "Change Password "}}</a></td>
                                <td>@if ($user->status == 1)
                                        Enable
                                    @else
                                        Disable
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
 </div>


@endsection
