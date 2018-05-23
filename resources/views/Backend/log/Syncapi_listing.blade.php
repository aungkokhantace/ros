@extends('Backend.layouts.master')
@section('title','Api Listing')
@section('content')
 <div class="content-wrapper">
      <div class="box">
       <div class="box-header">
    <div class="row">
        
            <div class="col-md-12">
                <ul class="nav nav-tabs">
                    <li role="presentation" class="active"><a href="#">Sync Api</a></li>
                    <li role="presentation"><a href="/Backend/MakeApi">Make Api</a></li>
                    <li role="presentation"><a href="/Backend/DownloadApi">Download Api</a></li>
                </ul>
            </div>
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
                    @include('Backend.log.SynRoutApi')
                </div><hr><!-- End Row-->

                
            </div>
        </div>
    </div>
</div>
@endsection
