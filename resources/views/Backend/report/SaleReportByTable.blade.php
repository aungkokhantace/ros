@extends('Backend.layouts.master')
@section('title', 'Sale Report By Table')
@section('content')
    <div class="content-wrapper">
        <div class="box">
            <div class="box-header">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <h3><strong>Sale Report By Table</strong></h3>
                        </div>
                        <div class="col-md-12">
                            <form class ='form-horizontal user-form-border' action="{{ url('Backend/table-sale-report') }}" method="post">
                                {{ csrf_field() }}
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="from" name="from" placeholder="Choose Start Date" value= "{{isset($date) ? $date['from'] : null}}" readonly="readonly"/>
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="to" name="to" placeholder="Choose End Date" value= "{{isset($date) ? $date['to'] : null}}" readonly="readonly"/>
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="input-group">
                                        <input type="submit" value="Search" class="btn btn-info"/>
                                    </div>
                                </div>
                            </form>
                            <div class="col-md-1">
                                @if(isset($orders))
                                    @if(count($orders) > 0)
                                        @if(isset($date['from']))
                                            <a href="{{'/Backend/table-sale-report/export/' . $date['from']. '/'.$date['to'] }} " >
                                                <button class="btn btn-primary">Export</button>
                                            </a>
                                        @else
                                            <a href="{{ '/Backend/table-sale-report/export'}}" >
                                                <button class="btn btn-primary">Export</button>
                                            </a>
                                        @endif
                                    @endif
                                @elseif(isset($date))
                                    <a href="{{'/Backend/table-sale-report/export/' . $date['from']. '/'.$date['to'] }} "  >
                                        <button class="btn btn-primary" >Export</button>
                                    </a>
                                @else
                                    <a href="{{'/Backend/table-sale-report/export'}}">
                                        <button class="btn btn-primary">Export</button>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row" id="autoDiv">
                <div class="col-md-12">
                    <table class="table table-striped" style="width:100%" id="example3">
                        <thead class="thead_report">
                        <tr class="report-th">
                            <th>Table No</th>
                            <th>Number of Invoices</th>
                            <th>Amount</th>
                        </tr>
                        </thead>
                        @if(!empty($reports))
                            @foreach($reports as $report)
                                <tr>
                                    <td style="text-align: center">{{ $report->table_no }}</td>
                                    <td>{{ $report->quantity }}</td>
                                    <td>{{ $report->amount }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4" style="text-align: center; height: 50px">No data available in table</td>
                            </tr>
                        @endif
                        <tr class="tr-row">
                            <td colspan="1"></td>
                            <td class="money-align"><b>Grand Total amount</b></td>
                            <td class="money-align">
                                <b>
                                    {{ !empty($total) ? $total : 0 }}
                                </b>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection