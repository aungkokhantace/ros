@extends('cashier.layouts.master')
@section('title','Api Listing')
@section('content')
    <div class="row">
        <div class="container">
            <div class="col-md-12">
                <ul class="nav nav-tabs">
                    <li role="presentation"><a href="/Cashier/SyncApi">Sync Api</a></li>
                    <li role="presentation" class="active"><a href="#">Make Api</a></li>
                    <li role="presentation"><a href="/Cashier/DownloadApi">Download Api</a></li>
                </ul>
            </div>
            @if(count(Session::get('message')) != 0)
                <div>
                </div>
            @endif
        </div>
    </div><div style="height:20px;"></div>
    <div class="container">
    </div>
    {{--tables--}}
    <div class="container">
        <div class="row">
            <div class="col-md-10 tbl-container" id="booking-frame">
                <div class="row">
                    @include('cashier.log.MakeRoutApi')
                </div><hr><!-- End Row-->

                
            </div>
        </div>
    </div>

@endsection
