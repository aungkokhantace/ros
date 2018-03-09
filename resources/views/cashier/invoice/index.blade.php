
@extends('cashier.layouts.master')
@section('title','Invoice Listing')
@section('content')
    <div class="container">  
        <div class="row cmn-ttl cmn-ttl1">
            <div class="container"> 
                <h3>Invoice Listing</h3>
            </div> 
        </div>
        <div class="row">   
            <table class="table invoice-table table-hover" id="table-pagination"> 
                <thead>
                    <tr>    
                        <th>Order No.</th>
                        <th>Total Amount</th>
                        <th>Date</th>
                        <th>Detail</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($orders as $order)
                    <tr class="tr-{{$order->id}}">    
                        <td id="ordere-id"> {{$order->id}} </td>
                        <td> {{$order->all_total_amount}} </td>
                        <td > {{$order->created_at }} </td>
                        <td><a class="btn detail-btn" href="/Cashier/invoice/detail/{{$order->id}}">view detail</a></td>
                        <td><a class="btn {{ $order->status == 2 ? 'btn-success' : 'btn-primary' }} status-btn" href="/Cashier/invoice/paid/{{$order->id}}">{{ $order->status == 2 ? "Paid" : "To Pay" }}</a></td>

                        <td>
                            @if($order->status == 2)
                            <button class="btn print-btn" id = '{{$order->id}}' data-toggle="modal" data-target="#printModal" data-id="{{$order->id}}" onclick="printInvoice('{{$order->id}}')"></button>
                            @else
                            <button class="btn btn-danger order-cancel" id = '{{$order->id}}' data-toggle="modal" data-target="#myModal" data-id="{{$order->id}}">Cancel</button>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div><!-- container-fluid -->

    <!-- For Modal -->

    <div class="modal image-slide-show-modal" tabindex="-1" role="dialog" aria-labelledby="" id="manager-modal">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <div class="bootstrap-dialog-header">
                <div class="bootstrap-dialog-title" id="294d853f-691f-4de9-967c-d66fd0adfb69_title">Confirm From Manager/Supervisor</div>
            </div>
            </div>
            <div class="modal-body" id="order-id">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group" id="error-blank" style="display:none;">
                        <div class="alert alert-danger">
                        <strong>Warning!</strong> Fill Username and Password
                        </div>
                    </div>

                    <div class="form-group" id="error-wrong" style="display:none;">
                        <div class="alert alert-danger">
                        <strong>Warning!</strong> Wrong Username or Password
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="control-label">Username:</label>
                        <input type="text" class="form-control" id="adm-user" placeholder="Manager/Supervisor Username" />
                    </div>

                    <div class="form-group">
                        <label for="message-text" class="control-label">Password:</label>
                        <input type="password" class="form-control" id="adm-pass" placeholder="Manager/Supervisor Password" />
                    </div>
                    <input type="hidden" name="orderId" id="orderId" value="" />

                    <div class="form-group">
                        <button class="btn btn-warning confirm" onclick="checkRole()">Confirm</button>
                        <button type="button" class="btn btn-info" data-dismiss="modal" aria-label="Close" id="close">Close</button>
                    </div>
                </div>
            </div>
            </div>
        </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- End Modal -->
    @if (isset($orders))
        @foreach($orders as $order)
            @include('cashier.invoice.invoice_print')
        @endforeach
    @endif

    @if (Auth::guard('Cashier')->user()->role_id == 1 || Auth::guard('Cashier')->user()->role_id == 2 || Auth::guard('Cashier')->user()->role_id == 3)
        @php 
            $roleCheck    = "Admin";
        @endphp
    @elseif (Auth::guard('Cashier')->user()->role_id == 4)
        @php 
            $roleCheck    = "Cashier";
        @endphp
    @endif

    <script>

        $(document).on('click', '.order-cancel', function(e) {
            var id      = this.id;
            var role    = '<?php echo $roleCheck; ?>';
            if (role == 'Admin') {
                swal({
                    title: "Are you sure?",
                    text: "You will not be able to recover this payment!",
                    type: "success",
                    showCancelButton: true,
                    confirmButtonColor: "#86CCEB",
                    confirmButtonText: "Confirm",
                    closeOnConfirm: false
                }, function(isConfirm){
                    if (isConfirm) {
                        cancelOrder(id);
                    };
                });
            } else {
                $("#orderId").val(id);
                $('#manager-modal').modal('show');
            }

        });
        function printInvoice(invoice) {
            var id      = invoice;
            var modal   = id + '-print';
            $('#' + modal).modal('show');
        }

        function printElement(e) {
            var ifr = document.createElement('iframe');
            ifr.style='height: 0; width: 0px; position: absolute'

            document.body.appendChild(ifr);

            $(e).clone().appendTo(ifr.contentDocument.body);
            ifr.contentWindow.print();

            ifr.parentElement.removeChild(ifr);
        }

        function print_click(clicked_id)
        {
            var clickID     = clicked_id;
            var printID     = clickID + "-print-table";
            var test        = document.getElementById(printID);
            printElement(document.getElementById(printID));
        }

        function cancelOrder(id) {
            $(document).ready(function(){
                $.ajax({
                    url: '/Cashier/invoice/cancel/' + id,
                    type: 'get',
                    contentType: 'application/x-www-form-urlencoded',
                    success: function (data) {
                        var message = data.message;
                        if (message == 'success') {
                            swal.close();
                            $(".tr-" + id).fadeOut('5000');
                            $("#adm-user").val('');
                            $("#adm-pass").val('');
                            $('#close').click();
                            //Socket Emit
                            var socketKey        = "order_update";
                            var socketValue      = {order_update : 'order_update'};
                            socketEmit(socketKey,socketValue);
                        }
                    }
                });
            });
        }
    </script>
@endsection
