@extends('kitchen.kitchen_header')
@section('title', 'Stock Requisition Form')
@section('content')
    <div id="body">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-1"></div>
                        <div class="col-lg-7">
                            <div class="form-div">
                                <form action="{{ url('/Kitchen/stock-requisition') }}" method="post">
                                    {{ csrf_field() }}
                                    <h4><b>Stock Requisition Form</b></h4><br>
                                    <div class="clone-div">
                                        <div class="bg-div form-block" id="clone0">
                                            <span id="remove1" onclick="remove(this)"><i class="fa fa-times"></i></span>
                                            <div class="form-group row first-div">
                                                <label for="group-type" class="col-sm-3 col-form-label">Raw Group Type</label>
                                                <div class="col-sm-8">
                                                    <select class="form-control" name="stock[0][group].group" id="group-type">
                                                        @foreach($raw_group_responses as $raw_group_response)
                                                            <option value="{{ $raw_group_response->Id }}">{{ $raw_group_response->Raw_group_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="item" class="col-sm-3 col-form-label">Raw Item</label>
                                                <div class="col-sm-8">
                                                    <select class="form-control" name="stock[0][StockId].stick_id" id="item">
                                                        @foreach($raw_stock_responses as $raw_stock_response)
                                                            <option value="{{ $raw_stock_response->Id }}">{{ $raw_stock_response->Raw_item_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="quantity" class="col-sm-3 col-form-label">Quantity</label>
                                                <div class="col-sm-8">
                                                    <input type="number" class="form-control"  name="stock[0][Quantity].quantity" placeholder="Quantity" id="quantity"/>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="unit" class="col-sm-3 col-form-label">Measurement Units</label>
                                                <div class="col-sm-8">
                                                    <select class="form-control" name="stock[0][unit].unit" id="unit">
                                                        @foreach($measurement_unit_responses as $measurement_unit_response)
                                                            <option value="{{ $measurement_unit_response->Id }}">{{ $measurement_unit_response->Code }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row" id="beforeDiv">
                                        <label for="inputEmail3" class="col-sm-3 col-form-label"></label>
                                        <div class="col-sm-8">
                                            <div class="btn-group mr-2" role="group">
                                                <button type="button" class="btn btn-dark add-more-btn">Add New</button>
                                            </div>
                                            <div class="btn-group" role="group">
                                                <input type="submit" class="btn btn-success" value="Submit">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-lg-4"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script type="text/javascript">
        var i = 0;
        var w = 1;
        var original = document.getElementById('clone' + i);
        var before = document.getElementById('beforeDiv');
        var display = document.getElementById('remove' + w);

        $('.add-more-btn').on('click', function () {
            var clone = $('.form-block:first').clone().appendTo('.clone-div');
            display.id = "remove" + ++w;
            original.id = "clone" + ++i;
            clone.find('input').each(function () {
                this.name = this.name.replace('[0]', '[' + w + ']');
            });
            clone.find('select').each(function () {
                this.name = this.name.replace('[0]', '[' + w + ']');
            });
            $("#remove" + i).css('display', 'block');

            $('.form-block').append(clone);
        });

        function remove(data) {
            var parent = data.parentNode;
            var element = document.getElementById(parent.id);
            element.parentNode.removeChild(element);
        }
    </script>
@endsection