@extends('cashier.layouts.master')
@section('title','Sale Summary Report')
@section('content')
    {{--title--}}
    <div class="container">
        {{--Order Listing Table--}}
        <div class="container">
            <div class="row">
                <div class="col-md-11">
                    <div class="col-md-12">
                        <h3 class="h3 report_heading"><strong>Sale Summary Report</strong></h3>
                    </div>
                    <div class="col-md-12">
                        <form id="sale_summary">
                            <div class="col-md-2 radio_view">
                                <input type="radio" name="sale" value="daily" > Daily
                            </div>
                            <div class="col-md-2 radio_view">
                                <input type="radio" name="sale" value="monthly" > Monthly
                            </div>
                            <div class="col-md-2 radio_view">
                                <input type="radio" name="sale" value="yearly" checked> Yearly
                            </div>
                        
                        </form>
                    </div>
                    <div class="col-md-12">
                        {!! Form::open(array('url' => 'Cashier/searchYearlySummary', 'class'=> 'form-horizontal user-form-border')) !!}
                        <div class="col-md-4" >
                            
                            @if(isset($year))

                                <div class="input-group">
                                    <input  type="text" class="form-control" id="summary_year" name="date" placeholder="Choose Year" value="{{$year}}">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                </div>
                            @else

                                <div class="input-group">
                                    <input  type="text" class="form-control" id="summary_year" name="date" value= "">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="col-md-1">
                            <input type="submit" value="Search" class="btn_submit"/>
                        </div>
                        {!! Form::close() !!}
                        <div class="col-md-1 ">
                            @if(isset($year))
                                <a href="{{'/Cashier/searchYearlySummaryExport/'.$year}}"   >
                                <button class="btn btn-success btn_export">Export</button>
                                </a>
                            @else
                                <a href='/Cashier/yearlySaleSummaryExport'>
                                <button class="btn btn-success btn_export">Export</button>
                                </a>
                            @endif
                            
                            
                        </div>
                    </div>
                </div>
            </div>
            <br/>
            <div class="row" id="autoDiv">
                <div class="col-md-11">
                    <table class="table table-bordered dailytable">
                        <thead class="thead_report">
                        <tr class="report-th">
                            <th>Year</th>
                            <th>Total Amount</th>
                            <th>Total Payment Amount</th>
                            <th>Total Refund Amount</th>
                            <th>Total Service Amount</th>
                            <th>Total Tax Amount</th>
                            <th>Total Discount Amount</th>
                            <th>Total FOC Amount</th>
                            <th>View Detail</th>
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
                                <td>{{ $order->Year }}</td>
                                
                                <td class="money-align">{{ number_format($order->Amount) }}</td>
                                <td class="money-align">{{ number_format($order->PayAmount) }}</td>
                                <td class="money-align">{{ number_format($order->RefundAmount) }}</td>
                                <td class="money-align">{{ number_format($order->ServiceAmount) }}</td>
                                <td class="money-align">{{ number_format($order->TaxAmount) }}</td>
                                <td class="money-align">{{ number_format($order->DiscountAmount) }}</td>
                                <td class="money-align">{{ number_format($order->FocAmount) }}</td>
                                <td>
                                    <a href="{{'/Cashier/yearlySale/'.$order->Year}}">View Detail</a>
                                </td>
                                <?php 
                                $sum_amount     += $order->Amount;
                                $sum_payment    += $order->PayAmount;
                                $sum_refund     += $order->RefundAmount;
                                $sum_service    += $order->ServiceAmount;
                                $sum_tax        += $order->TaxAmount;
                                $sum_discount   += $order->DiscountAmount;
                                $sum_foc        += $order->FocAmount;
                                ?>
                            </tr>
                        @endforeach
                        <tr class="active">
                            <td class="money-align" colspan="1">
                                Total Amount
                            </td>
                            <td class="money-align">{{number_format($sum_amount)}}</td>
                            <td class="money-align">{{number_format($sum_payment)}}</td>
                            <td class="money-align">{{number_format($sum_refund)}}</td>
                            <td class="money-align">{{number_format($sum_service)}}</td>
                            <td class="money-align">{{number_format($sum_tax)}}</td>
                            <td class="money-align">{{number_format($sum_discount)}}</td>
                            <td class="money-align">{{number_format($sum_foc)}}</td>
                            <td></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function(){
            $('.input-group-addon').click(function(){
                $('.datepicker-days' ).css( "display", "none" );
                $('.datepicker-years').css('display','block');
            });
        });
    </script>
@endsection

