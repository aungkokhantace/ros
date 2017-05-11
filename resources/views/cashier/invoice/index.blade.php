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
            {{--heading title--}}


        </div>
    </div>
    {{--tables--}}
    <div class="container">
        <div class="row">
            <div class="col-md-12 tbl-container" id="invoice_list">

                @include('cashier.invoice.invoice')

            </div>
        </div>
    </div>
    <script type="text/javascript">


        $(document).ready(function() {
            setInterval(ajaxCall, 300000); //300000 MS == 5 minutes
            function ajaxCall() {
                $.ajax({
                    type: 'GET',
                    url: '/Cashier/invoice/ajaxInvoiceRequest',
                    success: function (Response) {
                        console.log(Response);
                        $('#invoice_list').html('');
                        $('#invoice_list').append(Response);
                    }
                })
            }


        });

    </script>

@endsection
