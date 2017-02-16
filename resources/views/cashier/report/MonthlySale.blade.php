@extends('cashier.layouts.master')
@section('title','Sale Report Summary')
@section('content')
    {{--title--}}
    <div class="container">
        {{--Order Listing Table--}}
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-3">
                        <h3 class="h3 report_heading"><strong> Sale Report</strong></h3>
                    </div>
                    <div class="col-md-8 list-view">
                        @if(isset($m))
                            <a href="{{ '/Cashier/monthlySaleExport/'.$y.'/'.$m }}"  >
                                <button class="btn btn-success btn_export">Export</button>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            <br/>
            <div class="row" id="autoDiv">
                <div class="col-md-11 ">
                    <table class="table table-bordered">
                        <thead class="thead_report">
                        <tr class="report-th">
                            <th>Invoice ID</th>
                            <th>Date</th>
                            <th>Staff</th>
                            <th>Quantity</th>
                            <th>Price</th>
                        </tr>
                        </thead>
                        <?php
                              $amount = 0;
                             $total = 0;
                        ?>
                        @foreach($orders as $order)
                        <tr class="tr-row">
                            <td>{{ $order->Invoice_id }}</td>
                            <td>{{ $order->Date }}</td>
                            <td>{{ $order->Staff }}</td>
                            <td>{{ $order->Quantity}}</td>
                            <td class="money-align">{{ number_format($order->Amount)}}</td>
                        </tr>
                        <?php $total +=  $order->Amount; ?>
                        @endforeach
                        <tr>
                            <td colspan="3"></td>
                            <td class="money-align">Total Price</td>
                            <td class="money-align">{{number_format($total)}}</td>
                        </tr>
                    </table>
                </div>

            </div>
        </div>
    </div>
@endsection

