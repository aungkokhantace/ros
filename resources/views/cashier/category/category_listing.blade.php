@extends('cashier.layouts.master')
@section('title','Category')
@section('content')
    <div class="container">
        <div class="row">
            {{--heading title--}}
            <div class="col-md-12">
                <div class="col-md-3">
                    <h3 class="h3 list-heading-align"><strong>Category Listing</strong></h3>
                    @if(count(Session::get('message')) != 0)
                        <div ></div>
                    @endif
                </div>
                <div class="col-md-9">
                    <div class=" buttons">
                        {{--create button--}}
                        <button name="create category" type="button" class="btn btn-default btn-md first_btn" onclick="category_create();">
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        </button>

                        {{--edit button--}}
                        <button name="edit category" type="button" class="btn btn-default btn-md second_btn" onclick="categoryEdit();">
                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                        </button>

                        {{--delete button--}}
                        <button name="delete category" type="button" class="btn btn-default btn-md third_btn" onclick="categoryDelete();">
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
                                <th>Category Name</th>
                                <th>Kitchen</th>
                                <th>Category Image</th>
                                <th>Description</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($categorylist as $category)
                                <tr class="active">
                                    <td><input type="checkbox" name="category-check" class="source" value="{{ $category->id }}" id="all">

                                    </td>
                                    <td></td>
                                    <td><a href="/Cashier/Category/edit/{{$category->id}}">{{ $category->name }}</a></td>
                                    <td>{{ $category->kitchen->name }}</td>
                                    <td>{{ $category->image }}</td>
                                    <td>{{ $category->description }}</td>
                                    <td>
                                        @if($category->status == 1)
                                            {{'Available'}}

                                        @else
                                            {{'Not Available'}}
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
