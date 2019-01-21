@extends('cashier.layouts.master')
@section('title','Report Listing')
@section('content')
    <div class="row">
        <div class="container">

            @if(count(Session::get('message')) != 0)
                <div>
                </div>
            @endif
        </div>
    </div>
    <div class="container">
        <div class="row">
            {{--heading title--}}


        </div>
    </div>
    {{--tables--}}
    <div class="container">
        <div class="row">
            <div class="col-md-12 tbl-container">
                <div class="invoice-wrapper">
                <div class=""></div>
                    <div class="invoice-table-wrapper">
                        <div id="-print-table" style="font-family:'Courier New',Times New Roman;font-weight: bold;">
                        <table class="print-invoice" style="border-collapse: collapse;width:83mm;margin:0 auto;table-layout: fixed;word-wrap: break-word;background:none;">
                        <p align="center">{{$day}} Report</p>
                            <thead>
                                <col width="60">
                                <col width="140">
                                <col width="90">
                                <col width="100">

                                <tr style="border-bottom:1px dashed black;font-size:13px;line-height:25px;">
                                    <td>No</td>
                                    <td>Order No</th>
                                    <td>Table (Stand No)</td>
                                    <td align="right">Amount</th>
                                </tr>
                            </thead>
                           
                            <tbody style="font-size:13px;line-height:25px;">
                                @php $i = 1; $tot = 0; @endphp
                                
                                @foreach($orders as $order)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $order->id }}</td>
                                        @if(!$order->table->isEmpty())
                                        <td>{{ $order->table[0]->table_no }}({{$order->stand_number}})</td>
                                        @elseif(!$order->rooms->isEmpty())
                                        <td>
                                            {{$order->rooms[0]->room_name}}
                                        </td>
                                        @else 
                                            <td>TA</td>
                                        @endif
                                        <td align="right">{{ number_format($order->total_price) }}</td>
                                        @php  $tot += $order->total_price  @endphp
                                    </tr>
                                @endforeach
                                <tr style="border-bottom:1px dashed black;font-size:13px;line-height:25px;">
                                    <td colspan="3">Total Amount</td>
                                    <td align="right">{{ number_format($tot) }}</td>
                                </tr>
                            </tbody>
                        </table> 
                    </div>
                    <div class="text-center mt-2">
                        <a href="{{ url()->previous() }}" class="btn btn-primary">Back</a>
                       
                        <button class="btn btn-success" id ="" onClick="print_click(this.id)">Print</button>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    
            function printElement(e) {
                var ifr = document.createElement('iframe');
                ifr.style='height: 0; width: 0px; position: absolute'
    
                document.body.appendChild(ifr);
    
                $(e).clone().appendTo(ifr.contentDocument.body);
                ifr.contentWindow.print();
    
                ifr.parentElement.removeChild(ifr);
            }
    
            function print_click(clicked_id)
            {
                var clickID     = clicked_id;
                var printID     = clickID + "-print-table";
                var test        = document.getElementById(printID);
                printElement(document.getElementById(printID));
            }
    
        </script>
@endsection
