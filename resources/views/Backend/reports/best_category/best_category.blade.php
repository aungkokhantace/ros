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

                <div class="col-md-12"><h3 class="h3"><strong>Best-Selling Category Report</strong></h3></div>
            <div class="col-md-12 btn-gp">
        
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
            <button class="btn btn-primary " onclick="best_category_excel('categorySaleReport');">Export</button>                    
        </div>
         <div class="col-md-1 pull-right">          
        <button type="submit" class="btn btn-primary " onclick="best_category_search('categorySaleReport');">
            Search
        </button>
        </div>
                </div>
            </div>
        </div>
        {{--From date, to date, and view report button--}}
       {{-- <div class="row">
            <div class="table col-md-11">
                @if(isset($start))
                  
                    <strong>Showing results from <em class="text-success">{{( date("d-m-Y",strtotime($start->min )))}}</em> to <em class="text-success"> {{( date("d-m-Y",strtotime($end ->max )))}} </em></strong>
                @else                   
                    <strong>Showing results from <em class="text-success"> {{( date("d-m-Y",strtotime($start_date )))}}</em class="text-success"> to <em>{{( date("d-m-Y",strtotime($end_date)))}}</em></strong>
                @endif
            </div>
        </div> --}}
    </div>
</div>
        {{--From date, to date, and view report button--}}
        <div class="container">
        <div class="row" id="autoDiv">
            <div class="col-md-12">
               <table class="table table-striped" style="width:100%" id="example3">
                    <thead class="thead_report">
                    <tr class="report-th">
                     
                        <th>Category</th>
                        <th>Quantity</th>
                        <th>Total Amount</th>
                    </tr>
                    </thead>
                  <?php $sum = 0; ?>
                    @if(!empty($orders))
                        @foreach($orders as $value)
                          
                        <tr class="tr-row active">
                         
                            <td>{{ $value['name'] }}</td>
                            <td>{{ $value['qty'] }}</td>
                            <td>{{ number_format($value['price']) }}</td>
                        </tr>
                            <?php                         
                               $sum +=(int)$value['price'];                             
                            
                            ?>
                        @endforeach 
                    @else
                        <tr>
                            <td colspan="3" style="text-align: center; height: 50px">No data available in table</td>
                        </tr>
                    @endif

                    <tr class="tr-row">
                        <td colspan="1"></td>
                        <td class="money-align">Total amount</td>
                        <td class="money-align">{{number_format($sum)}}
                           
                        </td>
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

