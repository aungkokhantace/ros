@extends('Backend.layouts.master')
@section('title','Invoice Listing')
@section('content')
<style type="text/css">
    tfoot {
        display: table-header-group;
    }
</style>
 <div class="content-wrapper">
      <div class="box">
       <div class="box-header">
    <div class="row">
        <div class="container">
            @if(count(Session::get('message')) != 0)
                <div>
                </div>
            @endif
        </div>
    </div>

    
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-3">
                    @if (isset($orders))
                    <h3 class="h3 list-heading-align"><strong>Invoice Listing</strong></h3>
                    @elseif (isset($ordersCancel))
                    <h3 class="h3 list-heading-align"><strong>Cancel Invoice Listing</strong></h3>
                    @endif

                    @if (isset($sortBy))
                    <input type="hidden" id="{{ $sortBy }}/{{ $amount }}/" class="sorting"/>
                    @else
                    <input type="hidden" id="no-sroting" class="sorting"/>
                    @endif

                </div>
                </div>
               
                <div class="col-md-12">
                    <div class="col-md-12" style="padding:0;float:right;">
                        <div class="input-group" style="float:left;">
                            <select id="invoice-form" style="width:400px" class="form-control" onchange="sortingOrder()">
                                @if (isset($sortBy))
                                    <option value="">Invoice List</option>
                                    <option value="/cancel" @if ($sortBy == 'cancel' AND $amount == '') {{'selected'}} @endif >Cancel Invoice List</option>
                                    <option value="/sort/time/increase" @if ($sortBy == 'time' AND $amount == 'increase') {{'selected'}} @endif >Sort By Lastest Order Time</option>
                                    <option value="/sort/time/decrease" @if ($sortBy == 'time' AND $amount == 'decrease') {{'selected'}} @endif>Sort By Early Order Time</option>
                                    <option value="/sort/price/increase" @if ($sortBy == 'price' AND $amount == 'increase') {{'selected'}} @endif>Sort By Maximum Order Price</option>
                                    <option value="/sort/price/decrease" @if ($sortBy == 'price' AND $amount == 'decrease') {{'selected'}} @endif>Sort By Minimum Order Price</option>
                                @else
                                    <option value="">Invoice List</option>
                                    <option value="/cancel">Cancel Invoice List</option>
                                    <option value="/sort/time/increase">Sort By Lastest Order Time</option>
                                    <option value="/sort/time/decrease">Sort By Early Order Time</option>
                                    <option value="/sort/price/increase">Sort By Maximum Order Price</option>
                                    <option value="/sort/price/decrease">Sort By Minimum Order Price</option>
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--tables--}}
    <div class="container">
        <div class="row">
            <div class="col-md-12 tbl-container" id="invoice_list">
                @if (isset($orders))
                <div id="invoice-wrapper">
                    @include('Backend.invoice.invoice')
                </div>
                @elseif (isset($ordersCancel))
                    @include('Backend.invoice.invoice_cancel')
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
@if (isset($orders))
    @foreach($orders as $order)
        @include('Backend.invoice.invoice_print')
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
</div>
</div>

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
                url: '/Backend/invoice/cancel/' + id,
                type: 'get',
                contentType: 'application/x-www-form-urlencoded',
                success: function (data) {
                    var message = data.message;
                    if (message == 'success') {
                        swal.close();
                        $(".tr-" + id).fadeOut('5000');
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

<script>
    $(document).ready(function(){
        $('#invoice-form').on('change',function() {
            this.form.submit();
        });
        var sortID  = $('.sorting').attr('id');
        if (sortID == 'no-sroting') {
            var url     = "/Backend/ajaxSearchRequest";
            DataTableSearch(url);
        }
        if(sortID == 'time/increase/') {
            var url     = "/Backend/ajaxSearchTimeIncreaseRequest";
            DataTableSearch(url);
        } 
        if (sortID == 'time/decrease/') {
            var url     = "/Backend/ajaxSearchTimeDecreaseRequest";
            DataTableSearch(url);
        }
        if (sortID == 'price/increase/') {
            var url     = "/Backend/ajaxSearchPriceIncreaseRequest";//Json Callback Url
            DataTableSearch(url);
        }

        if (sortID == 'price/decrease/') {
            var url     = "/Backend/ajaxSearchPriceDecreaseRequest";//Json Callback Url
            DataTableSearch(url);
        }
        if (sortID == 'cancel//') {
            var url     = "/Backend/ajaxSearchCancelRequest";
            DataTableSearch(url);
        }

    });

    function sortingOrder() {
        var selectedOpt      = document.getElementById('invoice-form').value;
        window.location.href = "/Backend/invoice" + selectedOpt;
    }
</script>

<script>
function DataTableSearch(url) {
    $('#example2 tfoot th.search-col').each( function () {
        var title = $('#example2 thead th').eq( $(this).index() ).text();
        $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
    } );
    var table = $('#example2').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": url,
        iDisplayLength: 10,
        "ordering":false,
        "bLengthChange": false,
        "bFilter": true,
        "bInfo": false,
        "bAutoWidth": false,
        "columnDefs": [ {
        "searchable": false,
        "orderable": false,
        "targets": 0
        } ],
        "order": [[ 1, "desc" ]],
        stateSave: false,
        "dom": '<"pull-right m-t-20"i>rt<"bottom"lp><"clear">',

    });

    table.on( 'order.dt search.dt', function () {
        table.column(1, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw(); 
    // Apply the search
    table.columns().eq( 0 ).each( function ( colIdx ) {
        $( 'input', table.column( colIdx ).footer() ).on( 'keyup change', function () {
            table
                    .column( colIdx )
                    .search( this.value )
                    .draw();
        } );

    });
}
</script>
@endsection