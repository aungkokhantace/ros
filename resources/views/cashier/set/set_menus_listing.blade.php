
@extends('cashier.layouts.master')
@section('title','Set Menu')
@section('content')
    <div class="container">  
        <div class="row cmn-ttl cmn-ttl1">
            <div class="container"> 
                <h3>Set Menu Listing</h3>
            </div> 
        </div>
        <div class="row">   
            <table class="table invoice-table table-hover" id="table-pagination"> 
                <thead>
                    <tr>    
                        <th>Set menu Name</th>
                        <th>Items</th>
                        <th>Price</th>
                        <th>Image</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($set_menu as $set)
                    <tr>    
                        <td id="ordere-id">{{ $set->set_menus_name }}</td>
                        <td>
                            @foreach($set->set_item as $sitem)
                                @foreach($items as $item)
                                    @if($sitem->item_id == $item->id)
                                        {{ $item->name }},
                                    @endif
                                @endforeach
                            @endforeach
                        </td>
                        <td> {{ $set->set_menus_price}} </td>
                        <td>{{ $set->image }}</td>

                        <td>
                            @if( $set->status==0)
                                {{"Not Available"}}
                            @else
                                {{"Available"}}
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div><!-- container-fluid -->
@endsection
