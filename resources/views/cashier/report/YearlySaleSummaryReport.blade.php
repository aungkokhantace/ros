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
                                    <input  type="text" class="form-control" id="summary_year" name="date" value= "2016">
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
                                <a href='/Cashier/searchYearlySummaryExport/'.$year   >
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
                            <th>View Detail</th>
                        </tr>
                        </thead>
                        <?php $sum=0;?>
                        @foreach($orders as $order)
                            <tr class="tr-row active">
                                <td>{{ $order->Year }}</td>
                                
                                <td class="money-align">{{ number_format($order->Amount) }}</td>
                                <td>
                                    <a href="{{'/Cashier/yearlySale/'.$order->Year}}">View Detail</a>
                                </td>
                                <?php $sum += $order->Amount;?>
                            </tr>
                        @endforeach
                        <tr class="active">
                            <td class="money-align" colspan="1">
                                Total Amount
                            </td>
                            <td class="money-align">{{number_format($sum)}}</td>
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

