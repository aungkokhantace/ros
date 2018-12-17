@include('cashier.layouts.order.header')
<body>
    <div class="wrapper"> 
        <div class="container-fluid receipt category-pg">   
            <div class="row cmn-ttl cmn-ttl2">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-4 col-md-5 col-sm-6 col-6">
                            <h3>
                            @if(isset($order))
                                {{ $order['order_id'] }} - 
                                @if(count($tables) > 0)
                                    @foreach($tables as $table)
                                        {{ $table['table_no'] }}
                                    @endforeach
                                @elseif (count($rooms) > 0)
                                    @foreach($rooms as $room)
                                        {{ $room['room_name'] }}
                                    @endforeach
                                @else
                                    {{ "Take Away "}}
                                @endif
                            @else
                                Category
                            @endif
                            </h3>
                        </div>
                        <div class="col-lg-8 col-md-7 col-sm-6 col-6 receipt-btn">
                            <a href="{{ url()->previous() }}" class="btn"><img src="/assets/cashier/images/payment/previous_img.png" alt="Previous" class="heightLine_06"></a>
                            {{-- <button class="btn" onclick="returnBack()">          
                              <img src="/assets/cashier/images/payment/previous_img.png" alt="Previous" class="heightLine_06">     
                            </button> --}}
                         </div>
                    </div> 
                </div> 
            </div>

            <div class="row"> 
                <div class="container"> 
                    <div class="row">
                        <div class="col-md-9">
                            <div class="cat-table">
                                <div class="table-responsive">
                                    <button onclick="scrollBottom2()" class="scroll-txt cat-to-btm2"><i class="fas fa-angle-double-down"></i></button>
                                    @if(isset($order))

                                        {!! Form::open(array('url' => '/Cashier/MakeOrder/update', 'method' => 'post','class'=> 'form-horizontal', 'id' => 'order-form')) !!}
                                    @else
                                        {!! Form::open(array('url' => '/Cashier/MakeOrder/store', 'method' => 'post','class'=> 'form-horizontal', 'id' => 'order-form')) !!}
                                    @endif
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <table class="table table-hover item-list">
                                            <thead>
                                                <tr>
                                                    <th>Item Name</th>
                                                    <th>Quantity</th>
                                                    <th>Price</th>
                                                    <th>Discount</th>
                                                    <th>Extra</th>
                                                    <th>Extra Price</th>
                                                    <th>Amount</th>
                                                    <th>Take Away</th>
                                                    <th>Cancel</th>
                                                </tr>
                                            </thead>
                                            <tbody id="cat-table-body">
                                                @if(isset($order))
                                                    @include('cashier.orderlist.item_edit')
                                                @endif
                                            </tbody>
                                        </table>

                                    <input type="hidden" name="day_id" value="{{isset($order)? $order['day_id']:$day_id}}">
                                    <input type="hidden" name="shift_id" value="{{isset($order)? $order['shift_id']:$shift_id}}">
                                    <input type="hidden" name="take_id" value="{{ isset($order)? $order['take_id']:$take_id }}" id="take-id"/>

                                    <input type="hidden" name="price_total" value="{{ isset($order)? $order['all_total_amount']:'' }}" id="price_total">
                                    <input type="hidden" name="service" value="{{ isset($order)? $order['service_amount']:'0' }}" id="service-amount">
                                    <input type="hidden" name="tax" value="{{ isset($order)? $order['tax_amount']:'0' }}" id="tax-amount">

                                    @if(isset($order))
                                        <input type="hidden" name="order_id" value="{{ $order['order_id'] }}">
                                        <input type="hidden" name="room_charge" value="{{ $order['room_charge'] }}" id="room-amount">
                                    @else
                                        <input type="hidden" name="tables" value="{{ $tables }}">
                                        <input type="hidden" name="rooms" value="{{ $rooms }}">
                                        <input type="hidden" name="room_charge" value="{{ ($rooms !== '')? $config->room_charge: 0 }}" id="room-amount">
                                    @endif
                                    <input type="hidden" value="{{ $config->tax }}" class="tax">
                                    <input type="hidden" value="{{ $config->service }}" class="service">
                                    {!! Form::close() !!}

                                    <button onclick="scrollFromTop2()" class="scroll-txt cat-to-top2" type="button"><i class="fas fa-angle-double-up"></i></button>
                                </div><!-- category table -->
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="price-table">
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td colspan="2" rowspan="5" class="order-btn-gp">
                                                        <a href="{{ url()->previous() }}" class="btn order-btn"><img src="/assets/cashier/images/payment/previous_img.png" alt="Previous" class="heightLine_06 mt-5"></a>
                                                        {{-- <button class="order-btn" onclick="returnBack()"><img src="/assets/cashier/images/payment/previous_img.png" alt="Previous" class="heightLine_06"></button> --}}
                                                        <button class="order-btn" id="order-item">Send Order</button>
                                                    </td>
                                                    <td>Sub Total : </td>
                                                    <td id="sub-total">{{ isset($order)? $order['total_price']:'' }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Tax (GST) : </td>
                                                    <td id="sub-gst">{{ isset($order)? $order['tax_amount']:'' }} </td>
                                                </tr>
                                                <tr>
                                                    <td>Tax (Service) : </td>
                                                    <td id="sub-service"> {{ isset($order)? $order['service_amount']:'' }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Room Charge : </td>
                                                    <td id="sub-room"> {{ isset($order)? $order['room_charge']:'' }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Net Amount : </td>
                                                    <td id="price-total">{{ isset($order)? $order['all_total_amount']:'' }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>                 
                                </div>
                            </div>
                        </div> <!-- col-md-9 -->

                        <div class="col-md-3">
                            <div class="row category"> 
                                <div class="col-md-12 list-group" id="myList" role="tablist">
                                    <a class="list-group-item list-group-item-action heightLine_05 active cat" data-toggle="list" href="#home" role="tab" id="cat" onclick="getCategories(0)">
                                      <span class="receipt-type cash-img"></span><span class="receipt-txt">Category</span>
                                    </a>
                                    <a class="list-group-item list-group-item-action heightLine_05 cat" data-toggle="list" href="#profile" role="tab" id="set" onclick="getSetMenu()">
                                      <span class="receipt-type card-img"></span><span class="receipt-txt">Set Menu</span>
                                    </a>
                                </div> <!-- list-group -->
                                <div class="col-md-12 cat-list" id="cathome">
                                    <div class="cat-ttl">
                                        <button onclick="backBtn()" class="backBtn" id=""><i class="fas fa-angle-left"></i></button>
                                        <input type="hidden" value="0" class="cat-back">
                                        <input type="hidden" value="0" class="set-back">
                                    </div>

                                    <div class="tab-content row" id="cat-tab-content"> 
                                       <!--  <button onclick="scrollBottom()" class="scroll-txt cat-to-btm"><i class="fas fa-angle-double-down"></i></button> -->
                                        <div class="tab-pane active clearfix" id="categoryDiv" role="tabpanel">

                                        </div>

                                        <div class="tab-pane" id="setDiv" role="tabpanel">
                                            <h1>hihi</h1>
                                        </div>
                                        <button onclick="scrollFromTop()" class="scroll-txt cat-to-top"><i class="fas fa-angle-double-up"></i></button>
                                    </div> <!-- tab-content -->
                                </div>
                            </div> <!-- row -->     
                        </div> <!-- col-md-3 -->
                    </div><!-- row -->
                </div> <!-- container -->
            </div>
        </div><!-- container-fluid -->
    </div><!-- wrapper -->
    <script type="text/javascript">
        function cancelBtn(order_key,uniqid_key) {
            var itemCount   = parseInt($('.item-list tbody tr').length);
            if (itemCount <= 1) {
                 swal({
                    title: "Item Unable to cancel!",
                    text: "You can not delete all item.",
                    type: "info",
                    showCancelButton: false,
                    confirmButtonColor: "#86CCEB",
                    confirmButtonText: "Confirm",
                    closeOnConfirm: false
                });
            } else {
                //Cancel Order ID
                var dataString = { 
                      _token            : '{{ csrf_token() }}',
                      order_detail_id   : order_key
                };
                console.log(dataString);
                $.ajax({
                    url     : '/Cashier/MakeOrder/order_detail/delete',
                    type    : 'POST',
                    data    : dataString,
                    dataType: "json",
                    success: function(data) {
                        if (data = "success") {
                            console.log(data);
                            $('#item-tr-' + uniqid_key).remove();
                            calculateTotal();
                        }
                    },
                    error: function(data) {
                        console.log(data);    
                    }
                });
            }
        }
    </script>
@include('cashier.layouts.order.footer')