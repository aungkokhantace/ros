
@extends('cashier.layouts.master')
@section('title','Dashboard')
@section('content')

    <section class="content">
        <div class="row">
            <div class="col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-aqua"><i class="ion ion-pizza"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Category</span>
                        <span class="info-box-number">{{ $category }}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
            </div>
            <div class="col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-red"><i class="fa ion-icecream"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Total Items</span>
                        <span class="info-box-number">{{ $item }}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
            </div>
            <div class="col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="ion ion-coffee"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Set-Menu</span>
                        <span class="info-box-number">{{ $set }}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
            </div>
            <div class="col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Members</span>
                        <span class="info-box-number">{{ $member }}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
            </div>
            <div class="col-md-6">
                <div id="chartdiv"></div>
                <p class="text-danger" style="text-align:center">Monthly Sale Report</p>
            </div>

            <div class="col-md-6">
                <div id="daily_chart_div"></div>
                <p class="text-danger" style="text-align:center">Daily Sale Report</p>
            </div>

        </div>
    </section>

    <script type="text/javascript">
    $(document).ready(function(){
        var chart;
        var chartData =<?php echo json_encode($orders) ?> ;
        var chart = AmCharts.makeChart( "chartdiv", {
            "theme": "light",
            type: "serial",
            dataProvider: chartData,
            categoryField: "month",
            depth3D: 20,
            angle: 30,
            categoryAxis: {
                labelRotation: 0,
                gridPosition: "start"
            },
            valueAxes: [ {
                title: "Total Amount"
            } ],
            graphs: [ {
                valueField: "total",
                colorField: "color",
                type: "column",
                lineAlpha: 0.1,
                fillAlphas: 1
            } ],
            chartCursor: {
                cursorAlpha: 0,
                zoomable: false,
                categoryBalloonEnabled: false
            },
            export: {
                enabled: true
            }
        } );
    })
    </script>

    <script>
        $(document).ready(function(){
            var chart = AmCharts.makeChart("daily_chart_div", {
                "theme": "light",
                "type": "serial",
                "startDuration": 2,
                "dataProvider":<?php echo json_encode($daily_order)?> ,
                "valueAxes": [{
                    "position": "left",
                    "axisAlpha":0,
                    "gridAlpha":0
                }],
                "graphs": [{
                    "balloonText": "[[category]]: <b>[[value]]</b>",
                    "colorField": "color",
                    "fillAlphas": 0.85,
                    "lineAlpha": 0.1,
                    "type": "column",
                    "topRadius":1,
                    "valueField": "total"
                }],
                "depth3D": 40,
                "angle": 30,
                "chartCursor": {
                    "categoryBalloonEnabled": false,
                    "cursorAlpha": 0,
                    "zoomable": false
                },
                "categoryField": "date",
                "categoryAxis": {
                    "gridPosition": "start",
                    "axisAlpha":0,
                    "gridAlpha":0

                },
                "export": {
                    "enabled": true
                }

            },0);

            jQuery('.chart-input').off().on('input change',function() {
                var property	= jQuery(this).data('property');
                var target		= chart;
                chart.startDuration = 0;

                if ( property == 'topRadius') {
                    target = chart.graphs[0];
                }

                target[property] = this.value;
                chart.validateNow();
            });

        })
    </script>

@endsection
