@extends('kitchen.kitchen_header')
@section('title', 'Stock Review')
@section('content')
    <div id="body">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                      <div class="col-lg-1"></div>
                      <div class="col-lg-8">
                        <div class="form-div">
                          <h4><b>Finished Good Stock Review</b></h4><br>
                          <canvas id="horizontalBar"></canvas>
                        </div>
                      </div>
                      <div class="col-lg-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @php
        $data = [];
        $labels = [];
        if (!empty($remain_stocks)) {
          foreach ($remain_stocks as $remain_stock) {
              $data[] = $remain_stock->CurrentBalance;
              $labels[] = "$remain_stock->Name";
          }
        }
    @endphp

    <script type="text/javascript">
      var labels = [<?php echo '"'.(implode('","', $labels)).'"'; ?>];
      var data   = [<?php echo '"'.(implode('","', $data)).'"'; ?>];
      new Chart(document.getElementById("horizontalBar"), {
        "type": "horizontalBar",
        "data": {
          "labels": labels,
          "datasets": [{
            "data": data,
            "fill": false,
            "backgroundColor": ["rgba(255, 99, 132, 0.2)", "rgba(255, 159, 64, 0.2)",
              "rgba(255, 205, 86, 0.2)", "rgba(75, 192, 192, 0.2)", "rgba(54, 162, 235, 0.2)",
              "rgba(153, 102, 255, 0.2)", "rgba(201, 203, 207, 0.2)"
            ],
            "borderColor": ["rgb(255, 99, 132)", "rgb(255, 159, 64)", "rgb(255, 205, 86)",
              "rgb(75, 192, 192)", "rgb(54, 162, 235)", "rgb(153, 102, 255)", "rgb(201, 203, 207)"
            ],
            "borderWidth": 1
          }]
        },
        "options": {
            "legend": {
              "display" : false,
            },
            "scales": {
              "xAxes": [
                {
                  "ticks": {
                  "beginAtZero": true,
                  "fontStyle": "bolder",
                  "fontColor": "black"
                  }
                }
              ],
              "yAxes": [
                {
                  "ticks": {
                    "fontStyle": "bolder",
                    "fontColor": "black"
                  }
                }
              ]
            }
          }
        });
</script>
@endsection
