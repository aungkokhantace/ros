@extends('cashier.layouts.master')
@section('title','Order View')
@section('content')
    {{--title--}}
    <div class="container">


        {{--Order Listing Table--}}
        <div class="container">
            <div class="row">
                <div class="col-md-11">
                    <div class="col-md-6">
                        <h3 class="h3"><strong>Order Listing</strong></h3>
                    </div>
                    <div class="col-md-6">
                        <h3 class="h3">
                            View By <select name="view" id="viewBy">

                                <option value="1">Table Detail View</option>
                                <option value="2">Product View</option>
                            </select>
                        </h3>

                    </div>
                </div>
            </div>
            <div class="row" id="autoDiv">

                @foreach($groupedOrders as $group)
                    <table class="table table-bordered">
                        <tr>
                            <td>{{$group->first()->table_no}}</td>
                        </tr>
                        <tr>
                            <td>Product Name</td>
                            <td>Qty</td>
                            <td>Exception</td>
                            <td>Extra</td>
                            <td>StartTime</td>
                            <td>Duration</td>
                            <td></td>
                            <td></td>
                        </tr>
                        @foreach($group as $order)
                                @foreach($items as $item)
                                    @if($item->id == $order->item_id)
                                        <tr class="tr-row"  data-ordertime = "{{ $order->order_time }}">
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $order->quantity }}</td>
                                            <td>{{ $order->exception }}</td>
                                            <td>+1{{ $order->extra_food }}</td>
                                            <td data-ordertime = "{{ $order->order_time }}">{{ $order->order_time }}</td>

                                            <td class="duration"></td>
                                            <td>
                                                <input type="submit" class="complete" id="{{$order->order_detail_id}}" name="complete" value="Complete"></td>
                                            <td><input type="submit" class="cancel" id="{{$order->order_detail_id}}" name="cancel" value="Cancel"></td>
                                        </tr>
                                    @endif
                                @endforeach
                        @endforeach
                    </table>
                @endforeach
            </div>
        </div>
    </div>
    <script type="text/javascript">


        $(document).ready(function(){
            // var obj = <?php echo json_encode($orders) ?>;

            var myVar = setInterval(myTimer ,1000);

            function myTimer() {
                $("table tr.tr-row").each(function(){

                    var currentTime = moment();
                    var orderTime = moment($(this).data("ordertime"), 'YYYY-MM-DD hh:mm:ss');

                    var diff = currentTime.diff( orderTime );
                    console.log( currentTime.format("YYYY-MM-DD hh:mm:ss"), orderTime.format("YYYY-MM-DD hh:mm:ss"), diff );

                    var duration = moment(0).add( diff, 'milliseconds').format("mm:ss");
                    console.log( duration );

                    $(this).find(".duration").text( duration );

                });
            };

            setTimeout(function () { window.location.href="/Cashier/tableView" }, 5000);

        });

        $('#viewBy').change(function(e){
            console.log($(this).val());
            var url = 'getTableView?view='+ $(this).value();
            console.log(url);
        })
        $('.complete').click(function(e){
            console.log($(this).attr('id'));
            window.location.href = "/Cashier/getCompleteID/"+$(this).attr('id');

        });
        $('.cancel').click(function(e){
            window.location.href = "/Cashier/getCancelID/"+$(this).attr('id');
        });





    </script>
@endsection

