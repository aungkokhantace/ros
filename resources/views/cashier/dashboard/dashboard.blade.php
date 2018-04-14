
@extends('cashier.layouts.master')
@section('title','Dashboard')
@section('content')
    <div class="swiper-container">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <div class="swiper-inr container">  
                    <div class="row">
                        <div class="col-md-3">
                            <div class="item-calendar text-center"> 
                                <div class="calendar-box">  
                                    <span class="item-month">{{ Carbon\Carbon::parse($sessions->daystart->start_date)->format('F') }}</span>
                                    <span class="item-date">{{ Carbon\Carbon::parse($sessions->daystart->start_date)->format('d S') }}</span>
                                </div>

                                @if($sessions->daystart->status == 1)
                                <button class="btn btn-primary day-st-btn start" id="{{ $sessions->daystart->start_date}}/{{$sessions->daystart->status }}">Day Start</button>
                                @else
                                <button class="btn btn-primary day-st-btn" onclick="dayEnd({{ $sessions->daystart->id }})">Day End</button>
                                @endif
                            </div>
                        </div> 
                        <div class="col-md-3 heightLine_02 item-btn">
                            <a href="/Cashier/invoice" class="bg-test">
                                <img src="/assets/cashier/images/dashboard/Invoice List.png" alt="Member" class="heightLine_03">
                                <span class="label-type">Invoice List</span>
                            </a> 
                        </div> 
                        <div class="col-md-3 heightLine_02 item-btn">                                
                            <a href="/Cashier/OrderView/index">
                                <img src="/assets/cashier/images/dashboard/OrderList.png" alt="Order List" class="heightLine_03">
                                <span class="label-type">Order List</span>
                            </a>                                 
                        </div> 

                        @if ($sessions->daystart->session_status == 2)
                        <div class="col-md-3">
                            <div class="item-calendar text-center "> 
                                <div class="calendar-box">  
                                    <span class="item-month">SHIFT</span>
                                    <span class="shift-name">{{ $sessions->shift->name }}</span>
                                </div>
                                <button class="btn btn-primary day-st-btn" onclick="shiftStart(day_id = '{{ $sessions->daystart->id }}',shiftID = {{ $sessions->shift->id }},status = {{ $sessions->shift->next_status }})">{{ $sessions->shift->name }}
                                    @if($sessions->shift->current_status == 0)
                                        {{ ' Start'}}
                                    @else
                                        {{ ' End'}}
                                    @endif
                                </button>
                            </div>
                        </div> 
                        @endif

                        <div class="col-md-3 heightLine_02 item-btn">                                
                            <a href="/Cashier/SetMenu/index">
                                <img src="/assets/cashier/images/dashboard/Set.png" alt="service" class="heightLine_03">
                                <span class="label-type">Set Menu</span>
                            </a>                                 
                        </div> 

                        <div class="col-md-3 heightLine_02 item-btn">                                
                            <a href="/Cashier/Item/index">
                                <img src="/assets/cashier/images/dashboard/Item List.png" alt="staff" class="heightLine_03">
                                <span class="label-type">Item List</span>
                            </a>                                 
                        </div>

                        <div class="col-md-3 heightLine_02 item-btn">                                
                            <a href="/Cashier/Category/index">
                                <img src="/assets/cashier/images/dashboard/Category.png" alt="report" class="heightLine_03">
                                <span class="label-type">Category</span>
                            </a>                                 
                        </div>   
                        <div class="col-md-3 heightLine_02 item-btn">                                
                            <a href="#">
                                <img src="/assets/cashier/images/dashboard/general.png" alt="general" class="heightLine_03">
                                <span class="label-type">General</span>
                            </a>                                 
                        </div>  
                    </div>  
                </div>
            </div>

            <div class="swiper-slide">
                <div class="swiper-inr container">  
                    <div class="row"> 
                        <div class="col-md-3 heightLine_02 item-btn">                                
                            <a href="/Cashier/MakeOrder">
                                <img src="/assets/cashier/images/dashboard/Set.png" alt="service" class="heightLine_03">
                                <span class="label-type">Make Order</span>
                            </a>                                 
                        </div> 
                    </div>  
                </div>
            </div>
        </div>
        <!-- Add Arrows -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div><!-- swiper-container -->

    @if(!empty(Session::get('error_code')) && Session::get('error_code') == 5)
        <div class="modal image-slide-show-modal" tabindex="-1" role="dialog" aria-labelledby="" id="manager-modal">
            <div class="modal-dialog" role="document" style="width: 800px;">
            <div class="modal-content">
                <div class="modal-header">
                <div class="bootstrap-dialog-header">
                    <div class="bootstrap-dialog-close-button" style="display: block;">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
                    </div>
                    <div class="bootstrap-dialog-title" id="294d853f-691f-4de9-967c-d66fd0adfb69_title">Pay All Invoice Before Day End</div>
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
                                    <th><label>Void</label></th>
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
                                    <td>
                                        <a href="/Cashier/invoice" class="btn btn-danger">Cancel</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
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
                                console.log(data);
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
