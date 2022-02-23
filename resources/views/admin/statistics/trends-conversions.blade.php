
@extends('layouts/contentLayoutMaster')

@section('title', 'Trends')

@section('vendor-style')
        {{-- Vendor Css files --}}
        <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/datatables.min.css')) }}">
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
                    <div class="card-content">
                        <div class="card-header">
                            <h1 class="text-bold-600"> Top 50 Campaign Long Performance by Conversions </h1>

                        </div>
                        <div class="card-body card-dashboard">
                            <ul class="nav nav-pills">
                                <li class="nav-item">
                                  <a class="nav-link " id="table-tab" href="/admin/statistics/trends" aria-expanded="true">Revenue</a>
                                </li>
                                <li class="nav-item">
                                  <a class="nav-link" id="table-tab" href="/admin/statistics/trends/epc" aria-expanded="true">Earnings Per Click</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="table-tab" href="/admin/statistics/trends/clicks" aria-expanded="true">Clicks</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" id="table-tab" href="/admin/statistics/trends/conversions" aria-expanded="true">Conversions</a>
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
                                            <td class="{{ ($month)?'green':'red' }}"> {{ ($month)?$month:0 }} </td>
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
@endsection
@section('page-script')
{{-- Page js files --}}
        <script>
            $(document).ready(function() {

                $('#click-events').DataTable( {
                    "lengthMenu": [[50, 100, 500, -1], [50, 100, 500, "All"]],
                    "order": []
                });
 
            } );
        </script>
@endsection
