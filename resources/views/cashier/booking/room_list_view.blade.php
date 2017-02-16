@extends('cashier.layouts.master')
@section('title','Booking')
@section('content')
    <div class="row">
        <div class="container">
            <div class="col-md-12">
                <ul class="nav nav-tabs">
                    <li role="presentation"><a href="/Cashier/Booking/index">Booking Listing</a></li>
                    <li role="presentation"><a href="/Cashier/Booking/tableListView">Table View</a></li>
                    <li role="presentation" class="active"><a href="/Cashier/Booking/roomListView">Room View</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="container">
            <div class="col-md-10">
                <h3>Room View</h3>
            </div>
        </div>
    </div>
    <div class="row label-height">
        <div class="container">
            <div class="col-md-2 view-label"><span class="label-available"><label>Available</label></span></div>
            <div class="col-md-2 view-label"><span class="label-service"><label>Service</label></span></div>
            <div class="col-md-2 view-label"><span class="label-warnings"><label>Warning</label></span></div>
            <div class="col-md-2 view-label"><span class="label-waiting"><label>Waiting</label></span></div>
        </div>
    </div>
    <div class="row">
        <div class="container" id="room-frame">
            @include('cashier.booking.rooms')
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            setInterval(ajaxCall, 60000); //60000 MS == 1 minutes
            function ajaxCall() {
                $.ajax({
                    type: 'GET',
                    url: '/Cashier/Booking/roomRequest',
                    success: function (Response) {
                        console.log(Response);
                        $('#room-frame').html('');
                        $('#room-frame').append(Response);
                    }
                })
            }
        });
    </script>
@endsection