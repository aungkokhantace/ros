
@extends('cashier.layouts.master')
@section('title','Dashboard')
@section('content')

    <div class="container">
        @section('dayEnd')
            @if($sessions->daystart->status == 1)
            <button class="btn btn-large dash-btn ml-2 mb-2 start" id="{{ $sessions->daystart->start_date}}/{{$sessions->daystart->status }}" style="background:rgb(75, 146, 221);">
                Day Start
            </button>
            @else
            <button class="btn btn-large dash-btn ml-2 mb-2" onclick="dayEnd({{ $sessions->daystart->id }})" style="background:rgb(75, 146, 221);">Day End</button>
            @endif
        @endsection

        @section('nightEnd')
            @if ($sessions->daystart->session_status == 2)
            <button class="btn btn-large dash-btn mb-2" style="background:rgb(75, 146, 221)" onclick="shiftStart(day_id = '{{ $sessions->daystart->id }}',shiftID = {{ $sessions->shift->id }},status = {{ $sessions->shift->next_status }})">{{ $sessions->shift->name }}
                @if($sessions->shift->current_status == 0)
                    {{ ' Start'}}
                @else
                    {{ ' End'}}
                @endif
            </button>
            @endif
        @endsection

        @foreach($locations as $location)
            <button type="button" value="{{$location->id}}" class="btn btn-outline-dark btn-lg mr-2 mt-1 location_btn">{{ $location->location_type }}</button>
        @endforeach

       <button type="button" class="btn btn-outline-dark btn-lg mt-2 room_btn">Rooms</button>

       <a href="/Cashier/takeaway/invoice" class="btn btn-outline-info btn-lg mt-2 ml-2">Take Away</a>

        <div class="row">
            <div class="col-md-6">
                <p class="mt-3 float-right"><i class="fa fa-square"  style="color:#8EC449; font-size:30px; aria-hidden="true"></i>
                    <span class="">Avaliable</span>
                </p>
            </div>
            <div class="col-md-6">
                <p class="mt-3"><i class="fa fa-square" style="color:#4F94DA; font-size:30px;" aria-hidden="true"></i>
                    <span class="">Service</span>
                </p>
            </div>
        </div>
        
        <div class="row append_list">
            
        </div>
    </div>  


    @if(!empty(Session::get('error_code')) && Session::get('error_code') == 5)
        <div class="modal image-slide-show-modal" tabindex="-1" role="dialog" aria-labelledby="" id="manager-modal">
            <div class="modal-dialog" role="document" style="width: 800px;">
            <div class="modal-content">
                <div class="modal-header">
                <div class="bootstrap-dialog-header">
                    <div class="bootstrap-dialog-close-button" style="display: block;">
                    </div>
                    <div class="bootstrap-dialog-title" id="294d853f-691f-4de9-967c-d66fd0adfb69_title">
                        Pay All Invoice Before Day End 
                    </div>
                </div>
                </div>
                <div class="modal-body" id="order-id">
                <div class="row">
                    <div class="col-md-12">
                        <h4>This Invoice are not paid yet.You need to pay this invoice first.</h4>
                        <table class="table table-striped " id="unpaid-invoice">
                            <thead>
                                <tr>
                                    <th><label>Order No</label></th>
                                    <th><label>Total Amount</label></th>
                                    <th><label>Date</label></th>
                                    <th><label>Pay</label></th>
                                    {{-- <th><label>Void</label></th> --}}
                                </tr>
                            </thead>
                            <tbody>
                            @foreach(Session::get('orders') as $order)
                                <tr>
                                    <td id="ordere-id">{{ $order->id }}</td>
                                    <td>{{ $order->all_total_amount }}</td>
                                    <td>{{ $order->order_time }}</td>
                                    <td>
                                        <a href="/Cashier/invoice/paid/{{ $order->id }}" class="btn btn-success">Pay</a>
                                    </td>
                                    {{-- <td> 
                                        <a href="/Cashier/invoice" class="btn btn-danger">Cancel</a>
                                     </td> --}}
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <a href="/Cashier/invoice" class="btn btn-primary btn-sm">Go to invoice list</a>
                        <a href="/Cashier/Dashboard" class="btn btn-danger btn-sm">Close</a>
                    </div>
                </div>
                </div>
            </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <script type="text/javascript">
            $('#manager-modal').modal('show');
        </script>
        @endif

    <script type="text/javascript">
        $(document).ready(function(){

            var locationId = $(".location_btn").val();     

            getTables(locationId);  

            $(`.location_btn[value=${locationId}]`).prop("disabled",true);

        });

         $(".location_btn").click(function(){

            $(".location_btn").prop("disabled",false);     
            $(".room_btn").prop("disabled",false);            

            $('.append_list').html('');
            $('.append_list').text('');

            var locationId = $(this).val();

            $(this).prop("disabled",true);
            
            getTables(locationId);
        });

        $(".room_btn").click(function(){

            var locationId = '';
            $(".location_btn").prop("disabled",false);     
            $(".room_btn").prop("disabled",true);                     
            $('.append_list').html('');
            $('.append_list').text('');
            getRooms();

        });

        function getRooms()
        {
            $.ajax({
            url: '/Cashier/Rooms',
            type:"GET",
            dataType:"json",
            beforeSend: function(){

            },

            success:function(response) {

                var lengths = Object.keys(response).length;

                for (i = 0; i < lengths; i++) {

                    if(response[i].status == 0){

                        $('.append_list').append(`<div class='col-lg-2 col-md-3 col-sm-4 mb-2'><a href='/Cashier/room/${response[i].id}/invoice' class='btn btn-success avaliable-btn'>${response[i].room_name}</a></div>`);

                    }else{

                        $('.append_list').append(`<div class='col-lg-2 col-md-3 col-sm-4 mb-2'><a href='/Cashier/room/${response[i].id}/invoice' class='btn btn-info service-btn'>${response[i].room_name}</a></div>`);
                    }
                }
            },
            complete: function(){
            }
            });
        }

        function getTables(locationId)
        {
            $.ajax({
                url: '/Cashier/Tables/'+locationId,
                type:"GET",
                dataType:"json",
                beforeSend: function(){

                },

                success:function(response) {

                    var lengths = Object.keys(response).length;

                    for (i = 0; i < lengths; i++) {
                        if(response[i].status == 0){

                            $('.append_list').append(`<div class='col-lg-2 col-md-3 col-sm-4 mb-2'><a href='/Cashier/table/${response[i].id}/invoice' class='btn btn-success avaliable-btn'>${response[i].table_no}</a></div>`);

                        }else{

                            $('.append_list').append(`<div class='col-lg-2 col-md-3 col-sm-4 mb-2'><a href='/Cashier/table/${response[i].id}/invoice' class='btn btn-info service-btn'>${response[i].table_no}</a></div>`);
                        }
                    }
                },
                complete: function(){
                }
            });
        }

    </script>
            
    <script type="text/javascript">

        $(document).ready(function(){
            $('.start').click(function(){

                id          = $(this).attr('id');
                id_arr      = id.split('/');
                start_date  = id_arr[0];
                status      = id_arr[1];
                if (status == 1) {
                    next_status     = 2;
                } else if(status == 2) {
                    next_status     = 3;
                }
                var dataString = {
                      _token            : '{{ csrf_token() }}',
                      start_date        : start_date,
                      status            : next_status
                };
                swal({   
                    title: "Are you sure?",
                    text: "You will not be able to recover this item!",
                    type: "success",
                    showCancelButton: true,
                    confirmButtonColor: "#86CCEB",
                    confirmButtonText: "Confirm",
                    closeOnConfirm: false
                },
                function (isConfirm) {
                    if (isConfirm) {
                        $.ajax({
                            url     : '/Cashier/DayStart/store',
                            type    : 'POST',
                            data    : dataString,
                            dataType: "json",
                            cache   : false,
                            success: function(data) {
                                var success     = data.success;
                                var error       = data.error;
                                if (success == '1') {
                                    location.reload();
                                } else {
                                    console.log('error');
                                }
                            },
                            error: function(data) {
                                alert('error');   
                            }
                        });
                    }
                });

            });
        });
    </script>

    <script type="text/javascript">
        function shiftStart(id,shift,status) {
            swal({   
                    title: "Are you sure?",
                    text: "You will not be able to recover this item!",
                    type: "success",
                    showCancelButton: true,
                    confirmButtonColor: "#86CCEB",
                    confirmButtonText: "Confirm",
                    closeOnConfirm: false
                },
                function(isConfirm){
                    if (isConfirm) {
                        window.location.href = '/Cashier/DayStart/Shift/' + id + '/' + shiftID + '/' + status;
                    }
                });
        }

        function dayEnd(id) {
            swal({   
                    title: "Are you sure?",
                    text: "You will not be able to recover this item!",
                    type: "success",
                    showCancelButton: true,
                    confirmButtonColor: "#86CCEB",
                    confirmButtonText: "Confirm",
                    closeOnConfirm: false
                },
                function(isConfirm){
                    if (isConfirm) {
                        window.location.href = '/Cashier/DayStart/end/' + id;
                    }
                });
        }
    </script>
@endsection
