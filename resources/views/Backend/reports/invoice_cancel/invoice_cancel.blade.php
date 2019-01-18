@extends('Backend.layouts.master')
@section('title','Invoice Listing')
@section('content')
<style type="text/css">
    tfoot {
        display: table-header-group;
    }
</style>
 <div class="content-wrapper">
      <div class="box">
       <div class="box-header">
    <div class="row">
        <div class="container">
            @if(count(Session::get('message')) != 0)
                <div>
                </div>
            @endif
        </div>
    </div>

    
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-12"><h3 class="h3"><strong>Cancel Vocher Listing</strong></h3></div>

                        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <label for="from_date" class="text_bold_black">From Date</label>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
              <div class="input-group date dateTimePicker" data-provide="datepicker" id="datepicker_from">
                <input  type="text" class="form-control" id="from_date" name="from_date" placeholder="Choose Start Date" value= "{{isset($from_date)? date("d-m-Y",strtotime($from_date)):""}}" readonly="">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
            </div>
        </div> 


        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <label for="from_date" class="text_bold_black">To Date</label>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
         <div class="input-group date dateTimePicker" data-provide="datepicker"  id="datepicker_to">
            <input  type="text" class="form-control" id="to_date" name="to_date" placeholder="Choose Start Date" value= "{{isset($to_date)? date("d-m-Y",strtotime($to_date)):""}}" readonly="">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
            </div>
        </div>
         
                   
                   
        <div class="col-md-2 pull-right ">                    
            <button class="btn btn-primary " onclick="cancel_invoice_excel('cancel_report');">Export</button>                    
        </div>
         <div class="col-md-1 pull-right">          
        <button type="submit" class="btn btn-primary " onclick="cancel_invoice_search('cancel_report');">
            Search
        </button>
        </div>
        </div>
               
               
            </div>
        </div>
    </div>
    {{--tables--}}
  <div class="container">
        <div class="row" id="autoDiv">
            <div class="col-md-12">
                <table class="table table-bordered" id="cancel_invoice">
                     
                        <thead class="thead_report">
                        <tr class="report-th">
                            <th width="12%">Voucher No</th>                        
                          <!--   <th>Order Time</th> -->
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
                        @foreach($ordersCancel as $order)     
                            <td>{{ $order->invoice_id }}</td>               
                           
                            <td class="money-align">{{ $order->Staff }}</td>                           
                            <td class="money-align">{{ number_format($order->Discount)}}</td>
                            <td class="money-align">{{ number_format($order->Tax)}}</td>
                            <td class="money-align">{{ number_format($order->Service)}}</td>
                            <td class="money-align">{{ number_format($order->Room)}}</td>
                            <td class="money-align">{{ number_format($order->Extra)}}</td>
                            <td class="money-align">{{ number_format($order->Quantity)}}</td>
                            <td class="money-align">{{ number_format($order->SubTotal)}}</td>                           
                            <td class="money-align">{{ number_format($order->NetAmount)}}</td>
                            <td class="money-align">{{ number_format($order->Amount)}}</td>                      
                           <td><a href="{{'/Backend/invoice/cancel_report/detail/'.$order->invoice_id.'/'.$from_date.'/'.$to_date}}">View</a></td>
                      
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
                            <td ></td>                       
                           
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
<script type="text/javascript">
    $(document).ready(function() {
        // $('#cancel_invoice').DataTable( {
        //     "paging":   false,
        //     "ordering": false,
        //     "info":     false
        // } );//data table
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
} );
    
</script>


@endsection
