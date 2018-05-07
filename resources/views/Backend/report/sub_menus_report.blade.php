@extends('Backend.layouts.master')
@section('title','Best Selling Set Report')
@section('content')
     <div class="content-wrapper">
      <div class="box">
       <div class="box-header">
          <div class="row date_button">
                <div class="col-md-11 date_row">
                    <div class="col-md-12"><h3 class="h3"><strong>Best-selling Set Menu Report</strong></h3></div>
                    <div class="col-md-12">
      
       
             
                        {!! Form::open(array('url' => 'Backend/fav_set_date_report', 'method' => 'post', 'class'=> 'form-horizontal user-form-border')) !!}
                        <div class="col-md-3">
                            <!-- <input type="text" name="from" class="form-control pull-right" id="datepicker" placeholder="From" readonly value="{{isset($start_date)? date("d-m-Y",strtotime($start_date)):""}}"> -->

                            <div class="input-group">
                                <input  type="text" class="form-control" id="from" name="from" placeholder="Choose Start Date" value= "{{isset($start_date)? date("d-m-Y",strtotime($start_date)):""}}">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <!-- <input type="text" name="to" class="form-control pull-right" id="datepicker1" placeholder="To" readonly value="{{isset($start_date)? date("d-m-Y",strtotime($end_date )):""}}"> -->

                            <div class="input-group">
                                <input  type="text" class="form-control" id="to" name="to" placeholder="Choose End Date" value= "{{isset($start_date)? date("d-m-Y",strtotime($end_date)):""}}">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                            </div>
                        </div>
                        {{--Start dropdown for number of sets to show--}}
                        <div class="col-md-3">
                            
                            @if(isset($number))
                                <input type="number" name="number" id="number" class="form-control" value="{{$number}}" min="1" step="1" placeholder="Choose Top SetMenu">
                            @else
                                <input type="number" name="number" id="number" class="form-control" min="1" step="1" placeholder="Choose Top SetMenu">
                            @endif
                        </div>
                        {{--End dropdown for number of sets to show--}}

                        <div class="col-md-1">
                            <button type="submit" class=" btn btn-info btn_submit">
                                Search
                            </button>
                        </div>
                        {!! Form::close() !!}
                        <div class="col-md-1">
                            @if(isset($start_date))
                                @if($number=="")
                                    <a href={{'/Backend/downloadsubReportWithDate/'.$start_date.'/'.$end_date}}><button class="btn btn-primary btn_export">Export</button></a>
                                @else
                                    <a href={{'/Backend/downloadsubReportWithDate/'.$start_date.'/'.$end_date.'/'.$number}}><button class="btn btn-primary btn_export">Export</button></a>
                                @endif
                            @else
                                <a href={{'/Backend/downloadsubReport'}}><button class="btn btn-primary btn_export">Export</button></a>
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
                @else
                    {{--User-defined start date and end date (i.e. filtered by date)--}}
                    <strong>Showing results from {{( date("d-m-Y",strtotime($start_date )))}} to {{( date("d-m-Y",strtotime($end_date)))}}</strong>
                @endif
            </div>
        </div>
    </div>
</div>
        <div class="container">
        <div class="row" id="autoDiv">
            <div class="col-md-12">
                <table class="table table-bordered ">
                    <thead class="thead_report">
                    <tr class="report-th">
                        <th>Set Menu Name</th>
                        <th>Quantity</th>
                        <th>Discount Amount</th>
                        <th>Price</th>
                        <th>Amount</th>
                        <th>Total Amount</th>
                    </tr>
                    </thead>
                    <?php $sum=0;?>

                    @foreach($sub_orders as $sub)
                        <tr class="tr-row active">
                            <td>{{ $sub->Name }}</td>
                            <td>{{ $sub->Quantity }}</td>
                            <td>{{ $sub->DiscountAmount === "" ? "0.0" : $sub->DiscountAmount }}</td>
                            <td>{{number_format($sub->Price)}}</td>
                            <td class="money-align">{{ number_format($sub->Amount) }}</td>
                            <td class="money-align">{{ number_format($sub->TotalAmount) }}</td>
                            <?php $sum += $sub->TotalAmount;?>
                        </tr>
                    @endforeach
                    <tr class="active">
                        <td colspan="4"></td>
                        <td class="money-align">Total amount</td>
                        <td class="money-align">{{number_format($sum)}}</td>
                    </tr>
                </table>
                </div>
            </div>
        </div>
    </div>

@endsection
