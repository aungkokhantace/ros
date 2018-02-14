@extends('cashier.layouts.master')
@section('title','Day Start Listing')
@section('content')
    <div class="container">
        <div class="row">
            {{--Start heading title--}}
            <div class="col-md-12">
                <div class="col-md-3">
                    <h3 class="h3 list-heading-align"><strong>Day Start Listing</strong></h3>
                    @if(count(Session::get('message')) != 0)
                        <div ></div>
                    @endif
                </div>
                {{--End heading title--}}
                <div class="col-md-9">
                    <div class="buttons">
                        <button type="button" class="btn btn-default btn-md first_btn" onclick="day_create();">
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        </button>
                        <button type="button" class="btn btn-default btn-md third_btn" onclick="day_delete();">
                            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        {{--End Buttons--}}
    </div>
        {{--Start table--}}
        <div class="container">
            <div class="row">
                <div class="col-md-12 tbl-container">
                    <div class="col-md-12"></div>
                    <table id="example1" class="table table-striped list-table">
                        <thead>

                        <tr class="active">
                            <th> <input type='checkbox' name='day_check' id='check_all'/></th>
                            <th>No</th>
                            <th>Day Code</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($daystarts as $daystart)
                             <tr class="active">
                                <td>
                                    <input type="checkbox" class="source" name="day_check" value="{{ $daystart->id }}">
                                </td>
                                <td></td>
                                <td>{{ $daystart->day_code }}</td>
                                <td>{{ $daystart->start_date }}</td>
                                <td>
                                    @if($daystart->status == 1)
                                        Opening
                                    @else
                                        Close
                                    @endif 
                                </td>
                                <td>
                                    <button type="button" class="btn btn-success" onclick="dayStart({{ $daystart->id }})">Day End</button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <script type="text/javascript">
            function dayStart(daystart) {
                window.location.href = '/Cashier/DayEnd/' + daystart;
            }
        </script>

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
@endsection
