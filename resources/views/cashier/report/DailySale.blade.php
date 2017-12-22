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
                    <div class="col-md-9 list-view">
                        @if(isset($m))
                            <a href="{{ '/Cashier/dailySaleExport/'.$d.'/'.$m }}"  >
                                <button class="btn btn-success btn_export">Export</button>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            <br/>
            <div class="row" id="autoDiv">
                <div class="col-md-12">
                    <table class="table table-bordered">
                        <thead class="thead_report">
                        <tr class="report-th">
                            <th>Invoice ID</th>
                            <th>Date</th>
                            <th>Staff</th>
                            <th>Quantity</th>
                            <th>Discount</th>
                            <th>Tax</th>
                            <th>Service</th>
                            <th>FOC</th>
                            <th>Room Charge</th>
                            <th>Extra</th>
                            <th>Price</th>
                            <th>View Detail</th>
                            <th>View Payment</th>
                        </tr>
                        </thead>
                        <?php
                            $amount     = 0;
                            $payment    = 0;
                            $refund     = 0;
                            $service    = 0;
                            $tax        = 0;
                            $discount   = 0;
                            $foc        = 0;
                            $total = 0;
                            $room       = 0;
                            $extra      = 0;
                        ?>
                        @foreach($orders as $order)
                        <tr class="tr-row">
                            <td>{{ $order->Invoice_id }}</td>
                            <td>{{ $order->Date }}</td>
                            <td>{{ $order->Staff }}</td>
                            <td>{{ $order->Quantity}}</td>
                            <td class="money-align">{{ number_format($order->Discount)}}</td>
                            <td class="money-align">{{ number_format($order->Tax)}}</td>
                            <td class="money-align">{{ number_format($order->Service)}}</td>
                            <td class="money-align">{{ number_format($order->Foc)}}</td>
                            <td class="money-align">{{ number_format($order->Room)}}</td>
                            <td class="money-align">{{ number_format($order->Extra)}}</td>
                            <td class="money-align">{{ number_format($order->Amount)}}</td>
                            
                            
                            
                            
                            <td><a href="/Cashier/invoice/detail/{{ $order->Invoice_id }}">View</a></td>
                            <td><a href="/Cashier/invoice/paid/{{ $order->Invoice_id }}">View</a></td>
                        </tr>
                        <?php 
                            $total      += $order->Amount;
                            $refund     += $order->Refund;  
                            $service    += $order->Service;
                            $tax        += $order->Tax;
                            $discount   += $order->Discount;
                            $foc        += $order->Foc;
                            $room       += $order->Room;
                            $extra      += $order->Extra;
                        ?>
                        @endforeach
                        <tr>
                            <td colspan="3"></td>
                            <td class="money-align">All Total</td>
                            <td class="money-align">{{number_format($discount)}}</td>
                            <td class="money-align">{{number_format($tax)}}</td>
                            <td class="money-align">{{number_format($service)}}</td>
                            <td class="money-align">{{number_format($foc)}}</td>
                            <td class="money-align">{{number_format($room)}}</td>
                            <td class="money-align">{{number_format($extra)}}</td>
                            <td class="money-align">{{number_format($total)}}</td>
                            <td></td>
                            <td></td>
                        </tr>
                    </table>
                </div>

            </div>
        </div>
    </div>
@endsection

