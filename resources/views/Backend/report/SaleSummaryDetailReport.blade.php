@extends('Backend.layouts.master')
@section('title','Category Sale Summary Detail Report')
@section('content')
{{--title--}}
<div class="container">
    {{--Order Listing Table--}}
        <div class="container">
                <div class="row">
                    <div class="col-md-11">
                        <h3 class="h3 report_heading"><strong>Category Sale Summary Detail Report</strong></h3>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <form id="view_by_radio">
                        @if(isset($checked))
                            @if($checked == "daily")
                                <div class="col-md-2 radio_view">
                                    <input type="radio" name="view" value="daily" checked> Daily
                                </div>
                            @else
                                <div class="col-md-2 radio_view">
                                    <input type="radio" name="view" value="daily"> Daily
                                </div>
                            @endif

                            @if($checked == "monthly")
                                <div class="col-md-2 radio_view">
                                    <input type="radio" name="view" value="monthly" checked> Monthly
                                </div>
                            @else
                                <div class="col-md-2 radio_view">
                                    <input type="radio" name="view" value="monthly"> Monthly
                                </div>
                            @endif

                            @if($checked == "yearly")
                                <div class="col-md-2 radio_view">
                                    <input type="radio" name="view" value="yearly" checked> Yearly
                                </div>
                            @else
                                <div class="col-md-2 radio_view">
                                    <input type="radio" name="view" value="yearly"> Yearly
                                </div>
                            @endif

                        @else
                            <div class="col-md-2 radio_view">
                                <input type="radio" name="view" value="daily" checked> Daily
                            </div>
                            <div class="col-md-2 radio_view">
                                <input type="radio" name="view" value="monthly"> Monthly
                            </div>
                            <div class="col-md-2 radio_view">
                                <input type="radio" name="view" value="yearly"> Yearly
                            </div>
                        @endif

                        </form>
                    </div>
                </div>
                <br/>
                <div class="row daily">
                    <div class="col-md-12 date_btn_row">
                        {!! Form::open(array('url' => 'Cashier/saleSummaryDetailReportWithDate', 'method' => 'post', 'class'=> 'form-horizontal user-form-border')) !!}
                        <div class="col-md-3">

                            <div class="input-group">
                                <input  type="text" class="form-control" id="from" name="from" placeholder="Choose Start Date" value= "{{isset($start_date)? date("d-m-Y",strtotime($start_date)):""}}">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">

                            <div class="input-group">
                                <input  type="text" class="form-control" id="to" name="to" placeholder="Choose End Date" value= "{{isset($start_date)? date("d-m-Y",strtotime($end_date)):""}}">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <select class="form-control" name="child_category">
                                @foreach($category as $c)
                                    @if(isset($child))
                                        @if($c->id == $child)
                                            <option value="{{ $c->id }}" selected>{{$c->name}}</option>
                                        @else
                                            <option value="{{$c->id}}">{{$c->name}}</option>    
                                        @endif
                                    @else
                                        <option value="{{$c->id}}">{{$c->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-1">
                            <input type="submit" value="Search" class="btn_submit"/>

                        </div>
                       
                        {!! Form::close() !!}
                         <div class="col-md-1">
                            @if(isset($start_date))
                                <a href="{{'/Cashier/saleSummaryDailyDetailExportWithDate/' . $start_date. '/'.$end_date.'/'.$child }}">
                                    <button class="btn btn-success btn_export" >Export</button>
                                </a>
                            @else
                                <a href="{{ '/Cashier/saleSummaryDailyDetailExport/'}}">
                                    <button class="btn btn-success btn_export">Export</button>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>


            <div class="row monthly monthly_row">
                <div class="col-md-12 date_btn_row">

                    @if(isset($checked))
                        {!! Form::open(array('url' => 'Cashier/saleSummaryMonthlyDetailReportWithDate/'.$checked ,'method'=>'post', 'class'=> 'form-horizontal user-form-border')) !!}
                    @else
                        {!! Form::open(array('url' => 'Cashier/saleSummaryMonthlyDetailReportWithDate' ,'method'=>'post', 'class'=> 'form-horizontal user-form-border')) !!}
                    @endif

                    <div class="col-md-3 month_pick">

                        <div class="input-group">
                            <input  type="text" class="form-control" id="monthpicker1" name="from_month" placeholder="Choose Start Month" value= "{{isset($from_month_picked)? $from_month_picked : ""}}">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 month_pick monthpick2">

                        <div class="input-group">
                            <input  type="text" class="form-control" id="monthpicker2" name="to_month" placeholder="Choose End Month" value= "{{isset($to_month_picked)? $to_month_picked : ""}}">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <select class="form-control" name="child_category">
                            @foreach($category as $c)
                                @if(isset($child))
                                    @if($c->id == $child)
                                        <option value="{{ $c->id }}" selected>{{$c->name}}</option>
                                    @else
                                        <option value="{{$c->id}}">{{$c->name}}</option>    
                                    @endif
                                @else
                                    <option value="{{$c->id}}">{{$c->name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-1 ">
                        <input type="submit" value="Search" class="btn_submit"/>
                    </div>
                    
                    {!! Form::close() !!}
                    <div class="col-md-1 ">
                        @if(isset($from_month_picked))
                            <a href="{{'/Cashier/saleSummaryMonthlyDetailExportWithDate/' . $from_month_picked. '/'.$to_month_picked.'/'.$child }} "  >
                                <button class="btn btn-success btn_export" >Export</button>
                            </a>
                        @else
                            <a href="{{ '/Cashier/saleSummaryMonthlyDetailExport/'}}"  >
                                <button class="btn btn-success btn_export">Export</button>
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="row yearly">
                <div class="col-md-12 date_btn_row year_row">

                    @if(isset($checked))
                    {!! Form::open(array('url' => 'Cashier/saleSummaryYearlyDetailReportWithDate/'.$checked ,'method'=>'post', 'class'=> 'form-horizontal user-form-border')) !!}
                    @else
                    {!! Form::open(array('url' => 'Cashier/saleSummaryYearlyDetailReportWithDate' ,'method'=>'post', 'class'=> 'form-horizontal user-form-border')) !!}
                    @endif

                        <div class="col-md-3 ">
                           
                            @if(isset($year))
                                <div class="input-group">
                                    <input  type="text" class="form-control" id="summary_year" name="year_pick" placeholder="Choose Year" value="{{$year}}">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                </div>
                            @else
                                <div class="input-group">
                                    <input  type="text" class="form-control" id="summary_year" name="year_pick" placeholder="Choose Year" value="2016">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-3">
                        <select class="form-control" name="child_category">
                            @foreach($category as $c)
                                @if(isset($child))
                                    @if($c->id == $child)
                                        <option value="{{ $c->id }}" selected>{{$c->name}}</option>
                                    @else
                                        <option value="{{$c->id}}">{{$c->name}}</option>    
                                    @endif
                                @else
                                    <option value="{{$c->id}}">{{$c->name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                        <div class="col-md-1">
                            <input type="submit" value="Search" class="btn_submit"/>
                        </div>
                        
                    {!! Form::close() !!}
                        <div class="col-md-1">
                            @if(isset($year))
                                <a href="{{'/Cashier/saleSummaryYearlyDetailExportWithDate/' .$year.'/'.$child }} "  >
                                    <button class="btn btn-success btn_export" >Export</button>
                                </a>
                            @else
                                <a href="{{ '/Cashier/saleSummaryYearlyDetailExport/'}}"  >
                                    <button class="btn btn-success btn_export">Export</button>
                                </a>
                            @endif
                        </div>
                </div>
            </div>
        </div>
      <div class="row">
        <div class="table col-md-11">
            @if(isset($start))
                {{--The earliest start date and the latest end date from db--}}
                <strong>Showing results from {{( date("d-m-Y",strtotime($start->min )))}} to {{( date("d-m-Y",strtotime($end ->max )))}}</strong>
            @elseif(isset($start_date))
                {{--User-defined start date and end date (i.e. filtered by date)--}}
                <strong>Showing results from {{( date("d-m-Y",strtotime($start_date )))}} to {{( date("d-m-Y",strtotime($end_date)))}}</strong>
            @elseif(isset($from_month_picked))
                <strong>Showing results from {{$from_month_picked}} to {{$to_month_picked}}</strong>
            @elseif(isset($year))
                <strong>Showing results for {{$year}}</strong>
            @endif
        </div>
    </div>

    <div class="row daily" id="autoDiv">
        <div class="col-md-11">
            <table class="table table-bordered">
                <thead class="thead_report">
                <tr class="report-th">
                    <th>Date</th>
                    <th>Category</th>
                    <th>Amount</th>
                </tr>
                </thead>

                <?php $total = 0; ?>
                @foreach($orders as $order)
                    <tr class="tr-row active">
                        <td>{{date("d-m-Y", strtotime($order->date))}}</td>
                        <td>{{ $order->category_name }}</td>
                        <td class="money-align">{{ number_format($order->total) }}</td>
                    </tr>
                    <?php $total += $order->total; ?>
                @endforeach
                <tr class="active">
                    <td colspan="1"></td>
                    <td class="money-align">Total Amount</td>
                    <td class="money-align">{{number_format($total)}}</td>
                </tr>
            </table>
        </div>
    </div>

    <div class="row monthly" id="autoDiv">
        <div class="col-md-11">
            <table class="table table-bordered">
                <thead class="thead_report">
                <tr class="report-th">
                    <th>Month</th>
                    <th>Category</th>
                    <th>Amount</th>
                </tr>
                </thead>
                @if(isset($from_month_picked))
                    @foreach($orders as $order)
                        <tr class="tr-row active">
                            <td>{{$order->Month}}-{{$order->Year}}</td>
                            <td>{{ $order->CategoryName }}</td>
                            <td class="money-align">{{ number_format($order->TotalAmount) }}</td>
                        </tr>
                        <?php $total += $order->TotalAmount; ?>
                    @endforeach
                    <tr class="active">
                        <td colspan="1"></td>
                        <td class="money-align">Total Amount</td>
                        <td class="money-align">{{number_format($total)}}</td>
                    </tr>
                @else
                <?php $total = 0; ?>
                @foreach($orders as $order)
                    <tr class="tr-row active">
                        <td>{{date("m-Y", strtotime($order->date))}}</td>
                        <td>{{ $order->category_name }}</td>
                        <td class="money-align">{{ number_format($order->total) }}</td>
                    </tr>
                    <?php $total += $order->total; ?>
                @endforeach
                <tr class="active">
                    <td colspan="1"></td>
                    <td class="money-align">Total Amount</td>
                    <td class="money-align">{{number_format($total)}}</td>
                </tr>
                @endif
            </table>
        </div>
    </div>

    <div class="row yearly" id="autoDiv">
        <div class="col-md-11">
            <table class="table table-bordered">
                <thead class="thead_report">
                <tr class="report-th">
                    <th>Year</th>
                    <th>Category</th>
                    <th>Amount</th>
                </tr>
                </thead>

                <?php $total = 0; ?>
                @foreach($orders as $order)
                    <tr class="tr-row active">
                        <td>{{$order->year}}</td>
                        <td>{{ $order->category_name }}</td>
                        <td class="money-align">{{ number_format($order->total) }}</td>
                    </tr>
                    <?php $total += $order->total; ?>
                @endforeach
                <tr class="active">
                    <td colspan="1"></td>
                    <td class="money-align">
                        Total Amount
                    </td>
                    <td class="money-align">{{number_format($total)}}</td>
                </tr>
            </table>
        </div>
    </div>
</div>

@endsection

