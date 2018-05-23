
@extends('cashier.layouts.master')
@section('title','Rooms')
@section('content')
    <div class="swiper-container">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <div class="swiper-inr container">  
                    <div class="row">
                    @foreach($rooms as $room)
                        <div class="col-md-3 heightLine_02 item-btn">
                            <a href="/Cashier/MakeOrder/room/{{$room->id}}" class="bg-test">
                                <img src="/assets/cashier/images/dashboard/Invoice List.png" alt="Member" class="heightLine_03">
                                <span class="label-type">{{ $room->room_name}}</span>
                            </a> 
                        </div> 
                    @endforeach 
                    </div>  
                </div>
            </div>
        </div>
    </div><!-- swiper-container -->
@endsection
