@extends('layouts/contentLayoutMaster')

@section('title', 'Statistics')

@section('vendor-style')
        {{-- Vendor Css files --}}
        <link rel="stylesheet" href="{{ asset(mix('vendors/css/charts/apexcharts.css')) }}">
        <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/datatables.min.css')) }}">
        <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
@endsection
@section('page-style')
        {{-- Page Css files --}}
        <link rel="stylesheet" href="{{ asset(mix('css/pages/card-analytics.css')) }}">
@endsection
@section('content')
{{-- Statistics card section start --}}
<section id="statistics-card">

    <div class="row">
        <div class="col-lg-3 col-sm-6 col-12">
            <div class="card this-month">
                <div class="card-header d-flex align-items-start pb-0">
                    <div>
                        <h2 id="this-month" class="text-bold-700 mb-0"> - </h2>
                        <p><strong>Revenue this month</strong></p>
                    </div>
                    <div class="avatar bg-rgba-primary p-50 m-0">
                        <div class="avatar-content">
                            <i class="fa fa-angle-right text-primary font-medium-5"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-12">
            <div class="card this-week">
                <div class="card-header d-flex align-items-start pb-0">
                    <div>
                        <h2 id="this-week" class="text-bold-700 mb-0"> - </h2>
                        <p><strong>Revenue this week</strong></p>
                    </div>
                    <div class="avatar bg-rgba-success p-50 m-0">
                        <div class="avatar-content">
                            <i class="fa fa-angle-right text-success font-medium-5"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-12">
            <div class="card yesterday">
                <div class="card-header d-flex align-items-start pb-0">
                    <div>
                        <h2 id="yesterday" class="text-bold-700 mb-0"> - </h2>
                        <p><strong>Revenue yesterday</strong></p>
                    </div>
                    <div class="avatar bg-rgba-danger p-50 m-0">
                        <div class="avatar-content">
                            <i class="fa fa-angle-right text-danger font-medium-5"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-12">
            <div class="card today">
                <div class="card-header d-flex align-items-start pb-0">
                    <div>
                        <h2 id="today" class="text-bold-700 mb-0"> - </h2>
                        <p><strong>Revenue today</strong></p>
                    </div>
                    <div class="avatar bg-rgba-warning p-50 m-0">
                        <div class="avatar-content">
                            <i class="fa fa-angle-right text-warning font-medium-5"></i>
                        </div>
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
                    <form action="/admin/click_events">
                      <input type="hidden" name="filter" value="yes">
                      <div class="row">

                        <div class="col-12 col-sm-6 col-lg-3">
                          <label for="users-list-verified">Period (From)</label>
                          <fieldset class="form-group">
                          <input type='text' value="{{ ($filter->has('period_from'))?$filter->get('period_from'):"" }}" id="period_from" name="period_from" class="form-control pickadate" />
                          </fieldset>
                        </div>
                        <div class="col-12 col-sm-6 col-lg-3">
                          <label for="users-list-department">Period (To)</label>
                          <fieldset class="form-group">
                              <input type='text' value="{{ ($filter->has('period_to'))?$filter->get('period_to'):"" }}" id="period_to" name="period_to" class="form-control pickadate" />
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
                  <div class="card-body card-dashboard">
                      <div class="table-responsive">
                          <table id="statistics" class="table table-striped table-bordereds">
                              <thead class="thead-light">
                                  <tr>
                                      <th>Campaign</th>
                                      <th>Unique Click #</th>
                                      <th>Non-Unique Click #</th>
                                      <th>Click DKK</th>
                                      <th>Lead</th>
                                      <th>Lead DKK</th>
                                      <th>Sale #</th>
                                      <th>Sale DKK</th>
                                      <th>Subtotal DKK</th>
                                      <th>EPC*</th>
                                      <th>CR%</th>
                                  </tr>
                              </thead>
                              <tbody>
                                @foreach($statistics as $statistic)
                                    <tr>
                                        <td> {{ $statistic->campaign_name }} </td>
                                        <td>  </td>
                                        <td>  </td>
                                        <td>  </td>
                                        <td>  </td>
                                        <td>  </td>
                                        <td>  </td>
                                        <td>  </td>
                                        <td>  </td>
                                        <td>  </td>
                                        <td>  </td>
                                    </tr>
                                @endforeach
                              </tbody>
                              <tfoot class="thead-light">
                                  <tr>
                                    <th>Campaign</th>
                                    <th>Unique Click #</th>
                                    <th>Non-Unique Click #</th>
                                    <th>Click DKK</th>
                                    <th>Lead</th>
                                    <th>Lead DKK</th>
                                    <th>Sale #</th>
                                    <th>Sale DKK</th>
                                    <th>Subtotal DKK</th>
                                    <th>EPC*</th>
                                    <th>CR%</th>
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
{{-- // Statistics Card section end--}}
@endsection
@section('vendor-script')
{{-- Vendor js files --}}
        <script src="{{ asset(mix('vendors/js/charts/apexcharts.min.js')) }}"></script>
        <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.min.js')) }}"></script>
        <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script>
        <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.bootstrap4.min.js')) }}"></script>
        <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.js')) }}"></script>
        <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.date.js')) }}"></script>
        <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.time.js')) }}"></script>
        <script src="{{ asset(mix('vendors/js/pickers/pickadate/legacy.js')) }}"></script>
@endsection
@section('page-script')
{{-- Page js files --}}
        <script src="{{ asset(mix('js/scripts/webix-list/statistics-page.js')) }}"></script>
        <script>
            $(document).ready(function() {
                $('#statistics').DataTable( {
                    "lengthMenu": [[50, 100, 500, -1], [50, 100, 500, "All"]],
                    "order": []
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
            } );
        </script>
@endsection
