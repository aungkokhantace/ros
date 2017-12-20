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
                        @if(isset($y))
                            <a href="{{ '/Cashier/yearlySaleExport/'.$y }}"  >
                                <button class="btn btn-success btn_export">Export</button>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            <br/>
            <div class="row" id="autoDiv">
                <div class="col-md-12 ">
                    <table class="table table-bordered">
                        <thead class="thead_report">
                        <tr class="report-th">
                            <th>Invoice ID</th>
                            <th>Date</th>
                            <th>Staff</th>
                            <th>Quantity</th>
                            <th>Amount</th>
                            <th>Payment</th>
                            <th>Extra</th>
                            <th>Refund</th>
                            <th>Service</th>
                            <th>Tax</th>
                            <th>Room Charge</th>
                            <th>Foc</th>
                            <th>Discount</th>
                        </tr>
                        </thead>
                        <?php
                            $amount = 0;
                            $total = 0;
                            $total_payment = 0;
                            $total_extra = 0;
                            $total_refund = 0;
                            $total_service = 0;
                            $total_tax = 0;
                            $total_room = 0;
                            $total_foc = 0;
                            $total_discount = 0;
                        ?>
                        @foreach($orders as $order)
                        <tr class="tr-row">
                            <td>{{ $order->Invoice_id }}</td>
                            <td>{{ $order->Date }}</td>
                            <td>{{ $order->Staff }}</td>
                            <td>{{ $order->Quantity}}</td>
                            <td class="money-align">{{ number_format($order->Amount)}}</td>
                            <td class="money-align">{{ number_format($order->PayAmount)}}</td>
                            <td class="money-align">{{ number_format($order->Extra)}}</td>
                            <td class="money-align">{{ number_format($order->RefundAmount)}}</td>
                            <td class="money-align">{{ number_format($order->ServiceAmount)}}</td>
                            <td class="money-align">{{ number_format($order->TaxAmount)}}</td>
                            <td class="money-align">{{ number_format($order->RoomCharge)}}</td>
                            <td class="money-align">{{ number_format($order->FocAmount)}}</td>
                            <td class="money-align">{{ number_format($order->DiscountAmount)}}</td>
                        </tr>
                        <?php 
                        $total +=  $order->Amount; 
                        $total_payment  += $order->PayAmount;
                        $total_refund   += $order->RefundAmount;
                        $total_extra    += $order->Extra;
                        $total_service  += $order->ServiceAmount;
                        $total_tax      += $order->TaxAmount;
                        $total_room     += $order->RoomCharge;
                        $total_foc      += $order->FocAmount;
                        $total_discount += $order->DiscountAmount;
                        ?>
                        @endforeach
                        <tr>
                            <td colspan="3"></td>
                            <td class="money-align">Total Price</td>
                            <td class="money-align">{{number_format($total)}}</td>
                            <td class="money-align">{{number_format($total_payment)}}</td>
                            <td class="money-align">{{number_format($total_extra)}}</td>
                            <td class="money-align">{{number_format($total_refund)}}</td>
                            <td class="money-align">{{number_format($total_service)}}</td>
                            <td class="money-align">{{number_format($total_tax)}}</td>
                            <td class="money-align">{{number_format($total_room)}}</td>
                            <td class="money-align">{{number_format($total_foc)}}</td>
                            <td class="money-align">{{number_format($total_discount)}}</td>
                        </tr>
                    </table>
                </div>

            </div>
        </div>
    </div>
@endsection

