@extends('cashier.layouts.master')
@section('title','Food Order List')
@section('content')
    <section class="content">
        <div class="row">
          <div class="col-md-12" id="autoDiv">
              @include('cashier.foodorderlist.order')
          </div>
        </div>
    </section>

    <script>
        setInterval(ajaxCall, 300000); //300000 MS == 5 minutes
        function ajaxCall() {
            $.ajax({
                type: 'GET',
                url: '/Cashier/OrderView/ajaxRequest',
                success: function (Response) {
                    console.log(Response);
                    $('#autoDiv').html('');
                    $('#autoDiv').append(Response);
                }
            })
        }
</script>

<script>
    var socket = io.connect( 'http://'+window.location.hostname+':3000' );
    socket.emit('new_count_message', { 
        new_count_message: data.new_count_message
    });

    socket.emit('new_message', { 
        name: data.name,
        email: data.email,
        subject: data.subject,
        created_at: data.created_at,
        id: data.id
    });
</script>

@endsection
