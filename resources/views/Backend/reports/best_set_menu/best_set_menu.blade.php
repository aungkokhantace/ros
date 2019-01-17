@extends('Backend.layouts.master')
@section('title','Best-selling Item Report')
@section('content')
<div class="content-wrapper">
      <div class="box">
       <div class="box-header">
    {{--title--}}
    
        {{--Order Listing Table--}}
        {{--From date, to date, and view report button--}}
        <div class="row date_button">
            <div class="col-md-11 date_row">
                <div class="col-md-12"><h3 class="h3"><strong>Best Selling Set Menu Report</strong></h3></div>
            <div class="col-md-12 btn-gp">
        <div class="row">
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
         

         <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <label for="from_date" class="text_bold_black">Top Item</label>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
           <div class="input-group">
            @if(isset($number))
                <input type="number" name="number" id="number" class="form-control" value="{{$number}}" min="1" step="1" placeholder="Enter Item Quantity">
            @else
                <input type="number" name="number" id="number" class="form-control" min="1" step="1" placeholder="Enter Item Quantity">
            @endif
            </div>
        </div>  
        <br><br>
        </div>
        <div class="row">
            
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <label for="from_date" class="text_bold_black">From Amount</label>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
           <div class="input-group">
            @if(isset($from_amount))
                <input type="text" name="from_amount" class="form-control" 
                value="{{$from_amount}}" id="from_amount">
                @else
                <input type="text" name="from_amount" class="form-control" placeholder="Start Amount" id="from_amount">
            @endif
             <div class="input-group-addon">
                    <i class="glyphicon glyphicon-usd"></i>
                </div>
            </div>
        </div> 


        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <label for="from_date" class="text_bold_black">To Amount </label>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
           <div class="input-group">
            @if(isset($to_amount))
                <input type="text" name="to_amount" class="form-control" id="to_amount"
                value="{{$to_amount}}">
                @else
                <input type="text" name="to_amount" class="form-control" placeholder="End Amount" id="to_amount">
            @endif
            <div class="input-group-addon">
                <i class="glyphicon glyphicon-usd"></i>
            </div>
            </div>
            
        </div>                        
                   
        <div class="col-md-2 pull-right ">                    
            <button class="btn btn-primary " onclick="best_set_export('Best_SetReport');">Export</button>                    
        </div>
         <div class="col-md-1 pull-right">          
        <button type="submit" class="btn btn-primary " onclick="best_set_search('Best_SetReport');">
            Search
        </button>
        </div>
        </div>
        
       

                </div>
            </div>
        </div>
        {{--From date, to date, and view report button--}}
       
    </div>
</div>
        {{--From date, to date, and view report button--}}
        <div class="container">
        <div class="row" id="autoDiv">
            <div class="col-md-12">
                <table class="table table-bordered">
                    <thead class="thead_report">
                    <tr class="report-th">
                        <th>Item Name</th>
                        <th>Quantity</th>                                      
                        <th>Total Amount</th>
                        <!-- <th>View</th> -->
                    </tr>
                    </thead>

                    <?php 
                    $sum_qty        = 0;
                    $item_price     = 0;
                    $sum_discount   = 0;                    
                    $sum            = 0;
                    ?>
                    @if(isset($orders))
                    @foreach($orders as $order)
                        <tr class="tr-row active">
                            <td>{{ $order->Name }}</td>
                            <td>{{ $order->Quantity }}</td>
                            <td>{{number_format($order->TotalAmount)}}</td>                           
                            
                            <?php 
                            $sum_qty += $order->Quantity;
                            $sum     += $order->TotalAmount;                           
                            ?>
                        </tr>
                    @endforeach
                    @endif
                    <tr class="active">
                        <!-- <td colspan="3"></td> -->

                        <td class="money-align">Total Amount</td>
                        <td class="money-align">{{number_format($sum_qty)}}</td>
                        <td class="money-align">{{number_format($sum)}}</td>
                        
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
</div>
<script type="text/javascript">
     $(document).ready(function(){
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
     });

// Integer (positive only)
  function setInputFilter(textbox, inputFilter) {
    ["input", "keydown", "keyup", "mousedown", "mouseup", "select", "contextmenu", "drop"].forEach(function(event) {
      textbox.addEventListener(event, function() {
        if (inputFilter(this.value)) {
          this.oldValue = this.value;
          this.oldSelectionStart = this.selectionStart;
          this.oldSelectionEnd = this.selectionEnd;
        } else if (this.hasOwnProperty("oldValue")) {
          this.value = this.oldValue;
          this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
        }
      });
    });
  }
  // Install input filters.

  setInputFilter(document.getElementById("from_amount"), function(value) {
    return /^\d*$/.test(value); });
   setInputFilter(document.getElementById("to_amount"), function(value) {
    return /^\d*$/.test(value); });
 
</script>
@endsection

