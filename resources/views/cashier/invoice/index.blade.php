@extends('cashier.layouts.master')
@section('title','Invoice Listing')
@section('content')
    <div class="row">
        <div class="container">

            @if(count(Session::get('message')) != 0)
                <div>
                </div>
            @endif
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-3">
                    @if (isset($orders))
                    <h3 class="h3 list-heading-align"><strong>Invoice Listing</strong></h3>
                    @elseif (isset($ordersCancel))
                    <h3 class="h3 list-heading-align"><strong>Cancel Invoice Listing</strong></h3>
                    @endif
                </div>
                <div class="col-md-9">
                    @if(isset($orders))
                    {!! Form::open(array('url' => 'Cashier/invoice/cancel' ,'method'=>'get', 'class'=> 'form-horizontal user-form-border')) !!}
                    @elseif(isset($ordersCancel))
                    {!! Form::open(array('url' => 'Cashier/invoice' ,'method'=>'get', 'class'=> 'form-horizontal user-form-border')) !!}
                    @endif
                    <div class="col-md-3" style="padding:0;float:right;">
                        <div class="input-group" style="float:right;">
                            <select id="invoice-form" class="form-control">
                                <option @if(isset($orders)) {{ 'selected' }}@endif>Invoice List</option>
                                <option @if(isset($ordersCancel)) {{ 'selected' }}@endif>Cancel Invoice List</option>
                            </select>
                        </div>
                    </div>
                    
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    {{--tables--}}
    <div class="container">
        <div class="row">
            <div class="col-md-12 tbl-container" id="invoice_list">
                @if (isset($orders))
                    @include('cashier.invoice.invoice')
                @elseif (isset($ordersCancel))
                    @include('cashier.invoice.invoice_cancel')
                @endif
            </div>
        </div>
    </div>

<div class="modal image-slide-show-modal" tabindex="-1" role="dialog" aria-labelledby="" id="manager-modal">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <div class="bootstrap-dialog-header">
            <div class="bootstrap-dialog-close-button" style="display: block;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            </div>
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
                    <button class="btn btn-warning" onclick="checkRole()">Confirm</button>
                </div>
            </div>
        </div>
        </div>
    </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

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
    $('.order-cancel').on('click',function(e){
        e.preventDefault();
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

    function cancelOrder(id) {
        $(document).ready(function(){
            $.ajax({
                url: 'invoice/cancel/' + id,
                type: 'get',
                contentType: 'application/x-www-form-urlencoded',
                success: function (data) {
                    var message = data.message;
                    if (message == 'success') {
                        swal.close();
                        $(".tr-" + id).fadeOut('5000');
                    }
                }
            });
        });
    }
</script>

    <script>
        $(document).ready(function(){
            $('#invoice-form').on('change',function() {
                this.form.submit();
            });
        });
    </script>
@endsection
