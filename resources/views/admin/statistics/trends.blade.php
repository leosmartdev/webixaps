
@extends('layouts/contentLayoutMaster')

@section('title', 'Trends')

@section('vendor-style')
        {{-- Vendor Css files --}}
        <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/datatables.min.css')) }}">
        <link rel="stylesheet" href="{{ asset(mix('vendors/css/charts/apexcharts.css')) }}">
@endsection
@section('page-style')
<style>
td.green {
    background: #e5fee6;
}
td.red {
    background: #ffe6e6;
}
#click-events tbody tr:hover td {
    background: #b6f56e !important;
}
</style>
@endsection

@section('content')


  <!-- Complex headers table -->
  <section id="headers">
    <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
                <h1 class="text-bold-600"> Recorded Revenue by Time </h1>
            </div>
            <div class="card-content">
              <div class="card-body">
                <div id="heat-map-chart-2"></div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-header">
                            <h1 class="text-bold-600"> Top 50 Campaign Long Performance by Revenue </h1>

                        </div>
                        <div class="card-body card-dashboard">
                            <ul class="nav nav-pills">
                                <li class="nav-item">
                                  <a class="nav-link active" id="table-tab" href="/admin/statistics/trends" aria-expanded="true">Revenue</a>
                                </li>
                                <li class="nav-item">
                                  <a class="nav-link" id="table-tab" href="/admin/statistics/trends/epc" aria-expanded="true">Earnings Per Click</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="table-tab" href="/admin/statistics/trends/clicks" aria-expanded="true">Clicks</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="table-tab" href="/admin/statistics/trends/conversions" aria-expanded="true">Conversions</a>
                                  </li>
                            </ul>
                            <table id="click-events" class="table table-striped table-bordered">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Campaign Name</th>
                                        @foreach($months as $month)
                                            <th> {{ $month }} </th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($final_statistics as $c_name => $statistic)
                                    <tr>
                                        <td> {{ $c_name}} </td>
                                        @php $reverse_month = array_reverse($statistic); @endphp
                                        @foreach($reverse_month as $month)
                                            <td class="{{ ($month)?'green':'red' }}"> {{ ($month)?number_format($month, 2):0 }} </td>
                                        @endforeach
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="thead-light">
                                    <tr>
                                        <th>Campaign Name</th>
                                        @foreach($months as $month)
                                            <th> {{ $month }} </th>
                                        @endforeach
                                    </tr>
                                </tfoot>
                            </table>
               

                        </div>

        
                        </div>
                    </div>
                </div>
          </div>
      </div>
  </section>
  <!--/ Complex headers table -->

  <!--/ Scroll - horizontal and vertical table -->
