
@extends('Backend.layouts.master')
@section('title','Sale Report Summary')
@section('content')
    {{--title--}}
<div class="content-wrapper">
<div class="box">
<div class="box-header">
        {{--Order Listing Table--}}
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-3">
                        <h3 class="h3 report_heading"><strong>{{$type}} Sale Report Detail</strong></h3>
                    </div>                  
                </div>
            </div>
            <br/>
        </div>

        <div class="col-md-9">
        <div class="col-md-12" style="padding:0;float:right;">
            <div class="input-group" style="float:left;">
                <!-- <select id="invoice-form" style="width:400px" class="form-control" onchange="sortingOrder()"> -->
                  <select id="invoice-form" style="width:400px" class="form-control" name="sort">                              
                        <option value="date_asc"  @if(isset($sort) && $sort== 'date_asc') {{'selected'}} @endif>Sort By Invoice Date Ascending </option>
                        <option value="date_desc" @if(isset($sort) && $sort == 'date_desc') {{'selected'}} @endif>Sort By Invoice Date Descending </option>
                        <option value="amount_asc" @if(isset($sort) && $sort == 'amount_asc') {{'selected'}} @endif >Sort By Total Amount Ascending</option>
                        <option value="amount_desc" @if(isset($sort) && $sort == 'amount_desc') {{'selected'}} @endif >Sort By Total Amount Descending </option>
                
                </select>
            </div>              

        </div>

       {{-- <input type="text" name="date"  value="{{isset($date)?date('d-m-Y',strtotime($from_date)):''}}"> --}}
         <input type="hidden" name="date"  id="date" value="{{isset($date)?$date:''}}">
         <input type="hidden" name="type" id="type" value="{{isset($type)?$type:''}}">
        <br><br><br>    
    </div>

    <div class="row">        
        <div class="col-md-12" style="padding:0;float:right;">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <button type="button" onclick="report_search_with_sort('sale_SummaryReport');" class="form-control btn-primary">Preview By List</button>
        </div> 

        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <button type="button" onclick="report_export_with_sort('sale_SummaryReport');" class="form-control btn-primary">Export Excel</button>
        </div> 
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <?php 
            // use App\Session;
            // $temp_fmonth    = session()->get('from_month');
            // $temp_tmonth    = session()->get('to_month');
            // dd($temp_fmonth,$temp_tmonth);
            ?>
           <a href="/Backend/sale_SummaryReport"><button type="button"  class="form-control btn-primary">Back</button></a> 
           <?php  
           // session()->forget('from_month');
           // session()->forget('to_month');
            ?>
        </div>  
        </div>
    </div>
</div>
</div>
             <div class="container">
            <div class="row" id="autoDiv">
                <div class="col-md-12">
                    <div class="table-responsive table-hover">
                        <table class="table table-bordered Dailytable" style ="padding: 15px;margin-left: 13px;">
                    <table class="table table-bordered">
                        <thead class="thead_report">
                        <tr class="report-th">
                            <th width="12%">Invoice ID</th>
                            <th>Shift Date</th>
                            <th>Order Time</th>
                            <th>Staff</th>
                            <th>Discount</th>
                            <th>Tax</th>
                            <th>Service</th>
                            <th>Room Charge</th>
                            <th>Extra</th>
                            <th>Quantity</th>                        
                            <th>Sub Total</th>
                            <th>Net Amount</th>
                            <th>Total Amount</th>
                            <th>View Detail</th>
                        </tr>
                        </thead>
                        <?php
                            $sum_discount   = 0;
                            $sum_tax        = 0;
                            $sum_service    = 0;
                            $sum_room       = 0;
                            $sum_extra      = 0;
                            $sum_qty        = 0;
                            $sum_subtotal   = 0;
                            $sum_net        = 0;
                            $sum_amount     = 0;
                        ?>
                        @foreach($orders as $order)
                        <tr class="tr-row">
                            <td>{{ $order->invoice_id }}</td>
                          @if($type == "Yearly")
                                  <td width="10%">{{date('Y',strtotime($date.'-01-01'))}}</td>
                                  @endif
                                  @if($type == "Monthly")
                                  <td width="10%">{{date('m-Y',strtotime($date.'-01'))}}</td>
                                  @endif
                                  @if($type == "Daily")
                                  <td width="10%">{{date('d-m-Y',strtotime($date))}}</td>
                            @endif
                            <td class="money-align" width="10%">{{ $order->Date }}</td>
                            <td class="money-align">{{ $order->Staff }}</td>
                           
                            <td class="money-align">{{ number_format($order->Discount)}}</td>
                            <td class="money-align">{{ number_format($order->Tax)}}</td>
                            <td class="money-align">{{ number_format($order->Service)}}</td>
                            <td class="money-align">{{ number_format($order->Room)}}</td>
                            <td class="money-align">{{ number_format($order->Extra)}}</td>
                            <td class="money-align">{{ $order->Quantity}}</td>
                            <td class="money-align">{{ $order->SubTotal}}</td>                           
                            <td class="money-align">{{ $order->NetAmount}}</td>
                            <td class="money-align">{{ $order->Amount}}</td>                      
                           <td><a href="/Backend/sale_SummaryReport/invoice_detail/{{ $order->invoice_id }}/{{$date}}/{{$type}}">View</a></td>
                        </tr>
                          <?php 
                            $sum_discount   += $order->Discount;
                            $sum_tax        += $order->Tax;
                            $sum_service    += $order->Service;
                            $sum_room       += $order->Room;
                            $sum_extra      += $order->Extra;
                            $sum_qty        += $order->Quantity;
                            $sum_subtotal   += $order->SubTotal;
                            $sum_net        += $order->NetAmount;
                            $sum_amount     += $order->Amount;                                   
                        ?>
                        @endforeach
                        <tr>
                            <td colspan="3"></td>
                            <td class="money-align">All Total</td>
                            <td class="money-align">{{number_format($sum_discount)}}</td>
                            <td class="money-align">{{number_format($sum_tax)}}</td>
                            <td class="money-align">{{number_format($sum_service)}}</td>                           
                            <td class="money-align">{{number_format($sum_room)}}</td>
                            <td class="money-align">{{number_format($sum_extra)}}</td>
                            <td class="money-align">{{number_format($sum_qty)}}</td>
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
@endsection

