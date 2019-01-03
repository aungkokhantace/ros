@extends('Backend.layouts.master')
@section('title','Branch Listing')
@section('content')
     <div class="content-wrapper">
      <div class="box">
       <div class="box-header">
        <div class="row">
            {{--heading title--}}
            <div class="col-md-12">
                <div class="col-md-3">
                    <h3 class="h3 list-heading-align"><strong>Branch Listing</strong></h3>
                    @if(count(Session::get('message')) != 0)
                        <div ></div>
                    @endif
                </div>
            </div>
            
                <div class="col-md-9 pull-right">
                    <div class="buttons">
                        <button type="button"  onclick='branch_create();' class="btn btn-default btn-md first_btn">
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        </button>
                        <button type="button" onclick='branch_edit();'class="btn btn-default btn-md second_btn">
                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                        </button>
                      <!--   <button type="button" onclick="branch_delete();" class="btn btn-default btn-md third_btn">
                            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                        </button> -->
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
                        <th>Name</th>
                        <th>Description</th>
                    </tr>
                    </thead>
                    <tbody>

                        @foreach($branchs as $branch)
                            <tr class="active">
                                <td> <input class="source" type="checkbox" name="branch_check" value="{{ $branch->id }}" id="all" />
                                </td>
                                <td></td>
                                <td><a href="/Backend/Branch/edit/{{$branch->id}}">{{ $branch->name}}</a></td>
                                <td>{{ $branch->description}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

