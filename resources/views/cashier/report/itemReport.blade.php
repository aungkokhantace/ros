@extends('cashier.layouts.master')
@section('title','Best-selling Item Report')
@section('content')
    {{--title--}}
    <div class="container">
        {{--Order Listing Table--}}
        {{--From date, to date, and view report button--}}
        <div class="row date_button">
            <div class="col-md-11 date_row">

                <div class="col-md-12"><h3 class="h3"><strong>Best-selling Item Report</strong></h3></div>
                <div class="col-md-12 btn-gp">
                
                    {!! Form::open(array('url' => 'Cashier/itemReportWithDate', 'method' => 'post', 'class'=> 'form-horizontal user-form-border')) !!}
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

                    {{--Start number of items to show--}}
                    <div class="col-md-2">
                        
                        @if(isset($number))
                            <input type="number" name="number" id="number" class="form-control" value="{{$number}}" min="1" step="1" placeholder="Choose Top Item">
                        @else
                            <input type="number" name="number" id="number" class="form-control" min="1" step="1" placeholder="Choose Top Item">
                        @endif
                    </div>
                    {{--End number of items to show--}}
                    <div class="col-md-2">
                        @if(isset($from_amount))
                        <input type="text" name="from_amount" class="form-control" 
                        value="{{$from_amount}}">
                        @else
                        <input type="text" name="from_amount" class="form-control" placeholder="Start Amount">
                        @endif
                    </div>
                    <div class="col-md-2">
                        @if(isset($to_amount))
                        <input type="text" name="to_amount" class="form-control" 
                        value="{{$to_amount}}">
                        @else
                        <input type="text" name="to_amount" class="form-control" placeholder="End Amount">
                        @endif
                    </div><br/><br/>
                    <div class="col-md-2">
                        <button type="submit" class="btn_submit">
                            Search
                        </button>
                    </div>
                    {!! Form::close() !!}

                    <div class="col-md-1">
                        @if(isset($start_date))
                            @if($number=="" && $from_amount == "")
                                <a href={{'/Cashier/downloadItemReportWithDate/'.$start_date.'/'.$end_date}}><button class="btn btn-success btn_export">Export</button></a>
                            @elseif($number != "" && $from_amount == "")
                                <a href={{'/Cashier/downloadItemReportWithDate/'.$start_date.'/'.$end_date.'/'.$number}}><button class="btn btn-success btn_export">Export</button></a>
                            @elseif($number == "" && $from_amount != "")
                                <a href={{'/Cashier/downloadItemReportWithDate/'.$start_date.'/'.$end_date.'/'.$from_amount.'/'.$to_amount}}><button class="btn btn-success btn_export">Export</button></a>
                            @else
                                <a href={{'/Cashier/downloadItemReportWithDate/'.$start_date.'/'.$end_date.'/'.$number.'/'.$from_amount.'/'.$to_amount}}><button class="btn btn-success btn_export">Export</button></a>
                            @endif
                        @else
                            <a href={{'/Cashier/downloadItemReport'}}><button class="btn btn-success btn_export">Export</button></a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        {{--From date, to date, and view report button--}}
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
        {{--From date, to date, and view report button--}}
        <div class="row" id="autoDiv">
            <div class="col-md-11">
                <table class="table table-bordered">
                    <thead class="thead_report">
                    <tr class="report-th">
                        <th>Item Name</th>
                        <th>Quantity</th>
                        <th>Price </th>
                        <th>Discount Price</th>
                        <th>Amount</th>
                        <th>Total Amount</th>
                    </tr>
                    </thead>

                    <?php $sum=0;?>
                    @foreach($orders as $order)
                        <tr class="tr-row active">
                            <td>{{ $order->name }}</td>
                            <td>{{ $order->total }}</td>
                            <td>{{number_format($order->amount)}}</td>
                            <td>{{number_format($order->discount_amount)}}</td>
                            <td class="money-align">{{ number_format($order->price) }}</td>
                            <td class="money-align">{{ number_format($order->total_amt) }}</td>
                            <?php $sum += $order->total_amt;?>
                        </tr>
                    @endforeach
                    <tr class="active">
                        <td colspan="4"></td>
                        <td class="money-align">Total Amount</td>
                        <td class="money-align">{{number_format($sum)}}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection

