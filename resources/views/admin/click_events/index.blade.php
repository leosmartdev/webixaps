
@extends('layouts/contentLayoutMaster')

@section('title', 'Click Events')

@section('vendor-style')
        {{-- vendor css files --}}
        <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/datatables.min.css')) }}">
        <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
@endsection

@section('content')


  <!-- Complex headers table -->
  <section id="headers">
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
                            <label for="users-list-role">Campaign Name</label>
                            <fieldset class="form-group">
                              <select class="form-control" name="campaign_id" id="users-list-role">
                                <option value="All"> All </option>
                                @foreach($campaigns as $campaign)
                                    <option {{ ($filter->get('campaign_id') == $campaign->id)?"selected":"" }} value="{{ $campaign->id }}"> {{ $campaign->campaign_name }}</option>
                                @endforeach
                              </select>
                            </fieldset>
                          </div>
                          <div class="col-12 col-sm-6 col-lg-3">
                            <label for="users-list-status">Campaign Country</label>
                            <fieldset class="form-group">
                              <select class="form-control" name="country_name" id="users-list-status">
                                <option value="All"> All </option>
                                @foreach($countries as $country)
                                    <option {{ ($filter->get('country_name') == $country->country_name)?"selected":"" }} value="{{ $country->country_name }}"> {{ $country->country_name }}</option>
                                @endforeach
                              </select>
                            </fieldset>
                          </div>
                          <div class="col-12 col-sm-6 col-lg-3">
                            <label for="users-list-verified">Period (From)</label>
                            <fieldset class="form-group">
                            <input type='text' value="{{ ($filter->has('period_from'))?$filter->get('period_from'):date('d F, Y') }}" id="period_from" name="period_from" class="form-control pickadate" />
                            </fieldset>
                          </div>
                          <div class="col-12 col-sm-6 col-lg-3">
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
                        <div class="table-responsive">
                            <table id="click-events" class="table table-striped table-bordereds" >
                                <thead class="thead-light">
                                    <tr>
                                        <th></th>
                                        <th colspan="4">Campaign</th>
                                        <th colspan="5">Click Informations</th>
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
                                        <th>Payout</th>
                                        <th>Conversion Status</th>
                                        <th>Access Time </th>
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
                                      <th>Payout</th>
                                      <th>Conversion Status</th>
                                      <th>Access Time </th>
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
{{-- vendor files --}}
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
            } );
        </script>
@endsection
