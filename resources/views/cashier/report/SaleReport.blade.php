@extends('cashier.layouts.master')
@section('title','Sale Report')
@section('content')
    {{--title--}}
    <div class="container">
        {{--Order Listing Table--}}
        <div class="container">
            <div class="row">
                <div class="col-md-11">
                    <div class="col-md-12">
                        <h3 class="h3 report_heading"><strong>Sale Report</strong></h3>
                    </div>
                    <div class="col-md-12">
                        {!! Form::open(array('url' => 'Cashier/search_report', 'class'=> 'form-horizontal user-form-border')) !!}
                        <div class="col-md-3">

                            <!-- <input type="text" name="from" placeholder="From" class="form-control pull-right" id="datepicker" readonly value="{{isset($from)? date("d-m-Y",strtotime($from)) :""}}"> -->

                            <div class="input-group">
                                <input  type="text" class="form-control" id="from" name="from" placeholder="Choose Start Date" value= "{{isset($start_date)? date("d-m-Y",strtotime($start_date)):""}}">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">

                            <!-- <input type="text" name="to" placeholder="To" class="form-control pull-right" id="datepicker1" readonly value="{{isset($to)? date("d-m-Y",strtotime($to)) :""}}"> -->

                            <div class="input-group">
                                <input  type="text" class="form-control" id="to" name="to" placeholder="Choose End Date" value= "{{isset($start_date)? date("d-m-Y",strtotime($end_date)):""}}">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <input type="submit" value="Search" class="btn_submit"/>
                        </div>
                        {!! Form::close() !!}
                        <div class="col-md-1 ">
                            @if(isset($from))
                                <a href="{{'/Cashier/SaleExportDetail/' . $from. '/'.$to }} "  >
                                    <button class="btn btn-success btn_export" >Export</button>
                                </a>
                            @else
                                <a href="{{ '/Cashier/SaleExport/'}}"  >

                                    <button class="btn btn-success btn_export">Export</button>

                                </a>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
            <br/>
            <div class="row" id="autoDiv">
                <div class="col-md-12">
                    <table class="table table-bordered">
                        <thead class="thead_report">
                            <tr class="report-th">
                                <th width="10%">Invoice ID</th>
                                <th>Date</th>
                                <th>Cashier</th>
                                <th>Quantity</th>
                                <th>Total Amount</th>
                                <th>Total Payment Amount</th>
                                <th>Total Refund Amount</th>
                                <th>Total Service Amount</th>
                                <th>Total Tax Amount</th>
                                <th>Total Discount Amount</th>
                                <th>Total FOC Amount</th>
                            </tr>
                        </thead>

                        <?php 
                        $sum_amount=0;
                        $sum_payment=0;
                        $sum_refund=0;
                        $sum_service=0;
                        $sum_tax=0;
                        $sum_discount=0;
                        $sum_foc=0; 
                        ?>
                        @foreach($orders as $order)
                            <tr class="tr-row active">
                                <td>{{ $order->invoice_id }}</td>
                                <td>{{ date('d-m-Y',strtotime($order->order_time)) }}</td>
                                <td>{{ $order->user_name }}</td>
                                <td>{{ $order->Quantity }}</td>
                                <td class="money-align">{{ number_format($order->Amount) }}</td>
                                <td class="money-align">{{ number_format($order->Payment) }}</td>
                                <td class="money-align">{{ number_format($order->Refund) }}</td>
                                <td class="money-align">{{ number_format($order->Service) }}</td>
                                <td class="money-align">{{ number_format($order->Tax) }}</td>
                                <td class="money-align">{{ number_format($order->Discount) }}</td>
                                <td class="money-align">{{ number_format($order->Foc) }}</td>
                            </tr>
                            <?php 
                            $sum_amount     += $order->Amount;
                            $sum_payment    += $order->Payment;
                            $sum_refund     += $order->Refund;
                            $sum_service    += $order->Service;
                            $sum_tax        += $order->Tax;
                            $sum_discount   += $order->Discount;
                            $sum_foc        += $order->Foc; 
                            ?>
                        @endforeach
                        <tr class="active">
                            <td colspan="3"></td>
                            <td class="money-align">Total</td>
                            <td class="money-align">{{number_format($sum_amount)}}</td>
                            <td class="money-align">{{number_format($sum_payment)}}</td>
                            <td class="money-align">{{number_format($sum_refund)}}</td>
                            <td class="money-align">{{number_format($sum_service)}}</td>
                            <td class="money-align">{{number_format($sum_tax)}}</td>
                            <td class="money-align">{{number_format($sum_discount)}}</td>
                            <td class="money-align">{{number_format($sum_foc)}}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

