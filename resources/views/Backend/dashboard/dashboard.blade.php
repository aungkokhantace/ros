
@extends('Backend.layouts.master')
@section('title','Dashboard')
@section('content')
<div class="content-wrapper">
    
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-xs-6 ">
          <!-- small box -->
          <div class="small-box bg-aqua dashboard_shadow">
            <div class="inner">
              <h3>{{ $category }}</h3>

              <p>TOTAL CATEGORY</p>
            </div>
            <div class="icon">
             <i class="fa fa-align-justify"></i>
            </div>
            <a href="/Backend/Category/index" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6 ">
          <!-- small box -->
          <div class="small-box bg-green dashboard_shadow">
            <div class="inner">
              <h3>{{ $item }}</h3>

              <p>TOTAL ITEMS</p>
            </div>
            <div class="icon">
            <i class="fa fa-reddit-alien"></i>
            </div>
            <a href="/Backend/Item/index" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6 ">
          <!-- small box -->
          <div class="small-box bg-yellow dashboard_shadow">
            <div class="inner">
              <h3>{{ $set }}</h3>

              <p>TOTAL SET-MENU</p>
            </div>
            <div class="icon">
             <i class="fa fa-envira"></i>
            </div>
            <a href="/Backend/SetMenu/index" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red dashboard_shadow">
            <div class="inner">
              <h3>{{ $member }}</h3>

              <p>TOTAL MEMBERS</p>
            </div>
            <div class="icon">
              <i class="fa fa-group"></i>
            </div>
            <a href="" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

         <div class="col-md-6 ">
            <canvas id="myChart" width="400" height="400"></canvas>  
         </div>

         <div class="col-md-6 ">
            <canvas id="my_dev_Chart" width="400" height="400"></canvas>  
         </div>
        <!-- ./col -->
      </div>
   
    

            


    </div>
</div>
    <!-- /.content -->
  </div>
@php
    $label_arr  = array();
    foreach($orders as $order) {
        $label          = $order->month;
        $label_arr[]    = $label;
    }

     $data_arr  = array();
    foreach($orders as $order) {
        $data          = $order->total;
        $data_arr[]    = $data;
    }

    $daily_date_arr  = array();
    foreach($daily_order as $daily_orders) {
        $daily_date         = $daily_orders->date;
        $daily_date_arr[]    =  $daily_date ;
    }
    $daily_data_arr  = array();
    foreach($daily_order as $daily_orders) {
        $daily_data         = $daily_orders->total;
        $daily_data_arr[]    =  $daily_data ;
    }
@endphp
<script>
var ctx = document.getElementById("myChart").getContext("2d");

var myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?php echo json_encode($label_arr) ?>,
        datasets: [{
            label: 'Montly Sale Report',

            data: <?php echo json_encode($data_arr) ?>,
            backgroundColor: [
                '#00b160',
                
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});
</script>



<script>

var ctx = document.getElementById("my_dev_Chart").getContext("2d");

var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels:<?php echo json_encode($daily_date_arr) ?> ,
        datasets: [{
            label: 'Daily Sale Report',
            data: <?php echo json_encode($daily_data_arr) ?>,
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});
</script>


  @endsection