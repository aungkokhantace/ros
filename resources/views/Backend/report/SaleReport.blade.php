@extends('Backend.layouts.master')
@section('title','Sale Report')
@section('content')
    {{--title--}}
    <div class="content-wrapper">
        <div class="box">
            <div class="box-header">
                {{--Order Listing Table--}}
                <div class="container">
                    <div class="row">
                        <div class="col-md-11">
                            <div class="col-md-12">
                                <h3 class="h3 report_heading"><strong>Sale Report</strong></h3>
                            </div>
                        </div>

                        <div class="col-md-12">
                            {!! Form::open(array('url' => 'Backend/search_report', 'class'=> 'form-horizontal user-form-border')) !!}
                            <div class="col-md-4">

                                <!-- <input type="text" name="from" placeholder="From" class="form-control pull-right" id="datepicker" readonly value="{{isset($from)? date("d-m-Y",strtotime($from)) :""}}"> -->

                                <div class="input-group">
                                    <input  type="text" class="form-control" id="from" name="from" placeholder="Choose Start Date" value= "{{isset($from)? $from:Input::old('from')}}" readonly="readonly">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">

                                <!-- <input type="text" name="to" placeholder="To" class="form-control pull-right" id="datepicker1" readonly value="{{isset($to)? date("d-m-Y",strtotime($to)) :""}}"> -->

                                <div class="input-group">
                                    <input  type="text" class="form-control" id="to" name="to" placeholder="Choose End Date" value= "{{isset($to)? $to:Input::old('to')}}" readonly="readonly">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <input type="submit" value="Search" class="btn btn-info "/>
                            </div>

                            {!! Form::close() !!}
                            <div class="col-md-1">
                                @if(isset($orders))
                                    @if(count($orders) > 0)
                                        @if(isset($from))
                                            <a href="{{'/Backend/SaleExportDetail/' . $from. '/'.$to }} "  >
                                                <button class="btn btn-primary" >Export</button>
                                            </a>
                                        @else
                                            <a href="{{ '/Backend/SaleExport/'}}"  >
                                                <button class="btn btn-primary">Export</button>
                                            </a>
                                        @endif
                                    @endif
                                @else
                                    @if(isset($from))
                                        <a href="{{'/Backend/SaleExportDetail/' . $from. '/'.$to }} "  >
                                            <button class="btn btn-primary" >Export</button>
                                        </a>
                                    @else
                                        <a href="{{ '/Backend/SaleExport/'}}"  >
                                            <button class="btn btn-primary">Export</button>
                                        </a>
                                    @endif
                                @endif
                            </div>
                        </div>
                        </div>
                </div><br/>
            </div>
        </div>

        <div class="container">
            <div class="row" id="autoDiv">
                <div class="col-md-12 table-responsive">
                    <table id="example3" class="table table-striped" style="width:100%">
                        <thead class="thead_report">
                            <tr class="report-th">
                                <th width="15%">Invoice ID</th>
                                <th>Date</th>
                                <th>Cashier</th>
                                <th>Quantity</th>
                                <th>Total Discount Amount</th>
                                <th>Total Tax Amount</th>
                                <th>Total Service Amount</th>
                                <th>Total Room Charge</th>
                                <th>Total FOC Amount</th>
                                <th>Total Extra Price</th>
                                <th>Total Amount</th>
                            </tr>
                        </thead>
                        @if(isset($orders))
                            @foreach($orders as $order)
                                <tr class="tr-row active">
                                    <td>{{ $order->invoice_id }}</td>
                                    <td>{{ date('d-m-Y',strtotime($order->order_time)) }}</td>
                                    <td>{{ $order->user_name }}</td>
                                    <td>{{ $order->Quantity }}</td>
                                    <td class="money-align">{{ number_format($order->Discount) }}</td>
                                    <td class="money-align">{{ number_format($order->Tax) }}</td>
                                    <td class="money-align">{{ number_format($order->Service) }}</td>
                                    <td class="money-align">{{ number_format($order->RoomCharge) }}</td>
                                    <td class="money-align">{{ number_format($order->Foc) }}</td>
                                    <td class="money-align">{{ number_format($order->Extra) }}</td>
                                    <td class="money-align">{{ number_format($order->Amount) }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </table>
                </div>
            </div>
        </div>
            </div>
        </div>
    </div>

    @if(!isset($orders))
    <script type="text/javascript">
        var table = $('#example3').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "{{ url('/Backend/saleAjaxRequest')}}",
            iDisplayLength: 10,
            "ordering":false,
            "bLengthChange": false,
            "bFilter": true,
            "bInfo": false,
            "bAutoWidth": false,
            "columnDefs": [ {
            "searchable": false,
            "orderable": false,
            "targets": 0
            } ],
            "order": [[ 1, "desc" ]],
            stateSave: false,
            "dom": '<"pull-right m-t-20"i>rt<"bottom"lp><"clear">',

        });
    </script>
    @endif
@endsection

