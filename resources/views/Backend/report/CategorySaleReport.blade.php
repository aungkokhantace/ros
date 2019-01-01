@extends('Backend.layouts.master')
@section('title','Category Sale Report')
@section('content')
<div class="content-wrapper">
    <div class="box">
        <div class="box-header">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h3>
                            <strong>Category Sale Report</strong>
                        </h3>
                    </div>
                    <div class="col-md-12">
                        <form class ='form-horizontal user-form-border' action="{{ url('Backend/category-sale-search') }}" method="post">
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
                                        <a href="{{'/Backend/category-sale-export/' . $date['from']. '/'.$date['to'] }} " >
                                            <button class="btn btn-primary">Export</button>
                                        </a>
                                    @else
                                        <a href="{{ '/Backend/category-sale-export'}}" >
                                            <button class="btn btn-primary">Export</button>
                                        </a>
                                    @endif
                                @endif
                            @elseif(isset($date))
                                    <a href="{{'/Backend/category-sale-export/' . $date['from']. '/'.$date['to'] }} "  >
                                        <button class="btn btn-primary" >Export</button>
                                    </a>
                                @else
                                    <a href="{{'/Backend/category-sale-export/'}}">
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
                        <th>Parent Category Name</th>
                        <th>Category Name</th>
                        <th>Quantity</th>
                        <th>Total Amount</th>
                    </tr>
                    </thead>
                    @if(!empty($result))
                        @foreach($result as $value)
                        <tr>
                            <td>{{ $value->category_name }}</td>
                            <td>{{ $value->item_name }}</td>
                            <td>{{ $value->quantity }}</td>
                            <td>{{ $value->amount }}</td>
                        </tr>
                            <?php
                                $sum = 0;
                                $sum += $value->amount;
                            ?>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4" style="text-align: center; height: 50px">No data available in table</td>
                        </tr>
                    @endif
                    <tr class="tr-row">
                        <td colspan="2"></td>
                        <td class="money-align"><b>Grand Total amount</b></td>
                        <td class="money-align">
                            <b>
                                {{ !empty($sum) ? $sum : 0 }}
                            </b>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
{{--@if(!isset($result))--}}
{{--<script type="text/javascript">--}}
    {{--var table = $('#example3').DataTable({--}}
        {{--"processing": true,--}}
        {{--"serverSide": true,--}}
        {{--"ajax": "{{ url('/Backend/categorySaleAjaxRequest')}}",--}}
        {{--iDisplayLength: 30,--}}
        {{--"ordering":false,--}}
        {{--"bLengthChange": false,--}}
        {{--"bFilter": true,--}}
        {{--"bInfo": false,--}}
        {{--"bAutoWidth": false,--}}
        {{--"order": [[ 1, "desc" ]],--}}
        {{--stateSave: false,--}}
        {{--"dom": '<"pull-right m-t-20"i>rt<"bottom"lp><"clear">',--}}
        {{--"sDom": "lfrti",--}}
        {{--"searching": false--}}

    {{--});--}}
{{--</script>--}}

{{--@endif--}}
@endsection