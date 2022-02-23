
@extends('layouts/contentLayoutMaster')

@section('title', 'Click Full Details')

@section('vendor-style')

@endsection

@section('content')

<section id="content-types">
    <div class="row match-height">
        <div class="col-xl-6 col-md-6">
            <div class="card">

              <div class="card-content">
                <div class="card-header mb-1">
                    <h4 class="card-title">Click Details</h4>
                </div>
                <div class="card-body pt-0">
                    <div class="col-12 ">
                        <div class="row pt-1 border-bottom">
                            <div class="col-md-4">
                                <p class="text-bold-600"> Click ID: </p>
                            </div>
                            <div class="col-md-8">
                                <p> {{ $click_event->id }} </p>
                            </div>
                        </div>
                        <div class="row pt-1 border-bottom">
                            <div class="col-md-4">
                                <p class="text-bold-600"> Click Type: </p>
                            </div>
                            <div class="col-md-8">
                                <p> {{ $click_event->click_type }} </p>
                            </div>
                        </div>
                        <div class="row pt-1 border-bottom">
                            <div class="col-md-4">
                                <p class="text-bold-600"> UTM Source: </p>
                            </div>
                            <div class="col-md-8">
                                <p> {{ $click_event->utm_source }} </p>
                            </div>
                        </div>
                        <div class="row pt-1 border-bottom">
                            <div class="col-md-4">
                                <p class="text-bold-600"> UTM Medium: </p>
                            </div>
                            <div class="col-md-8">
                                <p> {{ $click_event->utm_medium }} </p>
                            </div>
                        </div>
                        <div class="row pt-1">
                            <div class="col-md-4">
                                <p class="text-bold-600"> UTM Content: </p>
                            </div>
                            <div class="col-md-8">
                                <p> {{ $click_event->utm_content }} </p>
                            </div>
                        </div>
                    </div>

                </div>

              </div>

            </div>
            <div class="card">

                <div class="card-content">
                  <div class="card-header mb-1">
                      <h4 class="card-title">Campaign Details</h4>
                  </div>
                  <div class="card-body pt-0">
                      <div class="col-12 ">
                          <div class="row pt-1 border-bottom">
                              <div class="col-md-4">
                                  <p class="text-bold-600"> Campaign Name: </p>
                              </div>
                              <div class="col-md-8">
                                  <p> {{ $campaign->campaign_name }} </p>
                              </div>
                          </div>
                          <div class="row pt-1 border-bottom">
                              <div class="col-md-4">
                                  <p class="text-bold-600"> Campaign Logo: </p>
                              </div>
                              <div class="col-md-8">
                                  <p> <img src="/storage/campaign_logo/{{  $campaign->campaign_logo }}" alt="Campaign Logo" height="40" width="130"> </p>
                              </div>
                          </div>
                          <div class="row pt-1 border-bottom">
                              <div class="col-md-4">
                                  <p class="text-bold-600"> Campaign Country: </p>
                              </div>
                              <div class="col-md-8">
                                  <p> {{ $click_event->campaign_country }} </p>
                              </div>
                          </div>
                          <div class="row pt-1">
                              <div class="col-md-4">
                                  <p class="text-bold-600"> Campaign Feed Category: </p>
                              </div>
                              <div class="col-md-8">
                                  <p> {{ $click_event->campaign_feed_category }} </p>
                              </div>
                          </div>
                      </div>

                  </div>

                </div>

            </div>
        </div>
        <div class="col-xl-6 col-md-6">
            <div class="card">

              <div class="card-content">
                <div class="card-header mb-1">
                    <h4 class="card-title">Postback Details</h4>
                </div>
                <div class="card-body pt-0">
                    <div class="col-12 ">
                        <div class="row pt-1 border-bottom">
                            <div class="col-md-4">
                                <p class="text-bold-600"> Conversion Status: </p>
                            </div>
                            <div class="col-md-8">
                                @if($click_event->conversion_status != "Accepted")
                                    <div class="badge badge-warning badge-md">Pending</div>
                                @else
                                    <div class="badge badge-success badge-md">Accepted</div>
                                @endif

                            </div>
                        </div>

                        <div class="row pt-1">
                            <div class="col-md-4">
                                <p class="text-bold-600"> Payout: </p>
                            </div>
                            <div class="col-md-8">
                                <p> {{ number_format($click_event->payout, 2) }} {{ $click_event->currency }} </p>
                            </div>
                        </div>

                        <div class="row pt-1">
                            <div class="col-md-4">
                                <p class="text-bold-600"> Conversion time: </p>
                            </div>
                            <div class="col-md-8">
                                @isset($postback[0])
                                    <p> {{ $postback[0]->created_at }} </p>
                                @endisset
                            </div>
                        </div>

                    </div>
                </div>

              </div>

            </div>
            <div class="card">

                <div class="card-content">
                  <div class="card-header mb-1">
                      <h4 class="card-title">Client Details</h4>
                  </div>
                  <div class="card-body pt-0">
                      <div class="col-12 ">
                          <div class="row pt-1 border-bottom">
                              <div class="col-md-4">
                                  <p class="text-bold-600"> Client IP Address: </p>
                              </div>
                              <div class="col-md-8">
                                  <p> {{ $click_event->client_ip_address }} </p>
                              </div>
                          </div>
                          <div class="row pt-1 border-bottom">
                              <div class="col-md-4">
                                  <p class="text-bold-600"> Client Country: </p>
                              </div>
                              <div class="col-md-8">
                                  <p> {{ $click_event->client_country }} </p>
                              </div>
                          </div>
                          <div class="row pt-1 border-bottom">
                            <div class="col-md-4">
                                <p class="text-bold-600"> Client Region: </p>
                            </div>
                            <div class="col-md-8">
                                <p> {{ $click_event->client_region }} </p>
                            </div>
                        </div>
                        <div class="row pt-1 border-bottom">
                            <div class="col-md-4">
                                <p class="text-bold-600"> Client City: </p>
                            </div>
                            <div class="col-md-8">
                                <p> {{ $click_event->client_city }} </p>
                            </div>
                        </div>

                        <div class="row pt-1">
                              <div class="col-md-4">
                                  <p class="text-bold-600"> Client Platform: </p>
                              </div>
                              <div class="col-md-8">
                                  <p> {{ $click_event->client_platform }} </p>
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

@endsection
@section('page-script')
        {{-- Page js files --}}

        <script>
            $(document).ready(function() {

            } );
        </script>
@endsection
