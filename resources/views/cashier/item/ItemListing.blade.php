
@extends('cashier.layouts.master')
@section('title','Item')
@section('content')
    <div class="container">  
        <div class="row cmn-ttl cmn-ttl1">
            <div class="container"> 
                <h3>Item Listing</h3>
            </div> 
        </div>
        <div class="row">   
            <table class="table invoice-table table-hover" id="table-pagination"> 
                <thead>
                    <tr>    
                        <th>Item Name</th>
                        <th>Item Category</th>
                        <th>Item Image</th>
                        <th>Item Description</th>
                        <th>Item Price</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($items as $item)
                    @if ($item->group_id == '' || $item->isdefault == 1)
                    <tr class="active">
                        <td>{{ $item->name}}</td>
                        <td>{{ $item->category->name}}</td>
                        <td>{{ $item->image}}</td>
                        <td>{{ $item->description}}</td>
                        <td>{{ $item->price}}</td>
                        <td>
                            @if($item->status == 1)
                                {{'Available'}}
                            @else
                                {{'Not Available'}}
                            @endif
                        </td>
                    </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
        </div>
    </div><!-- container-fluid -->
@endsection
