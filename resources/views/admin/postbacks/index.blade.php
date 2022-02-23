
@extends('layouts/contentLayoutMaster')

@section('title', 'Postbacks')

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
                      <form action="/admin/postbacks">
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
                            <label for="users-list-status">Affiliate Network</label>
                            <fieldset class="form-group">
                              <select class="form-control" name="affiliate_network_id" id="users-list-status">
                                <option value="All"> All </option>
                                @foreach($affiliate_networks as $affiliate_network)
                                    <option {{ ($filter->get('affiliate_network_id') == $affiliate_network->id)?"selected":"" }} value="{{ $affiliate_network->id }}"> {{ $affiliate_network->affiliate_network_name }} </option>
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
                      <h1 class="text-bold-600"> {{ ($filter->has('period_from') && $filter->has('period_to'))?$filter->get('period_from') . " - " .$filter->get('period_to'). " Postbacks":"Today's Postbacks" }}</h1>

                    </div>
                    <div class="card-body card-dashboard">
                        <div class="table-responsive">
                            <table id="click-events" class="table table-striped table-bordereds">
                                <thead class="thead-light">
                                    <tr>
                                        <th> ID </th>
                                        <th> Campaign Name </th>
                                        <th> Affiliate Network </th>
                                        <th> Payout </th>
                                        <th> Status </th>
                                        <th> Time </th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @foreach($postbacks as $postback)
                                      <tr>
                                          <td> {{ $postback->id }}</td>
                                          <td> {{ $postback->campaign_name }}</td>
                                          <td> {{ $postback->affiliate_network_name }}</td>
                                          <td> {{ number_format($postback->payout, 2) }}</td>
                                          <td> {{ $postback->status }}</td>
                                          <td> {{ $postback->created_at }}</td>
                            
                                      </tr>
                                  @endforeach
                                </tbody>
                                <tfoot class="thead-light">
                                    <tr>
                                      <th> ID </th>
                                      <th> Campaign Name </th>
                                      <th> Affiliate Network </th>
                                      <th> Payout </th>
                                      <th> Status </th>
                                      <th> Time </th>
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
                    "order": [[ 3, "desc" ]]
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
            } );
        </script>
@endsection
