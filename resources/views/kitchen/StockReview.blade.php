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
                          <h4>ပြဲေရလက္က်န္</h4><br>
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
              $labels[] = str_replace('"', '', $remain_stock->StockName);
          }
        }
    @endphp

    <script type="text/javascript">
      var labels   = [<?php echo '"'.(implode('","', $labels)).'"'; ?>];
      var data     = [<?php echo '"'.(implode('","', $data)).'"'; ?>];
      const colors = data.map((value) => value <= 10 ? 'rgba(255, 99, 132, 0.2)' : 'rgba(75, 192, 192, 0.2)');
      const border_colors = data.map((value) => value <= 10 ? 'rgb(255, 99, 132)' : 'rgb(75, 192, 192)');
      new Chart(document.getElementById("horizontalBar"), {
        "type": "horizontalBar",
        "data": {
          "labels": labels,
          "datasets": [{
            "data": data,
            "fill": false,
            "backgroundColor": colors,
            "borderColor": border_colors,
            "borderWidth": 1
          }]
        },
        "options": {
            "tooltips": {
              "displayColors": false
            },
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
