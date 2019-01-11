@extends('Backend.layouts.master')
@section('title','Dashboard')
@section('content')
<head>
  <style type="text/css">
      .header-box {
        color: #444;
        display: block;
        padding: 5px 0 0 0;
        position: relative
      }
      .header-box h3 {
        font-weight: bolder;
      }
      hr {
        display: block;
        height: 1px;
        border: 0;
        border-top: 1px solid #ccc;
        margin: 1em 0;
        padding: 0;
      }
      .log {
        border: 0 !important;
        background: #222d32;
        border-radius: 4px;
        height: 45px;
      }
      .body {
        min-height: 400px;
      }
      .body .col-lg-12 {
        margin-bottom: 10px;
      }
      .icon .fa {
        cursor: pointer;
        margin: 15px 10px 0 0;
        float: right;
        color: white;
      }
      .date {
        float: left;
        color: white;
        font-weight: bolder;
        margin: 11px 0 0 10px;
      }
      .fa-minus-square {
        display: none;
      }
      .log-detail {
        padding: 30px 30px 10px 30px;
        background: white;
        border-radius: 0 0 4px 4px;
      }
      table {
        color: white;
      }
      thead th {
        margin-top: 40px;
        background: #696969;
        border-radius: 7px 7px 0 0;
      }
      #log_detail {
        display: none;
      }
  </style>
</head>
<div class="content-wrapper">
  <div class="header-box">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
            <h3>Activity Log</h3><hr>
        </div>
      </div>
    </div>
  </div>
  <div class="container body">
    <div class="row">
      @foreach ($logs as $key => $log)
      <div class="col-lg-12">
        <div class="log" id="{{ $key }}-id-pos">
            <span class="date">
              <b>{{ $key }}</b>
            </span>
            <span class="icon">
              <a class="fa fa-plus-square" data-toggle="collapse" href="#{{ $key }}" id="{{ $key }}-id" role="button" aria-expanded="false" aria-controls="collapseExample"></a>
              <a class="fa fa-minus-square" data-toggle="collapse" href="#{{ $key }}" id="{{ $key }}-id-icon" role="button" aria-expanded="false" aria-controls="collapseExample"></a>
            </span>
        </div>
        <div class="log-detail bordered collapse" id="{{ $key }}">
          <div class="card card-body">
              <table class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th scope="col">{{ $key }} Activities</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($log as $value)
                  <tr>
                    <td scope="row">{{ $value }}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
  </div>
</div>
<script>
  $('.container .fa-plus-square').click(function(){
    var target = $(this).attr("id") + '-pos';
    var icon = $(this).attr("id") + '-icon';
    var id = $(this).attr("id");
    document.getElementById(target).style.borderBottomLeftRadius = 0;
    document.getElementById(target).style.borderBottomRightRadius = 0;
    document.getElementById(icon).style.display = "block";
    document.getElementById(id).style.display = "none";
  });

  $('.container .fa-minus-square').click(function(){
    var target = $(this).attr("id").replace('-icon', '');
    var id = $(this).attr("id");
    var log = target + '-pos';
    document.getElementById(target).style.display = "block";
    document.getElementById(id).style.display = "none";
    document.getElementById(log).style.borderBottomLeftRadius = "4px";
    document.getElementById(log).style.borderBottomRightRadius = "4px";
  });
</script>
@endsection