@endsection
@section('vendor-script')
{{-- Vendor js files --}}
<script src="{{ asset(mix('vendors/js/tables/datatable/datatables.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/datatables.bootstrap4.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/charts/apexcharts.min.js')) }}"></script>
@endsection
@section('page-script')
{{-- Page js files --}}

        <script>
            $(document).ready(function() {

                $('#click-events').DataTable( {
                    "lengthMenu": [[50, 100, 500, -1], [50, 100, 500, "All"]],
                    "order": []
                });
                var yaxis_opposite = false;
                if($('html').data('textdirection') == 'rtl'){
                        yaxis_opposite = true;
                }
                  // Heat Map Chart
                // -----------------------------
                function generateData(count, yrange) {
                    var i = 0,
                    series = [];
                    while (i < count) {
                    var x = 'D' + (i + 1).toString(),
                        y = Math.floor(Math.random() * (yrange.max - yrange.min + 1)) + yrange.min;

                    series.push({
                        x: x,
                        y: y
                    });
                    i++;
                    }
                    return series;
                }
/*
                var heatChartOptions = {
                    chart: {
                    height: 450,
                    type: 'heatmap',
                    },
                    dataLabels: {
                    enabled: false
                    },
                    colors: ["#00cfe8"],
                    series: [{
                    name: 'Metric1',
                    data: generateData(7, {
                        min: 0,
                        max: 90
                    })
                    },
                    {
                    name: 'Metric2',
                    data: generateData(7, {
                        min: 0,
                        max: 90
                    })
                    },
                    {
                    name: 'Metric3',
                    data: generateData(7, {
                        min: 0,
                        max: 90
                    })
                    },
                    {
                    name: 'Metric4',
                    data: generateData(7, {
                        min: 0,
                        max: 90
                    })
                    },
                    {
                    name: 'Metric5',
                    data: generateData(7, {
                        min: 0,
                        max: 90
                    })
                    },
                    {
                    name: 'Metric6',
                    data: generateData(7, {
                        min: 0,
                        max: 90
                    })
                    },
                    {
                    name: 'Metric7',
                    data: generateData(7, {
                        min: 0,
                        max: 90
                    })
                    },
                    {
                    name: 'Metric8',
                    data: generateData(7, {
                        min: 0,
                        max: 90
                    })
                    },
                    {
                    name: 'Metric9',
                    data: generateData(7, {
                        min: 0,
                        max: 90
                    })
                    }
                    ],
                    yaxis: {
                    opposite: yaxis_opposite
                    }
                }
*/
                var heatChartOptions = {
                    chart: {
                    height: 550,
                    type: 'heatmap',
                    },
                    dataLabels: {
                    enabled: false
                    },
                    colors: ["#00cfe8"],
                    series: [{
                    name: '00:00',
                    data: generateData(7, {
                        min: 0,
                        max: 90
                    })
                    },
                    {
                    name: '',
                    data: generateData(7, {
                        min: 0,
                        max: 90
                    })
                    },
                    {
                    name: '',
                    data: generateData(7, {
                        min: 0,
                        max: 90
                    })
                    },
                    {
                    name: '',
                    data: generateData(7, {
                        min: 0,
                        max: 90
                    })
                    },
                    {
                    name: '04:00',
                    data: generateData(7, {
                        min: 0,
                        max: 90
                    })
                    },
                    {
                    name: '',
                    data: generateData(7, {
                        min: 0,
                        max: 90
                    })
                    },
                    {
                    name: '',
                    data: generateData(7, {
                        min: 0,
                        max: 90
                    })
                    },
                    {
                    name: '',
                    data: generateData(7, {
                        min: 0,
                        max: 90
                    })
                    },
                    {
                    name: '08:00',
                    data: generateData(7, {
                        min: 0,
                        max: 90
                    })
                    },
                    {
                    name: '',
                    data: generateData(7, {
                        min: 0,
                        max: 90
                    })
                    },
                    {
                    name: '',
                    data: generateData(7, {
                        min: 0,
                        max: 90
                    })
                    },
                    {
                    name: '',
                    data: generateData(7, {
                        min: 0,
                        max: 90
                    })
                    },
                    {
                    name: '12:00',
                    data: generateData(7, {
                        min: 0,
                        max: 90
                    })
                    },
                    {
                    name: '',
                    data: generateData(7, {
                        min: 0,
                        max: 90
                    })
                    },
                    {
                    name: '',
                    data: generateData(7, {
                        min: 0,
                        max: 90
                    })
                    },
                    {
                    name: '',
                    data: generateData(7, {
                        min: 0,
                        max: 90
                    })
                    },
                    {
                    name: '16:00',
                    data: generateData(7, {
                        min: 0,
                        max: 90
                    })
                    },
                    {
                    name: '',
                    data: generateData(7, {
                        min: 0,
                        max: 90
                    })
                    },
                    {
                    name: '',
                    data: generateData(7, {
                        min: 0,
                        max: 90
                    })
                    },
                    {
                    name: '',
                    data: generateData(7, {
                        min: 0,
                        max: 90
                    })
                    },
                    {
                    name: '20:00',
                    data: generateData(7, {
                        min: 0,
                        max: 90
                    })
                    },
                    {
                    name: '',
                    data: generateData(7, {
                        min: 0,
                        max: 90
                    })
                    },
                    {
                    name: '',
                    data: generateData(7, {
                        min: 0,
                        max: 90
                    })
                    },
                    {
                    name: '',
                    data: generateData(7, {
                        min: 0,
                        max: 90
                    })
                    }
                    ],
                    yaxis: {
                    opposite: yaxis_opposite
                    }
                }
                var heatChart = new ApexCharts(
                    document.querySelector("#heat-map-chart-2"),
                    heatChartOptions);
                heatChart.render();
 
            } );
        </script>
@endsection
