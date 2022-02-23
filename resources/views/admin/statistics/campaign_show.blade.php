
@extends('layouts/contentLayoutMaster')

@section('title', 'Campaign Statistics')

@section('vendor-style')
<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/datatables.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/charts/apexcharts.css')) }}">
@endsection

@section('content')

<section id="content-types">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-content collapse show">
                    <div class="card-body">
                        <div class="row match-height">
                            <div class="col-12 col-sm-6 col-lg-2">
                                <img src="/storage/campaign_logo/{{  $campaign->campaign_logo }}" alt="Campaign Logo" height="40" width="130">
                            </div>
                            <div class="col-12 col-sm-6 col-lg-2">
                                <h4 class="text-bold-600"> {{ $campaign_top['total_unique_clicks'] }} </h4>
                                <h6 class="pt-1"> Unique Clicks </h6>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-2">
                                <h4 class="text-bold-600"> {{ $campaign_top['total_non_unique_clicks'] }} </h4>
                                <h6 class="pt-1"> Non-Unique Clicks </h6>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-2">
                                <h4 class="text-bold-600"> {{ $campaign_top['total_postback'] }} </h4>
                                <h6 class="pt-1"> Postbacks </h6>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-2">
                                <h4 class="text-bold-600"> {{ number_format($campaign_top['total_payout'],2) }} {{ $campaign_top['currency'] }} </h4>
                                <h6 class="pt-1"> Total Payout </h6>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-2">
                              <h4 class="text-bold-600"> {{ number_format($campaign_top['epc'],2) }} {{ $campaign_top['currency'] }} </h4>
                              <h6 class="pt-1"> EPC </h6>
                          </div>
                        </div>

                    </div>
                    <div class="card-footer">
                        <small> Data collected based from filter below.</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
          <div class="card">
              <div class="card-header">
                <h4 class="card-title">Filters</h4>
                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                <div class="heading-elements">
                  <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="feather icon-chevron-down"></i></a></li>
                  </ul>
                </div>
              </div>
              <div class="card-content collapse show">
                <div class="card-body">
                  <div class="users-list-filter">
                    <form action="/admin/statistics/{{ $campaign->id }}">
                      <input type="hidden" name="filter" value="yes">
                      <div class="row">
                        <div class="col-12 col-sm-12 col-lg-4">
                            <label for="users-list-verified">Status</label>
                            <fieldset class="form-group">
                                <select class="form-control" name="campaign_id" id="users-list-role">
                                    <option value="All"> All </option>
                                    <option value="Accepted"> Accepted </option>
                                    <option value="Pending"> Pending </option>
                                </select>
                            </fieldset>
                        </div>
                        <div class="col-12 col-sm-12 col-lg-4">
                            <label for="users-list-verified">Period (From)</label>
                            <fieldset class="form-group">
                                <input type='text' value="{{ ($filter->has('period_from'))?$filter->get('period_from'):date('d F, Y') }}" id="period_from" name="period_from" class="form-control pickadate" />
                            </fieldset>
                        </div>
                        <div class="col-12 col-sm-12 col-lg-4">
                            <label for="users-list-department">Period (To)</label>
                            <fieldset class="form-group">
                                <input type='text' value="{{ ($filter->has('period_to'))?$filter->get('period_to'):date('d F, Y') }}" id="period_to" name="period_to" class="form-control pickadate" />
                            </fieldset>
                        </div>

                      </div>
                      <div class="row">
                          <div class="col-12">
                              <input type="submit" class="btn btn-primary float-right" value="Filter">
                          </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
          </div>
          <div class="card">
            <div class="card-content">
              <div class="card-header">
                <h1 class="text-bold-600"> {{ ($filter->has('period_from') && $filter->has('period_to'))?$filter->get('period_from') . " - " .$filter->get('period_to'). " Clicks":"Today's Clicks" }}</h1>

              </div>
                <div class="card-body card-dashboard">

                    <ul class="nav nav-pills">
                        <li class="nav-item">
                          <a class="nav-link active" id="table-tab" data-toggle="pill" href="#table" aria-expanded="true">Statistics Table</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="charts-tab" data-toggle="pill" href="#charts"
                            aria-expanded="false">Statistics Charts</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane  active" id="table" aria-labelledby="table-tab" aria-expanded="true">
                            <div class="table-responsive">
                              <table id="click-events" class="table table-striped table-bordereds" >
                                <thead class="thead-light">
                                    <tr>
                                        <th></th>
                                        <th colspan="4">Campaign</th>
                                        <th colspan="10">Postback Informations</th>
                                        <th> </th>
    
                                    </tr>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Country</th>
                                        <th>Feed Category</th>
                                        <th>Affiliate Network</th>
                                        <th>Type</th>
                                        <th>Source</th>
                                        <th>Medium</th>
                                        <th>Revenue</th>
                                        <th>Conversion Status</th>
                                        <th>Click Timestamp </th>
                                        <th>Conversion Timestamp </th>
                                        <th>OS </th>
                                        <th>Browser </th>
                                        <th>Device</th>
                                        <th>Location</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @foreach($click_events as $click_event)
                                  <tr style="cursor:pointer" href="{{ url('admin/click_events/'.$click_event->id) }}">
                                          <td> {{ $click_event->id }}</td>
                                          <td> {{ $click_event->campaign_id }}</td>
                                          <td> {{ $click_event->campaign_country }}</td>
                                          <td> {{ $click_event->campaign_feed_category }}</td>
                                          <td> {{ $click_event->campaign_affiliate_network }}</td>
                                          <td> {{ $click_event->click_type }}</td>
                                          <td> {{ $click_event->utm_content }}</td>
                                          <td> {{ $click_event->utm_medium }}</td>
                                          <td> {{ number_format($click_event->payout, 2) }}</td>
                                          <td> 
                                            @if($click_event->conversion_status != "Accepted")
                                              <div class="badge badge-warning badge-sm">Pending</div>
                                            @else
                                                <div class="badge badge-success badge-sm">Accepted</div>
                                            @endif
                                          </td>
                                          <td> {{ $click_event->created_at }}</td>
                                          <td> {{ $click_event->updated_at }}</td>
                                          <td> {{ $click_event->client_platform }}</td>
                                          <td> {{ $click_event->client_browser }}</td>
                                          <td> {{ $click_event->client_device }}</td>
                                          <td> {{ $click_event->client_city }}</td>
                                      </tr>
                                  @endforeach
                                </tbody>
                                <tfoot class="thead-light">
                                    <tr>
                                      <th>ID</th>
                                      <th>Name</th>
                                      <th>Country</th>
                                      <th>Feed Category</th>
                                      <th>Affiliate Network</th>
                                      <th>Type</th>
                                      <th>Source</th>
                                      <th>Medium</th>
                                      <th>Revenue</th>
                                      <th>Conversion Status</th>
                                      <th>Click Timestamp </th>
                                      <th>Conversion Timestamp </th>
                                      <th>OS </th>
                                      <th>Browser </th>
                                      <th>Device</th>
                                      <th>Location</th>
                                    </tr>
                                </tfoot>
                            </table>
                            </div>
                        </div>
                        <div class="tab-pane" id="charts" role="tabpanel" aria-labelledby="charts-tab" aria-expanded="false">
                            <div class="row match-height">
                                <!-- Pie Chart -->
                                <div class="col-12 col-lg-4 col-md-4">
                                    <div class="card bg-light">
                                      <div class="card-header">
                                        <h4 class="card-title text-white">Device</h4>
                                      </div>
                                      <div class="card-content">
                                        <div class="card-body">
                                          <div id="device-chart" class="mx-auto"></div>
                                        </div>
                                      </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4 col-md-4">
                                  <div class="card bg-light">
                                    <div class="card-header">
                                      <h4 class="card-title text-white">Browser</h4>
                                    </div>
                                    <div class="card-content">
                                      <div class="card-body">
                                        <div id="browser-chart" class="mx-auto"></div>
                                      </div>
                                    </div>
                                  </div>
                                </div>

                                <div class="col-12 col-lg-4 col-md-4">
                                    <div class="card bg-light">
                                      <div class="card-header">
                                        <h4 class="card-title text-white">City</h4>
                                      </div>
                                      <div class="card-content">
                                        <div class="card-body">
                                          <div id="city-chart" class="mx-auto"></div>
                                        </div>
                                      </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row match-height">
                                <div class="col-12 col-lg-4 col-md-4">
                                    <div class="card bg-light">
                                      <div class="card-header">
                                        <h4 class="card-title text-white">Domain</h4>
                                      </div>
                                      <div class="card-content">
                                        <div class="card-body">
                                          <div id="domain-chart" class="mx-auto"></div>
                                        </div>
                                      </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4 col-md-4">
                                    <div class="card bg-light">
                                      <div class="card-header">
                                        <h4 class="card-title text-white">Url</h4>
                                      </div>
                                      <div class="card-content">
                                        <div class="card-body">
                                          <div id="url-chart" class="mx-auto"></div>
                                        </div>
                                      </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4 col-md-4">
                                    <div class="card bg-light">
                                      <div class="card-header">
                                        <h4 class="card-title text-white">Medium</h4>
                                      </div>
                                      <div class="card-content">
                                        <div class="card-body">
                                          <div id="medium-chart" class="mx-auto"></div>
                                        </div>
                                      </div>
                                    </div>
                                </div>
                            </div>
                                
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
        </div>
    </div>

