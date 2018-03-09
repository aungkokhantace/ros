
@extends('cashier.layouts.master')
@section('title','Category')
@section('content')
    <div class="container">  
        <div class="row cmn-ttl cmn-ttl1">
            <div class="container"> 
                <h3>Category Listing</h3>
            </div> 
        </div>
        <div class="row">   
            <table class="table invoice-table table-hover" id="table-pagination"> 
                <thead>
                    <tr>    
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
                            <td>{{ $category->name }}</td>
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
    </div><!-- container-fluid -->
@endsection
