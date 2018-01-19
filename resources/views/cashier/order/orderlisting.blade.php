@extends('cashier.layouts.master')
@section('title','Order Detail')
@section('content')
    {{--title--}}
    <div class="container">
        <div class="row">
            {{--heading title--}}
            <div class="col-md-3">

                <h3 class="h3"><strong>Order Listing</strong></h3>

            </div>
        </div>

        {{--Order Listing Table--}}
    <div class="container">
        <div class="row">
            <div class="col-md-11">

                    <tbody >
                    <div class="searchitem">
                        Search: <input type="textbox"  id="orderauto" class="search" placeholder="Waiter Name and Table No">
                    </div>

                    <div id="tabs">
                        <ul>
                            <li><a href="#tabs-1">All Order</a></li>
                            <li><a href="#tabs-2">Done</a></li>
                            <li><a href="#tabs-3">Delivered</a></li>
                        </ul>
                        <div class="tab-content">
                        <div id="tabs-1">
                            <table id="tbl_listing" class="table table-bordered">
                                <thead>
                                <tr>
                                    <th rowspan="2" cellpadding="2px">#</th>
                                    <th rowspan="2">Order Time</th>
                                    <th rowspan="2">Waiter</th>
                                    <th rowspan="2">Table No</th>
                                    <th colspan="5" class="order">Order Detail</th>
                                    <th rowspan="2">Order Type</th>
                                    <th rowspan="2">Status</th>
                                    <th rowspan="2">Payment</th>

                                </tr>

                                <tr>
                                    <td> Item </td>
                                    <td> Price </td>
                                    <td> Qty </td>
                                    <td> Exception </td>
                                    <td> Extra </td>

                                </tr>
                                </thead>
                                @foreach($orders as $order)
                                    <tr>
                                        <td>{{ $order->order_id }}</td>
                                        <td>{{ $order->order_time }}</td>
                                        <td>
                                            @foreach($user as $users)
                                                <?php
                                                if($users->id === $order->user_id)
                                                {
                                                    echo $users->user_name;
                                                }
                                                ?>
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach($table as $tables)
                                                <?php
                                                if($tables->id === $order->table_id)
                                                {
                                                    echo $tables->table_no;
                                                }
                                                ?>
                                            @endforeach
                                        </td>
                                        <td>{{ $order->name }}</td>
                                        <td>{{$order->price}}</td>
                                        <td>{{ $order->quantity }}</td>
                                        <td>{{$order->exception}}</td>
                                        <td>
                                            @if(isset($order->extra))
                                               {{ $order->extra_food }}
                                            @endif
                                        </td>

                                        <td>
                                            @foreach($order_type as $ordertype)
                                                <?php
                                                if($order->order_type_id === $ordertype->id)
                                                {
                                                    echo $ordertype->type;
                                                }
                                                ?>
                                            @endforeach
                                        </td>
                                        <td>
                                            <select name="status">
                                                @if($order->status_id == '1')
                                                    <option value="1" selected>Processiong</option>
                                                    <option value="2">Complete</option>
                                                    <option value="3">Deliver</option>
                                                @elseif($order->status_id == '2')
                                                    <option value="2" selected>Complete</option>
                                                    <option value="1">Processing</option>
                                                    <option value="3">Deliver</option>
                                                @else
                                                    <option vlaue="3" selected>Deliver</option>
                                                    <option value="1">Processing</option>
                                                    <option value="2">Complete</option>
                                                @endif
                                            </select>
                                        </td>

                                        <td>{{ $order->amount + $order->extra_price}}</td>

                                @endforeach
                            </table>
                            <?php echo $orders->render() ?>
                        </div>

                        <div id="tabs-2">
                            <table class="table table-bordered">
                                <tr>
                                    <th rowspan="2" cellpadding="2px">#</th>
                                    <th rowspan="2">Order Time</th>
                                    <th rowspan="2">Waiter</th>
                                    <th rowspan="2">Table No</th>
                                    <th colspan="5" class="order">Order Detail</th>
                                    <th rowspan="2">Order Type</th>
                                    <th rowspan="2">Status</th>
                                    <th rowspan="2">Payment</th>

                                </tr>

                                <tr>
                                    <td> Item </td>
                                    <td> Price </td>
                                    <td> Qty </td>
                                    <td> Exception </td>
                                    <td> Extra </td>
                                </tr>
                                @foreach($doneorder as $done)
                                    <tr>
                                        <td>{{ $done->order_id }}</td>
                                        <td>{{ $done->order_time }}</td>
                                        <td>
                                            @foreach($user as $users)
                                                <?php
                                                if($users->id === $done->user_id)
                                                {
                                                    echo $users->user_name;
                                                }
                                                ?>
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach($table as $tables)
                                                <?php
                                                if($tables->id === $done->table_id)
                                                {
                                                    echo $tables->table_no;
                                                }
                                                ?>
                                            @endforeach
                                        </td>
                                        <td>{{ $done->name }}</td>
                                        <td>{{$done->price}}</td>
                                        <td>{{ $done->quantity }}</td>
                                        <td>{{$done->exception}}</td>
                                        <td>
                                            @if(isset($done->extra))
                                               {{ $done->extra_food }}
                                            @endif
                                        </td>
                                        <td>
                                            @foreach($order_type as $ordertype)
                                                <?php
                                                if($done->order_type_id === $ordertype->id)
                                                {
                                                    echo $ordertype->type;
                                                }
                                                ?>
                                            @endforeach
                                        </td>
                                        <td>{{$done->stname}}</td>

                                        <td>{{ $done->amount + $done->extra_price }}</td>

                                @endforeach
                            </table>
                        </div>
                        <div id="tabs-3">
                            <table class="table table-bordered">
                                <tr>
                                    <th rowspan="2" cellpadding="2px">#</th>
                                    <th rowspan="2">Order Time</th>
                                    <th rowspan="2">Waiter</th>
                                    <th rowspan="2">Table No</th>
                                    <th colspan="5" class="order">Order Detail</th>
                                    <th rowspan="2">Order Type</th>
                                    <th rowspan="2">Status</th>
                                    <th rowspan="2">Payment</th>

                                </tr>

                                <tr>
                                    <td> Item </td>
                                    <td> Price </td>
                                    <td> Qty </td>
                                    <td> Exception </td>
                                    <td> Extra </td>
                                </tr>
                                @foreach($deliorder as $done)
                                    <tr>
                                        <td>{{ $done->order_id }}</td>
                                        <td>{{ $done->order_time }}</td>
                                        <td>
                                            @foreach($user as $users)
                                                <?php
                                                if($users->id === $done->user_id)
                                                {
                                                    echo $users->user_name;
                                                }
                                                ?>
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach($table as $tables)
                                                <?php
                                                if($tables->id === $done->table_id)
                                                {
                                                    echo $tables->table_no;
                                                }
                                                ?>
                                            @endforeach
                                        </td>
                                        <td>{{ $done->name }}</td>
                                        <td>{{$done->price}}</td>
                                        <td>{{ $done->quantity }}</td>
                                        <td>{{$done->exception}}</td>
                                        <td>
                                            @if(isset($done->extra))
                                                {{ $done->extra_food }}
                                            @endif
                                        </td>
                                        <td>
                                            @foreach($order_type as $ordertype)
                                                <?php
                                                if($done->order_type_id === $ordertype->id)
                                                {
                                                    echo $ordertype->type;
                                                }
                                                ?>
                                            @endforeach
                                        </td>
                                        <td>{{ $done->stname }}</td>
                                        <td>{{ $done->amount + $done->extra_price }}</td>

                                @endforeach
                            </table>
                        </div>
                        </div>
                    </div>
                    </tbody>
            </div>
        </div>
    </div>
@endsection

