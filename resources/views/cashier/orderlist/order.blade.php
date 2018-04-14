@include('cashier.layouts.order.header')
<body>
    <div class="wrapper"> 
        <div class="container-fluid receipt category-pg">   
            <div class="row cmn-ttl cmn-ttl2">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-4 col-md-5 col-sm-6 col-6">
                            <h3>Category</h3>
                        </div>
                        <div class="col-lg-8 col-md-7 col-sm-6 col-6 receipt-btn">
                            <button class="btn">              
                              <img src="/assets/cashier/images/payment/previous_img.png" alt="Previous" class="heightLine_06">     
                            </button>
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
                                    {!! Form::open(array('url' => '/Cashier/MakeOrder/store', 'method' => 'post','class'=> 'form-horizontal', 'id' => 'order-form')) !!}
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
                                                
                                            </tbody>
                                        </table>
                                    <input type="hidden" name="day_id" value="{{ $day_id }}">
                                    <input type="hidden" name="shift_id" value="{{ $shift_id }}">
                                    <input type="hidden" name="take_id" value="{{ $take_id }}" />

                                    <input type="hidden" name="price_total" value="" id="price_total">
                                    <input type="hidden" name="service" value="0" id="service-amount">
                                    <input type="hidden" name="tax" value="0" id="tax-amount">
                                    <input type="hidden" name="room" value="0" id="room-amount">

                                    <input type="hidden" value="{{ $config->tax }}" class="tax">
                                    <input type="hidden" value="{{ $config->service }}" class="service">
                                    <input type="hidden" value="{{ $config->room }}" class="room">
                                    {!! Form::close() !!}

                                    <button onclick="scrollFromTop2()" class="scroll-txt cat-to-top2"><i class="fas fa-angle-double-up"></i></button>
                                </div><!-- category table -->
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="price-table">
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td colspan="2" rowspan="5" class="order-btn-gp">
                                                        <button class="order-btn"><img src="/assets/cashier/images/payment/previous_img.png" alt="Previous" class="heightLine_06">     </button>
                                                        <button class="order-btn" id="order-item">Send Order</button>
                                                    </td>
                                                    <td>Sub Total : </td>
                                                    <td id="sub-total"></td>
                                                </tr>
                                                <tr>
                                                    <td>Tax (GST) : </td>
                                                    <td id="sub-gst"> </td>
                                                </tr>
                                                <tr>
                                                    <td>Tax (Service) : </td>
                                                    <td id="sub-service"> </td>
                                                </tr>
                                                <tr>
                                                    <td>Net Amount : </td>
                                                    <td id="price-total"></td>
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
                                      <span class="receipt-type card-img"></span><span class="receipt-txt">Sub Menu</span>
                                    </a>
                                </div> <!-- list-group -->
                                <div class="col-md-12 cat-list" id="cathome">
                                    <div class="cat-ttl">
                                        <button onclick="backBtn()" class="backBtn" id=""><i class="fas fa-angle-left"></i></button>
                                        <input type="hidden" value="0" class="cat-back">
                                        <input type="hidden" value="0" class="set-back">
                                    </div>

                                    <div class="tab-content row" id="cat-tab-content"> 
                                        <button onclick="scrollBottom()" class="scroll-txt cat-to-btm"><i class="fas fa-angle-double-down"></i></button>
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
@include('cashier.layouts.order.footer')