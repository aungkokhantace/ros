@extends('Backend.layouts.kitchen.master')
@section('title', 'Stock Requisition Form')
@section('content')
    <div id="body">
        <div class="container stock">
            <div class="row">
                <div class="col-lg-2"></div>
                <div class="col-lg-10">
                        <form action="{{ url('/Kitchen/stock-requisition') }}" method="post">
                            {{ csrf_field() }}
                            <h4><b>Stock Requisition Form</b></h4><br>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Raw Group Type</label>
                                <div class="col-sm-5">
                                    <select class="form-control" name="raw-group">
                                        <option></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Raw Item</label>
                                <div class="col-sm-5">
                                    <select class="form-control" name="raw-item">
                                        <option></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Quantity</label>
                                <div class="col-sm-5">
                                    <select class="form-control" name="quantity">
                                        <option></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Measurement Units</label>
                                <div class="col-sm-5">
                                    <select class="form-control" name="unit">
                                        <option></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-5">
                                    <button type="submit" class="btn btn-success col-sm-4">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection