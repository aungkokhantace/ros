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
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-bordered dailytable" style ="padding: 15px;margin-left: 13px;">
                            <thead class="thead_report">
                            <tr class="report-th">
                                <th>Day</th>
                                <th>Month</th>
                                <th>Total Extra Price</th>
                                <th>Total Discount Amount</th>
                                <th>Total Price</th>
                                <th>Total Room Charge</th>
                                <th>Total Service Amount</th>
                                <th>Total Tax Amount</th>
                                <th>Total FOC Amount</th>
                                <th>Total All Amount</th>
                                <th>Total Payment Amount</th>
                                <th>View Detail</th>
                            </tr>
                            </thead>
                            <?php 
                            $sum_amount=0;
                            $sum_extra=0;
                            $sum_price=0;
                            $sum_room=0;
                            $sum_payment=0;
                            $sum_service=0;
                            $sum_tax=0;
                            $sum_discount=0;
                            $sum_foc=0;
                            ?>
                            @foreach($orders as $order)
                                <tr class="tr-row active">
                                    <td width="10%">{{ $order->Day }}</td>
                                    <td>{{ date("F", mktime(0, 0, 0, $order->Month, 10)) }}</td>
                                    <td class="money-align">{{ number_format($order->ExtraAmount) }}</td>
                                    <td class="money-align">{{ number_format($order->DiscountAmount) }}</td>
                                    <td class="money-align">{{ number_format($order->PriceAmount) }}</td>
                                    <td class="money-align">{{ number_format($order->RoomAmount) }}</td>
                                    <td class="money-align">{{ number_format($order->ServiceAmount) }}</td>
                                    <td class="money-align">{{ number_format($order->TaxAmount) }}</td>
                                    <td class="money-align">{{ number_format($order->FocAmount) }}</td>
                                    <td class="money-align">{{ number_format($order->Amount) }}</td>
                                    <td class="money-align">{{ number_format($order->PayAmount) }}</td>
                                    <td>
                                        <a href="{{'/Cashier/dailysale/'.$order->Day.'/'.$order->Month}}">View Detail</a>
                                    </td>
                                    <?php 
                                    $sum_amount     += $order->Amount;
                                    $sum_extra      += $order->ExtraAmount;
                                    $sum_price      += $order->PriceAmount;
                                    $sum_room       += $order->RoomAmount;
                                    $sum_payment    += $order->PayAmount;
                                    $sum_service    += $order->ServiceAmount;
                                    $sum_tax        += $order->TaxAmount;
                                    $sum_discount   += $order->DiscountAmount;
                                    $sum_foc        += $order->FocAmount;
                                    ?>
                                </tr>
                            @endforeach
                            <tr class="active">
                                <td class="money-align" colspan="2">
                                    Total Amount
                                </td>
                                <td class="money-align">{{number_format($sum_extra)}}</td>
                                <td class="money-align">{{number_format($sum_discount)}}</td>
                                <td class="money-align">{{number_format($sum_price)}}</td>
                                <td class="money-align">{{number_format($sum_room)}}</td>
                                <td class="money-align">{{number_format($sum_service)}}</td>
                                <td class="money-align">{{number_format($sum_tax)}}</td>
                                <td class="money-align">{{number_format($sum_foc)}}</td>
                                <td class="money-align">{{number_format($sum_payment)}}</td>
                                <td class="money-align">{{number_format($sum_amount)}}</td>
                                <td></td>
                            </tr>
                        </table>
                    </div>
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

