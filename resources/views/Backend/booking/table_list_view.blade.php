@extends('Backend.layouts.master')
@section('title','Booking')
@section('content')
<div class="content-wrapper">
      <div class="box">
       <div class="box-header">
    <div class="row">
        <div class="container">
            <div class="col-md-12">
                <ul class="nav nav-tabs">
                    <li role="presentation"><a href="/Backend/Booking/index">Booking Listing</a></li>
                    <li role="presentation" class="active"><a href="/Backend/Booking/tableListView">Table View</a></li>
                    <li role="presentation"><a href="/Backend/Booking/roomListView">Room View</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="container">
            <div class="col-md-10">
                <h3>Table View</h3>
            </div>
         </div>
    </div>
</div>
</div>
    <div class="row label-height">
        <div class="container">
            <div class="col-md-2 view-label"><span class="label-available"><label>Available</label></span></div>
            <div class="col-md-2 view-label"><span class="label-service"><label>Service</label></span></div>
        </div>
    </div>
    <div class="row">
        <div class="container" id="table-frame">
            @include('Backend.booking.tables')
        </div>
    </div>
</div>
    <script type="text/javascript">
        $(document).ready(function() {
            setInterval(ajaxCall, 60000); //60000 MS == 1 minutes
            function ajaxCall() {
                $.ajax({
                    type: 'GET',
                    url: '/Backend/Booking/tableRequest',
                    success: function (Response) {
                        console.log(Response);
                        $('#table-frame').html('');
                        $('#table-frame').append(Response);
                    }
                })
            }
        });

        $(document).ready(function(){
            //For Socket On
            var url     = "/Backend/Booking/tableRequest";//Json Callback Url
            var div     = "table-frame";//Put div id inside html response
            
            //Order Create Socket
            var invoice_update      = "invoice_update";
            socketOn(invoice_update,url,div);

            //Invoice Payment Socket
            var payment_done      = "payment_done";
            socketOn(payment_done,url,div);
        }); 
    </script>


@endsection