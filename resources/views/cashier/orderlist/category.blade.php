@extends('cashier.layouts.master')
@section('title','Make Order')
@section('content')
    <div class="col-md-12"><a href="\Cashier\MakeOrder">Back</a></div>
    <div class="col-md-4">
        <div class="col-md-6">
            <div class="col-md-6">
                <a href="\Cashier\MakeOrder\setmenu"><img id="img" class="bottom image" src= "../../../assets/images/burger.jpg" width="150px" height="150px"></a>
                <p><a href="\Cashier\MakeOrder\setmenu">SetMenu</a></p>
            </div>    
        </div>
        @foreach($items as $item)
            <div class="col-md-6">
                <a href="\Cashier\MakeOrder\categorydetail\{{$item->id}}"><img id="img" class="bottom image" src= "/uploads/{{$item->image}}" width="150px" height="150px"></a>
                <p><a href="\Cashier\MakeOrder\categorydetail\{{$item->id}}">{{ $item->name}}</a></p>
            </div>    
        @endforeach
    </div>
    <div class="col-md-8">
        <table class="table table-striped list-table" id="myTable">
            <tr>
                <th>ItemName</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Discount</th>
                <th>Extra</th>
                <th>Extra Price</th>
                <th>Amount</th>
                <th>TakeAway</th>
            </tr>
             @if(session('chosen_item') != null)

                @foreach(session('chosen_item') as $s)
                    
                    <tr>
                        <th>@if($s['type'] == 'setmenu')
                                {{$s['set_menu_name']}}
                            @else
                                {{$s['item_name']}}    
                            @endif    
                        </th>
                        <th>@if($s['type'] == 'setmenu')
                                {{$s['quantity']}}
                            @else
                                {{ $s['item_quantity']}}  
                            @endif      
                        </th>
                        <th>@if($s['type'] == 'setmenu')
                                {{$s['set_menu_price']}}
                            @else
                                {{$s['item_price']}}
                            @endif    
                        </th>
                        <th>
                            @if($s['type'] == 'setmenu')
                                {{$s['set_discount_amount']}}
                            @else
                                {{$s['item_discount_amount']}}
                            @endif
                        </th>
                        <th></th>
                        <th></th>
                        <th>
                            @if($s['type'] == 'setmenu')
                                {{$s['set_amount']}}
                            @else
                                {{$s['item_amount']}}
                            @endif
                        </th>
                        <th></th>
                    </tr>
                  
                @endforeach    
            @endif    
        </table>
    </div>
@endsection