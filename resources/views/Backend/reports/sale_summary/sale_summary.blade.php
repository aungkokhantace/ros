@extends('Backend.layouts.master')
@section('title','Sale Summary Report')
@section('content')
    {{--title--}}
    <div class="content-wrapper">
      <div class="box">
       <div class="box-header">
    
        {{--Order Listing Table--}}
       
            <div class="row">
                <div class="col-md-11">
                    <div class="col-md-12">
                        <h3 class="h3 report_heading"><strong>Sale Summary Report</strong></h3>
                    </div>
                </div>
            </div>
                    <div class="container">
                    <div class="col-md-12" style="margin-bottom:25px">
                        <form id="sale_summary">
                            <div class="col-md-2 radio_view">
                                  @if(isset($type) && $type == "Daily")
                                    <input type="radio" name="sale" value="Daily" id="type" checked> Daily
                                  @else
                                   <input type="radio" name="sale" value="Daily" id="type" > Daily
                                  @endif

                            </div>
                            <div class="col-md-2 radio_view">
                                  @if(isset($type) && $type == "Monthly")
                                    <input type="radio" name="sale" value="Monthly" id="type" checked > Monthly
                                  @else
                                    <input type="radio" name="sale" value="Monthly" id="type"> Monthly
                                  @endif
                            </div>
                            <div class="col-md-2 radio_view">
                                @if(isset($type) && $type == "Yearly")
                                    <input type="radio" name="sale" value="Yearly" id="type" checked> Yearly
                                  @else
                                <input type="radio" name="sale" value="Yearly" id="type"> Yearly
                                  @endif
                            </div>
                        
                        </form>
                    </div>
                  </div>

                     {{--Start Datepicker--}}
    <div class="row days" style="display:none;">
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <label for="from_date" class="text_bold_black">From Date</label>
        </div>

        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <div class="input-group date dateTimePicker" data-provide="datepicker" id="datepicker_from">
                <input type="text" class="form-control" id="from_date" name="from_date" value="{{isset($from_date)?date('d-m-Y',strtotime($from_date)):''}}" readonly="">
                <div class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </div>
            </div>
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>

        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <label for="to_date" class="text_bold_black">To Date</label>
        </div>

        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <div class="input-group date dateTimePicker" data-provide="datepicker"  id="datepicker_to">
                <input type="text" class="form-control" id="to_date" name="to_date" value="{{isset($to_date)?date('d-m-Y',strtotime($to_date)):''}}" readonly="">
                <div class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </div>
            </div>
        </div>
    </div>
    {{--End Datepicker--}}
    <br class="days">

    {{--Start Monthpicker--}}
    <div class="row months" style="display:none;">
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <label for="from_month" class="text_bold_black">From Month</label>
        </div>

        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <div class="input-group date dateTimePicker" data-provide="datepicker" id="monthpicker_from">
                <input type="text" class="form-control" id="from_month"  name="from_month" value="{{isset($from_month) && $from_month != null ?$from_month:''}}"  readonly="" >
                <div class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </div>
            </div>
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>

        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <label for="to_month" class="text_bold_black">To Month</label>
        </div>

        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <div class="input-group date dateTimePicker" data-provide="datepicker"  id="monthpicker_to">
                <input type="text" class="form-control" id="to_month" name="to_month" value="{{isset($to_month)?$to_month:''}}" readonly="" >
                <div class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </div>
            </div>
        </div>
    </div>
    {{--End Monthpicker--}}
    <br class="months">

    {{--Start Yearpicker--}}
    <div class="row years" style="display:none;">
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <label for="from_year" class="text_bold_black">Year</label>
        </div>

        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <div class="input-group date dateTimePicker" data-provide="datepicker" id="yearpicker_from">
                <input type="text" class="form-control" id="from_year" name="from_year" value="{{isset($from_year)?$from_year:''}}" readonly>
                <div class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </div>
            </div>
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>

       {{-- <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <label for="to_year" class="text_bold_black">To Year</label>
        </div>

        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <div class="input-group date dateTimePicker" data-provide="datepicker"  id="yearpicker_to">
                <input type="text" class="form-control" id="to_year" name="to_year" value="{{isset($to_year)?$to_year:''}}">
                <div class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </div>  
            </div>
        </div>
        --}}
    </div>
    <br>
    {{--End Yearpicker--}}  
    <div class="row">
          <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">          
          </div>

          <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <button type="button" onclick="report_search_with_type('sale_SummaryReport');" class="form-control btn-primary">Preview By List</button>
        </div>

        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">          
        </div> 
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <button type="button" onclick="report_export_with_type('sale_SummaryReport');" class="form-control btn-primary">Export Excel</button>
        </div>  
    </div>
             
                 
        {!! Form::close() !!}
                   
        <br/><br/>
            </div>
            <br/>
        </div>
    
             <div class="container">
            <div class="row" id="autoDiv">
                <div class="col-md-12">
                    <div class="table-responsive table-hover">
                        <table class="table table-bordered dailytable" style ="padding: 15px;margin-left: 13px;">
                            <thead class="thead_report">                        
                            <tr class="report-th">
                                @if($type == "Yearly")
                                <th>Year</th>
                                @endif
                                @if($type == "Monthly")
                                <th>Month</th>
                                @endif
                                @if($type == "Daily")
                                <th>Day</th>
                                @endif
                               <!--  <th>Date</th>                                
                                <th>Order Time</th>  -->                          
                              
                                <th>Total Discount Amount</th>
                                <th>Total Tax Amount</th>
                                <th>Total Service Amount</th>                              
                                <th>Total Room Charge</th>
                                <th>Total Extra Price</th>
                                <th>Sub Total</th>
                                <th>Total Net Amountt</th>
                                <th>Total All Amount</th>
                                <th>View Detail</th>
                            </tr>
                            </thead>
                            <?php 
                            $sum_discount   = 0;
                            $sum_tax        = 0;
                            $sum_service    = 0;
                            $sum_room       = 0;
                            $sum_extra      = 0;
                            $sum_subtotal   = 0;
                            $sum_net        = 0;
                            $sum_amount     = 0;
                            // $date = date_create('2000-01-01');
                          
                            ?>
                              @if(isset($orders))
                                @foreach($orders as $order)
                                <tr class="tr-row active">
                                @if($type == "Yearly")
                                      <td width="10%">{{date('Y',strtotime($order->ShiftDate))}}</td>
                                      @endif
                                      @if($type == "Monthly")
                                      <td width="10%">{{date('m-Y',strtotime($order->ShiftDate))}}</td>
                                      @endif
                                      @if($type == "Daily")
                                      <td width="10%">{{date('d-m-Y',strtotime($order->ShiftDate))}}</td>
                                @endif
                               
                                   {{-- <td width="10%">{{date('d-m-Y',strtotime($order->Day))}}</td> --}}                             
                                  
                                    <td class="money-align">{{ number_format($order->DiscountAmount) }}</td>
                                    <td class="money-align">{{ number_format($order->TaxAmount) }}</td>
                                    <td class="money-align">{{ number_format($order->ServiceAmount) }}</td>                                  
                                    <td class="money-align">{{ number_format($order->RoomAmount) }}</td>
                                    <td class="money-align">{{ number_format($order->ExtraAmount) }}</td>
                                    <td class="money-align">{{ number_format($order->SubTotal) }}</td>
                                    <td class="money-align">{{ number_format($order->NetAmount) }}</td>
                                    <td class="money-align">{{ number_format($order->TotalAmount) }}</td>
                                 
                                    @if($type == "Yearly")
                                     <td> <a href="{{'/Backend/sale_SummaryReport/detail/'.date('Y',strtotime($order->ShiftDate)).'/'.$type.'/'.$from_year}}">View Detail</a></td>
                                    @endif

                                    @if($type == "Monthly")
                                       <td><a href="{{'/Backend/sale_SummaryReport/detail/'.date('Y-m',strtotime($order->ShiftDate)).'/'.$type .'/'.$from_month.'/'.$to_month}}">View Detail</a></td>
                                    @endif
                                      
                                    @if($type == "Daily")
                                      <td><a href="{{'/Backend/sale_SummaryReport/detail/'.date('Y-m-d',strtotime($order->ShiftDate)).'/'.$type.'/'.$from_date.'/'.$to_date}}">View Detail</a></td>
                                    @endif
                                    
                                    <?php 
                                    $sum_discount   += $order->DiscountAmount;
                                    $sum_tax        += $order->TaxAmount;
                                    $sum_service    += $order->ServiceAmount;
                                    $sum_room       += $order->RoomAmount;
                                    $sum_extra      += $order->ExtraAmount;
                                    $sum_subtotal   += $order->SubTotal;
                                    $sum_net        += $order->NetAmount;
                                    $sum_amount     += $order->TotalAmount;                                   
                                    ?>
                                </tr>
                            @endforeach
                              @endif
                          
                           
                            <tr class="active">

                                <td  class="money-align">
                                    Total Amount
                                </td>
                               <td class="money-align">{{number_format($sum_discount)}}</td>
                                <td class="money-align">{{number_format($sum_tax)}}</td>
                                <td class="money-align">{{number_format($sum_service)}}</td>

                                <td class="money-align">{{number_format($sum_room)}}</td>
                                <td class="money-align">{{number_format($sum_extra)}}</td>
                                <td class="money-align">{{number_format($sum_subtotal)}}</td>
                                <td class="money-align">{{number_format($sum_net)}}</td>
                                <td class="money-align">{{number_format($sum_amount)}}</td>
                                <td></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

    <script type="text/javascript">
        $(document).ready(function(){
            $('.input-group-addon').click(function(){
                console.log("ewfwe..");
                $('.datepicker-days' ).css( "display", "none" );
                $('.datepicker-years').css('display','block');
            });

             //Start Daypickers
            $('#datepicker_from').datepicker({
                format: 'dd-mm-yyyy',
                autoclose: true,
                defaultDate: "+1w",
                changeMonth: true,
                numberOfMonths: 1,
                allowInputToggle: true
            });

            $('#datepicker_to').datepicker({
                format: 'dd-mm-yyyy',
                autoclose: true,
                defaultDate: "+1w",
                changeMonth: true,
                numberOfMonths: 1,
                allowInputToggle: true,
                minDate: "20-08-2016"
            });
            //End Daypickers

            //Start Monthpickers
            $('#monthpicker_from').datepicker({
                format: 'mm-yyyy',
                viewMode: "months",
                minViewMode: "months",
                allowInputToggle: true,
                autoclose: true
            });

            $('#monthpicker_to').datepicker({
                format: "mm-yyyy",
                viewMode: "months",
                minViewMode: "months",
                allowInputToggle: true,
                autoclose: true
            });
            //End Monthpickers

            //Start Yearpickers
            $('#yearpicker_from').datepicker({
                format: "yyyy",
                viewMode: "years",
                minViewMode: "years",
                allowInputToggle: true,
                autoclose: true
            });

            $('#yearpicker_to').datepicker({
                format: "yyyy",
                viewMode: "years",
                minViewMode: "years",
                allowInputToggle: true,
                autoclose: true
            });
            //End Yearpickers
            $('#sale_summary input[type=radio][name="sale"]').on('change', function() {
                console.log("onchnage");           
           if($('input[name="sale"]:checked', '#sale_summary').val()=="Yearly"){
                console.log("Yearly");
                $('.days').hide();
                $('.months').hide();
                $('.years').show();
            }
            else if($('input[name="sale"]:checked', '#sale_summary').val()=="Monthly"){
                console.log("monthly")
                $('.days').hide();
                $('.months').show();
                $('.years').hide();
            }
            else{
                console.log('day');
                $('.days').show();
                $('.months').hide();
                $('.years').hide();
            }

            });

            var currentType = $('input[name="sale"]:checked', '#sale_summary').val();
            console.log(currentType + 'editiweofk');
            if(currentType == "Yearly"){
                $('.days').hide();
                $('.months').hide();
                $('.years').show();
            }
            else if(currentType == "Monthly"){
                $('.days').hide();
                $('.months').show();
                $('.years').hide();
            }
            else{
                $('.days').show();
                $('.months').hide();
                $('.years').hide();
            }

        });


// daily
// monthly
// yearly

    </script>
@endsection

