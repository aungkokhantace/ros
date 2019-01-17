@extends('Backend.layouts.master')
@section('title','Invoice Listing')
@section('content')
    <div class="content-wrapper">
      <div class="box">
       
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
            <div class="col-md-7 col-md-offset-2">
                <div class="thumbnail">
                    <div class="row">
                        <div class="col-md-6 i-header" style="margin-top:55px">
                            <h4>Invoice</h4>
                            <label>Invoice No: {{ $orders->order_id}}</label>
                            <label>Invoice Date:{{$orders->order_time}}</label>
                        </div>

                        <div class="col-md-6">
                            <p ><img src="/uploads/{{ $config->logo }}" width="280px" height="280px"/></p>
                        </div>
                    </div><br />

                    <div class="row">
                        <div class="col-md-8 col-md-offset-2 i-header">
                            {{-- <label>{{ $config->restaurant_name}}</label><br /> --}}
                            <label><b>Email</b>: {{ $config->email }}</label>
                            <label><b>Tel</b>: {{ $config->phone}}</label>
                            <label><b>Addr</b>: {{ $config->address}}</label>
                            <label><b>Website</b>: {{ $config->website}}</label>
                        </div>
                    </div><br />

                    <div class="row i-body">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                    <td colspan="4"><span>
                                    @if($tables->count() > 0)
                                        @foreach($tables as $table)
                                            {{ $table->table_no }}
                                        @endforeach
                                    @elseif($rooms->count() > 0)
                                        @foreach($rooms as $room)
                                            {{ $room->room_name }}
                                        @endforeach
                                    @else
                                        {{ "Take Away" }}
                                    @endif
                                    </span></td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td width="10%" align='center'><span>Qty</span></td>
                                    <td width="50%" ><span>Product</span></td>
                                    <td width="20%" align='center'><span>Price</span></td>
                                    <td width="20%" align='center'><span>Amount</span></td>
                                </tr>
                            </tbody>

                            <tfoot>
                            @foreach($order_detail as $detail)
                                <tr>
                                    <td style="font-size:13px;line-height: 25px;border:none;" width="10%" align='center'><span>{{$detail->quantity }}</span></td>
                                    <td  width="50%" class="mm-font text-left"><span>
                                        @if(isset($detail->item_name))
                                            {{$detail->item_name}}
                                            @if ($detail->has_continent)
                                                @foreach($continent as $con)
                                                    @if ($detail->continent_id == $con->id)
                                                        ({{ $con->name }})
                                                    @endif
                                                @endforeach
                                            @endif
                                        @else
                                            {{ $detail->set_name }}
                                        @endif
                                    </span></td>
                                    <td  width="20%" align='center'><span>{{ number_format($detail->amount)  }}</span></td>
                                    <td  width="20%" align='right'><span>{{number_format($detail->quantity * $detail->amount)}}</span></td>
                                </tr>

                                @foreach($addon as $add)
                                    @if($detail->order_detail_id == $add['order_detail_id'])
                                        <tr class="i-title">
                                            <td  align='center'><span>{{ $add['quantity']}}</span></td>
                                            <td  class="text-left"><span>{{ $add['food_name']}}</span></td>
                                            <td  align='center'><span>{{ $add['amount']}}</span></td>
                                            <td  align='right'><span>{{number_format($add['quantity'] * $add['amount'])}}</span></td>
                                        </tr>
                                    @endif

                                @endforeach

                            @endforeach

                                <tr>
                                    <td  width="10%" colspan="3" align='right'><b>Total: (Exclusive Tax)</b></td>
                                    <td  width="20%" align='right'><b>{{ number_format($orders->total_price) }}</b></td>
                                </tr> 

                                <tr>
                                    <td  width="10%" colspan="3" align='right'><b>Room Charge</b></td>
                                    <td  width="20%" align='right'><span>{{ $orders->room_charge }}</span></td>
                                </tr>

                                <tr>
                                    <td  width="10%" colspan="3" align='right'><b>Service Tax ({{ $config->service}} %)</b></td>
                                    <td  width="20%" align='right'><span>{{ $orders->service_amount }}</span></td>
                                </tr>

                                <tr>
                                    <td  width="10%" colspan="3"align='right'><b>GST ({{$config->tax}} %)</b></td>
                                    <td  width="20%" align='right'><span>{{ $orders->tax_amount }}</span></td>
                                </tr>

                                <tr>
                                    <td  width="10%" colspan="3" align='right'><b>Discount</b></td>
                                    <td  width="20%" align='right'><span>{{ $orders->total_discount_amount }}</span></td>
                                </tr>

                                <tr>
                                    <td  width="10%" colspan="3" align='right'><b>FOC</b></td>
                                    <td  width="20%" align='right'><span>{{ number_format($orders->foc_amount) }}</span></td>
                                </tr>

                            </tfoot>
                        </table>
                    </div><br />

                    <div class="row">
                        <div class="col-md-4 col-md-offset-5">
                            <p class="text-left" style="font-size: 16px;"><b>Net Amount</b></p>
                        </div>

                        <div class="col-md-3">
                            <p class="text-right" style="font-size: 16px;font-weight:bold">{{ number_format($orders->all_total_amount) }}</p>
                        </div>
                    </div>

                    @foreach($payments as $payment)
                    <div class="row">
                        <div class="col-md-4 col-md-offset-5">
                            <p class="text-left" style="color:#BB0C25;font-size: 16px;">Paid {{ $payment['name'] }}</p>
                        </div>

                        <div class="col-md-3">
                            <p class="text-right" style="color:#BB0C25;font-size: 16px;">{{ number_format($payment['paid_amount']) }}</p>
                        </div>
                    </div>
                    @endforeach

                    <div class="row">
                        <div class="col-md-4 col-md-offset-5">
                            <p class="text-left" style="color:#009A3D;font-size: 16px;">Change</p>
                        </div>

                        <div class="col-md-3">
                            <p class="text-right" style="color:#009A3D;font-size: 16px;">{{ number_format($orders->refund) }}</p>
                        </div>
                    </div><br />

                    <div class="row">
                        <div class="col-md-12">
                            <p class="text-center" style="font-size: 16px;">Thank You</p>
                            <p class="text-center" style="font-size: 16px;"><a href="/Backend/invoice" class="btn btn-success">Go Back</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
