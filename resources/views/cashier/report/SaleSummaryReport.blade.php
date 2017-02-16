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
                                <input type="radio" name="sale" value="daily" checked> Daily
                            </div>
                            <div class="col-md-2 radio_view">
                                <input type="radio" name="sale" value="monthly"> Monthly
                            </div>
                            <div class="col-md-2 radio_view">
                                <input type="radio" name="sale" value="yearly"> Yearly
                            </div>
                        
                        </form>
                    </div>

                       
                    {!! Form::open(array('url' => 'Cashier/searchDailySummary' ,'method'=>'post', 'class'=> 'form-horizontal user-form-border')) !!}
                    

                    <div class="col-md-3" style="padding:0;">
                            {{--<div class="input-group date dateTimePicker" data-provide="datepicker">--}}
                                {{--<input  type="text" class="form-control" id="from" name="from_date" placeholder="Choose Start Date" value= "{{isset($from_date)? date("d-m-Y",strtotime($from_date)):""}}">--}}
                                {{--<div class="input-group-addon">--}}
                                    {{--<span class="glyphicon glyphicon-calendar"></span>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        <div class="input-group">
                            <input  type="text" class="form-control" id="from" name="from_date" placeholder="Choose Start Date" value= "{{isset($from_date)? date("d-m-Y",strtotime($from_date)):""}}">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                        </div>

                    </div>

                        <div class="col-md-3" style="padding:0;">
                            {{--<div class="input-group date dateTimePicker" data-provide="datepicker">--}}
                                {{--<input  type="text" class="form-control" id="to" name="to_date" placeholder="Choose End Date" value= "{{isset($to_date)? date("d-m-Y",strtotime($to_date)):""}}">--}}
                                {{--<div class="input-group-addon">--}}
                                    {{--<span class="glyphicon glyphicon-calendar"></span>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            <div class="input-group">
                                <input  type="text" class="form-control" id="to" name="to_date" placeholder="Choose End Date" value= "{{isset($to_date)? date("d-m-Y",strtotime($to_date)):""}}">
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
                        @if(isset($from_date))
                            <a href="{{'/Cashier/searchDailySummaryExport/' . $from_date. '/'.$to_date }} "  >
                                <button class="btn btn-success btn_export" >Export</button>
                            </a>
                        @else
                            <a href="{{ '/Cashier/SaleSummaryExport'}}"  >
                                <button class="btn btn-success btn_export">Export</button>
                            </a>
                        @endif
                    </div>
                    <br/><br/>
            </div>
            <br/>
            <div class="row" id="autoDiv">
                <div class="col-md-11">
                    <table class="table table-bordered dailytable" style ="padding: 15px;margin-left: 13px;">
                        <thead class="thead_report">
                        <tr class="report-th">
                            <th>Day</th>
                            <th>Month</th>
                            <th>Total Amount</th>
                            <th>View Detail</th>
                        </tr>
                        </thead>
                        <?php $sum=0;?>
                        @foreach($orders as $order)
                            <tr class="tr-row active">
                                <td>{{ $order->Day }}</td>
                                <td>{{ date("F", mktime(0, 0, 0, $order->Month, 10)) }}</td>
                                <td class="money-align">{{ number_format($order->Amount) }}</td>
                                <td>
                                    <a href="{{'/Cashier/dailysale/'.$order->Day.'/'.$order->Month}}">View Detail</a>
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

