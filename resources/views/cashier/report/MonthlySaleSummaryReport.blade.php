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
                                <input type="radio" name="sale" value="monthly" checked> Monthly
                            </div>
                            <div class="col-md-2 radio_view">
                                <input type="radio" name="sale" value="yearly"> Yearly
                            </div>
                        
                        </form>
                    </div>
                    <div class="col-md-12">
                       
                        {!! Form::open(array('url' => 'Cashier/searchMonthlySummary' ,'method'=>'post', 'class'=> 'form-horizontal user-form-border')) !!}

                    <div class="col-md-3 month_pick">

                        <div class="input-group">
                            <input  type="text" class="form-control" id="monthpicker1" name="from_month" placeholder="Choose Start Month" value= "{{isset($from_month)? $from_month : ""}}">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 month_pick monthpick2">

                        <div class="input-group">
                            <input  type="text" class="form-control" id="monthpicker2" name="to_month" placeholder="Choose Start Month" value= "{{isset($to_month)? $to_month : ""}}">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                        </div>
                    </div>

                    
                    <div class="col-md-1 ">
                        <input type="submit" value="Search" class="btn_submit"/>
                    </div>
                    
                    {!! Form::close() !!}
                    <div class="col-md-1 ">
                        @if(isset($from_month))
                            <a href="{{'/Cashier/searchMonthlySummaryExport/' . $from_month. '/'.$to_month }} "  >
                                <button class="btn btn-success btn_export" >Export</button>
                            </a>
                        @else
                            <a href="{{ '/Cashier/monthlySaleSummaryExport'}}"  >
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
                            <th>Month</th>
                            <th>Total Amount</th>
                            <th>View Detail</th>
                        </tr>
                        </thead>
                        <?php $sum=0;?>
                        @foreach($orders as $order)
                            <tr class="tr-row active">
                                <td>{{ $order->Year }}</td>
                                <td>{{ date("F", mktime(0, 0, 0, $order->Month, 10)) }}</td>
                                <td class="money-align">{{ number_format($order->Amount) }}</td>
                                <td>
                                    <a href="{{'/Cashier/monthlySale/'.$order->Year.'/'.$order->Month}}">View Detail</a>
                                </td>
                                <?php $sum += $order->Amount;?>
                            </tr>
                        @endforeach
                        <tr class="active">
                            <td class="money-align" colspan="2">
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

