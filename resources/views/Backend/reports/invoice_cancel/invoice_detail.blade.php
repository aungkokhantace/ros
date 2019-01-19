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
<style type="text/css">
    .invoice_report table tbody tr td {
    /*color: red;
    font-size: 15px;
    line-height: 35px;*/
    background-color: #324c52;
    color: #fff;
}
</style>
    {{--tables--}}
    <input type="hidden" name="from" id="from" value="{{isset($from)?$from:''}}">
    <input type="hidden" name="to" id="to" value="{{isset($to)?$to:''}}">

    <div class="container">
        <div class="row">
            <div class="col-md-7 col-md-offset-2">
                <div class="thumbnail">

                    <div class="row">                      
                             <h3 class="text-center">Voucher  Detail</h4>                        
                    </div><br />                   
                 <!--    <div class="row i-body"> -->
                    <div class="row invoice_report">
                        <table class="table table-bordered">                            
                            <tr>
                                <th><b>Voucher No :</b></th>
                                 <th colspan="3">{{$invoice_id }} - 
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
                                </th>                              
                            </tr>
                            <tr>
                                <th><b>Date :</b></th>
                                <th colspan="3">{{date('d-m-Y g:i:s A',strtotime($orders->order_time))}}</th>
                            </tr>
                           
                            <tbody>
                                <tr>                                  
                                    <td width="50%"><span>Product</span></td>
                                    <td width="20%"><span>Price</span></td>
                                    <td width="10%"><span>Qty</span></td>
                                    <td width="20%"><span>Amount</span></td>
                                </tr>
                            </tbody>

                            <tfoot>
                            @foreach($order_detail as $detail)
                                <tr>                                   
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
                                    <td  width="20%" class="text-left"><span>{{ number_format($detail->amount)  }}</span></td>
                                     <td  class="text-left"><span>{{$detail->quantity }}</span></td>
                                    <td  width="20%" class="text-left"><span>{{number_format($detail->quantity * $detail->amount)}}</span></td>
                                </tr>

                                @foreach($addon as $add)
                                    @if($detail->order_detail_id == $add['order_detail_id'])
                                        <tr class="i-title">                                            
                                            <td  class="text-left"><span>{{ $add['food_name'].' (Add on)'}}</span></td>
                                            <td  class="text-left"><span>{{ $add['amount']}}</span></td>
                                            <td  class="text-left"><span>{{ $add['quantity']}}</span></td>
                                            <td  class="text-left"><span>{{number_format($add['quantity'] * $add['amount'])}}</span></td>
                                        </tr>
                                    @endif
                                @endforeach
                            @endforeach
                            <tr>
                                <td colspan="3">Net Amount </td>
                                <td>{{number_format($orders->NetAmount)}}</td>
                            </tr>
                             <tr>
                                <td colspan="3">Discount </td>
                                <td>{{number_format($orders->over_all_discount)}}</td>
                            </tr>
                             <tr>
                                <td colspan="3">Sub Total </td>
                                <td>{{number_format($orders->sub_total)}}</td>
                            </tr>
                             <tr>
                                <td colspan="3">Service ({{$config->service.'%'}}) </td>
                                <td>{{number_format($orders->service_amount)}}</td>
                            </tr>
                            <tr>
                                <td colspan="3">Tax ({{$config->tax.'%'}}) </td>
                                <td >{{number_format($orders->tax_amount)}}</td>
                            </tr>
                            <tr>
                                <td colspan="3"><b>Total Amount</b> </td>
                                <td><b>{{number_format($orders->Amount)}}</b></td>
                            </tr>
                            <tr>
                                <td colspan="3"><b>Cash Received</b> </td>
                                <td><b>{{number_format($orders->cash_receive)}}</b></td>
                            </tr>
                            <tr>
                                <td colspan="3"><b>Change</b> </td>
                                <td><b>{{number_format($orders->change)}}</b></td>
                            </tr>


                            </tfoot>
                        </table>
                    </div><br />               

                    <div class="row">
                        <div class="col-md-12">
                            <p class="text-center" style="font-size: 16px;">Thank You</p>                          

                            <p class="text-center" style="font-size: 16px;"><a href="{{'/Backend/invoice/cancel_report/search/'.$from.'/'.$to}}" class="btn btn-primary">Go Back</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