</section>

@endsection
@section('vendor-script')
{{-- vendor files --}}
    <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.bootstrap4.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.date.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.time.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/legacy.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/charts/apexcharts.min.js')) }}"></script>
@endsection
@section('page-script')
        {{-- Page js files --}}
        <script src="{{ asset(mix('js/scripts/charts/chart-apex.js')) }}"></script>
        <script>
            $(document).ready(function() {
                $('#click-events').DataTable( {
                    "lengthMenu": [[50, 100, 500, -1], [50, 100, 500, "All"]],
                    "order": [],
                    "columnDefs": [
                        { "width": "180px", "targets": 1 },
                        { "width": "100px", "targets": 4 },
                        { "width": "100px", "targets": 5 },
                        { "width": "100px", "targets": 9 },
                        { "width": "150px", "targets": 10 }
                    ],
                });

                $('#period_from').pickadate();
                $('#period_to').pickadate();
                $('.pickadate').on('change', function () {
                    if ($(this).attr('id') === 'period_from') {
                        $('#period_to').pickadate('picker').set('min',$(this).val());
                    }
                    if ($(this).attr('id') === 'period_to') {
                        $('#period_from').pickadate('picker').set('max',$(this).val());
                    }
                });

                $('#click-events').on( 'click', 'tbody tr', function () {
                    window.open(
                      $(this).attr('href'),
                      '_blank' // <- This is what makes it open in a new window.
                    );
                } );

                /*
                // Add event listener for opening and closing details
                $('#click-events tbody').on('click', 'td.details-control', function () {
                    var tr = $(this).closest('tr');
                    var row = table.row( tr );
            
                    if ( row.child.isShown() ) {
                        // This row is already open - close it
                        row.child.hide();
                        tr.removeClass('shown');
                    }
                    else {
                        // Open this row
                        row.child( format(row.data()) ).show();
                        tr.addClass('shown');
                    }
                } );*/

                var $primary = '#7367F0',
                    $success = '#28C76F',
                    $danger = '#EA5455',
                    $warning = '#FF9F43',
                    $info = '#00cfe8',
                    $label_color_light = '#dae1e7';

                var themeColors = [$primary, $success, $danger, $warning, $info];
                var browser_label = [
                @foreach ($browsers['chart_label'] as $chart_label)
                     "{{ $chart_label }}" , 
                @endforeach
                ];

                var browser_count = [
                @foreach ($browsers['chart_count'] as $chart_count)
                     {{ $chart_count }} ,
                @endforeach
                ];
                var browserChartOptions = {
                    chart: {
                    type: 'pie',
                    height: 350
                    },
                    colors: themeColors,
                    labels: browser_label,
                    series: browser_count,
                    legend: {
                    itemMargin: {
                        horizontal: 2
                    },
                    },
                    responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                        width: 350
                        },
                        legend: {
                        position: 'bottom'
                        }
                    }
                    }]
                }
                var device_label = [
                @foreach ($devices['chart_label'] as $chart_label)
                     "{{ $chart_label }}" , 
                @endforeach
                ];

                var device_count = [
                @foreach ($devices['chart_count'] as $chart_count)
                     {{ $chart_count }} ,
                @endforeach
                ];

                var deviceChartOptions = {
                    chart: {
                    type: 'pie',
                    height: 350
                    },
                    colors: themeColors,
                    labels: device_label,
                    series: device_count,
                    legend: {
                    itemMargin: {
                        horizontal: 2
                    },
                    },
                    responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                        width: 350
                        },
                        legend: {
                        position: 'bottom'
                        }
                    }
                    }]
                }

                var city_label = [
                @foreach ($cities['chart_label'] as $chart_label)
                     "{{ $chart_label }}" , 
                @endforeach
                ];

                var city_count = [
                @foreach ($cities['chart_count'] as $chart_count)
                     {{ $chart_count }} ,
                @endforeach
                ];

                var cityChartOptions = {
                    chart: {
                    type: 'pie',
                    height: 350
                    },
                    colors: themeColors,
                    labels: city_label,
                    series: city_count,
                    legend: {
                    itemMargin: {
                        horizontal: 2
                    },
                    },
                    responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                        width: 350
                        },
                        legend: {
                        position: 'bottom'
                        }
                    }
                    }]
                }

                var domain_label = [
                @foreach ($domains['chart_label'] as $chart_label)
                     "{{ $chart_label }}" , 
                @endforeach
                ];

                var domain_count = [
                @foreach ($domains['chart_count'] as $chart_count)
                     {{ $chart_count }} ,
                @endforeach
                ];

                var domainChartOptions = {
                    chart: {
                    type: 'pie',
                    height: 350
                    },
                    colors: themeColors,
                    labels: domain_label,
                    series: domain_count,
                    legend: {
                    position: 'top',
                    itemMargin: {
                        horizontal: 2
                    },
                    },
                    responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                        width: 350
                        },
                        legend: {
                        position: 'bottom'
                        }
                    }
                    }]
                }

                var url_label = [
                @foreach ($urls['chart_label'] as $chart_label)
                     "{{ $chart_label }}" , 
                @endforeach
                ];

                var url_count = [
                @foreach ($urls['chart_count'] as $chart_count)
                     {{ $chart_count }} ,
                @endforeach
                ];

                var urlChartOptions = {
                    chart: {
                    type: 'pie',
                    height: 350
                    },
                    colors: themeColors,
                    labels: url_label,
                    series: url_count,
                    legend: {
                    position: 'top',
                    itemMargin: {
                        horizontal: 2
                    },
                    },
                    responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                        width: 350
                        },
                        legend: {
                        position: 'bottom'
                        }
                    }
                    }]
                }

                var medium_label = [
                @foreach ($mediums['chart_label'] as $chart_label)
                     "{{ $chart_label }}" , 
                @endforeach
                ];

                var medium_count = [
                @foreach ($mediums['chart_count'] as $chart_count)
                     {{ $chart_count }} ,
                @endforeach
                ];

                var mediumChartOptions = {
                    chart: {
                    type: 'pie',
                    height: 350
                    },
                    colors: themeColors,
                    labels: medium_label,
                    series: medium_count,
                    legend: {
                    itemMargin: {
                        horizontal: 2
                    },
                    },
                    responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                        width: 350
                        },
                        legend: {
                        position: 'bottom'
                        }
                    }
                    }]
                }
                
                var browserChart = new ApexCharts(
                    document.querySelector("#browser-chart"),
                    browserChartOptions
                );
                var deviceChart = new ApexCharts(
                    document.querySelector("#device-chart"),
                    deviceChartOptions
                );
                var cityChart = new ApexCharts(
                    document.querySelector("#city-chart"),
                    cityChartOptions
                );

                var domainChart = new ApexCharts(
                    document.querySelector("#domain-chart"),
                    domainChartOptions
                );

                var urlChart = new ApexCharts(
                    document.querySelector("#url-chart"),
                    urlChartOptions
                );

                var mediumChart = new ApexCharts(
                    document.querySelector("#medium-chart"),
                    mediumChartOptions
                );
                
                browserChart.render();
                deviceChart.render();
                cityChart.render();
                domainChart.render();
                urlChart.render();
                mediumChart.render();

            } );
        </script>
@endsection
