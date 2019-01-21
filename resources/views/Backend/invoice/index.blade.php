@extends('Backend.layouts.master')
@section('title','Invoice Listing')
@section('content')
<style>
    table.dataTable.no-footer {
    border-bottom: 1px solid #fff;
}
</style>
<div class="content-wrapper">
    <div class="box">
     <div class="box-header" style="margin-left:50px">
  
      {{--Order Listing Table--}}
     
          <div class="row">
              <div class="col-md-11">
                  <div class="col-md-12">
                      <h3 class="h3 report_heading"><strong>Invoice Listing</strong></h3>
                  </div>
   </div>
  </div>
                  <div class="container">
                  {!! Form::open(array('url' => 'Backend/invoice/query' ,'method'=>'post', 'class'=> 'form-horizontal user-form-border')) !!}
                  <div class="col-md-12">
                        <div id="sale_summary">
                            <div class="col-md-2 radio_view">
                                <input type="radio" name="viewBy" id="daily" value="daily" checked> <label for="daily">Daily</label>
                            </div>
                            {{-- <div class="col-md-2 radio_view">
                                <input type="radio" name="viewBy" id="monthly" value="monthly"> <label for="monthly">Monthly</label>
                            </div>
                            <div class="col-md-2 radio_view">
                                <input type="radio" name="viewBy" id="yearly" value="yearly"> <label for="yearly">Yearly</label>
                            </div> --}}
                        
                          </div>
                    </div>
                  </div>

                  <div class="col-md-3" style="padding:0;">
                      <div class="input-group">
                          <input  type="text" class="form-control" id="from" name="from_date" placeholder="Choose Start Date" value= "{{isset($from_date)? date("d-m-Y",strtotime($from_date)):""}}" readonly="readonly">
                          <div class="input-group-addon">
                              <i class="fa fa-calendar"></i>
                          </div>
                      </div>

                  </div>

                      <div class="col-md-3" style="padding:0;margin-left:20px">
                          <div class="input-group">
                              <input  type="text" class="form-control" id="to" name="to_date" placeholder="Choose End Date" value= "{{isset($to_date)? date("d-m-Y",strtotime($to_date)):""}}" readonly="readonly">
                              <div class="input-group-addon">
                                  <i class="fa fa-calendar"></i>
                              </div>
                          </div>
                      </div>

                  
                  <div class="col-md-1 ">
                      <input type="submit" value="Search" class=" btn btn-primary btn_submit"/>
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
                      <table class="table table-bordered dailytable" id="invoice_tbl" style ="padding: 15px;margin-left: 13px;">
                          <thead class="thead_report">
                          <tr class="report-th">
                              <th>Orde NO.</th>
                              <th>Total Amount</th>
                              <th>Date</th>
                              <th>View Detail</th>
                              <th>Status</th>
                          </tr>
                          </thead>
                          <tbody>
                            @foreach($orders as $order)
                            <tr class="tr-row active">
                                <td width="20%">{{ $order->id }}</td>
                                <td class="money-align">{{ $order->all_total_amount }}</td>
                                <td class="money-align">{{ $order->created_at->toDateString() }}</td>
                                <td><a href="/Backend/invoice/detail/{{$order->id}}">View Detail</a>
                                </td>
                            <td>{{($order->status)? "Unpaid" : "Paid"}}</td>
                            </tr>
                        @endforeach
                          </tbody>
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
          $('#invoice_tbl').DataTable({bFilter: false,"bLengthChange": false, bInfo: false});
      });
  </script>
@endsection
