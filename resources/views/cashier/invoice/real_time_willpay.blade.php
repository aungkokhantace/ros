
            <table class="table invoice-table table-hover" id="table-pagination">
                <thead>
                    <tr>
                        <th>Order No.</th>
                        <th>Order Location</th>
                        <th>Total Amount</th>
                        <th>Date</th>
                        <th>Detail</th>
                        <th>Status</th>
                        <!-- <th>Action</th> -->
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                @foreach($orders as $order)
                    <tr class="tr-{{$order->id}}">
                        <td id="ordere-id"> {{$order->id}} </td>
                        @if($order->order_table != false)
                        <td>
                         {{$order->order_table}}
                        </td>
                        @elseif($order->order_rooms != false)
                        <td>
                        {{$order->order_rooms}}
                        </td>
                        @elseif($order->take_away == true)
                        <td>
                        Take Away
                        </td>
                        @endif
                        <td> {{$order->all_total_amount}} </td>
                        <td > {{$order->created_at }} </td>
                        <td><a class="btn detail-btn" href="/Cashier/invoice/detail/{{$order->id}}">view detail</a></td>
                        <td>
                            @if($order->status == 2)
                                <a href="#" class="btn btn-success status-btn">Paid</a>
                            @else
                                <a href="/Cashier/invoice/paid/{{$order->id}}" class="btn btn-primary status-btn">To Pay</a>
                            @endif
                        </td>
                        <!-- @if($order->status == 2)
                            <td><i class="fa fa-lock ml-4" style="font-size:20px;"></i></td>
                            @else
                            <td><a class="btn btn-info status-btn" href="/Cashier/MakeOrder/edit/{{$order->id}}">Edit</a></td>
                        @endif -->
                        {{-- <td>
                            @if($order->status == 2)
                            <button class="btn print-btn" id = '{{$order->order_id}}' data-toggle="modal" data-target="#printModal" data-id="{{$order->id}}" onclick="printInvoice('{{$order->order_id}}')"></button>
                            @else
                            <button class="btn btn-danger order-cancel" id = '{{$order->id}}' data-toggle="modal" data-target="#myModal" data-id="{{$order->id}}">Cancel</button>
                            @endif
                        </td> --}}
                    </tr>
                @endforeach
                </tbody>
            </table>
