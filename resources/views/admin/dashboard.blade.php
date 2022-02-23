
@extends('layouts/contentLayoutMaster')

@section('title', 'Dashboard Analytics')

@section('vendor-style')
        <!-- vendor css files -->

@endsection
@section('page-style')
        <!-- Page css files -->
        <link rel="stylesheet" href="{{ asset(mix('css/pages/dashboard-analytics.css')) }}">
@endsection

@section('content')
{{-- Dashboard Analytics Start --}}
<section id="dashboard-analytics">
	<section id="statistics-card">
        <!-- DK -->
		<div class="row match-height">
            <div class="col-12 flag-title mb-1">
				<h5 class="text-bold-600 ">
					<img src="{{ asset('images/flags/dk.jpg') }}" width="40" height="40" class=" round mr-1" alt="card-img-left"> Denmark
				</h5>
			</div>
			<div class="col-lg-6 col-md-12 col-sm-12">
				<div class="card bg-analyticss text-black">
					<div class="card-content">
						<div class="card-body text-center">


                            @if($top_campaigns['DK']->campaign_logo)
							<div class="text-center mb-1">

                                <img src="/storage/campaign_logo/{{  $top_campaigns['DK']->campaign_logo }}" alt="Campaign Logo" height="40" width="130">

							</div>
							<div class="text-center">
                                <h4 class="mb-2 text-bold-600 text-black">Top Campaign of the Month</h4>
                                @if($top_campaigns['DK']->unique_clicks > 0)
								    <p class="m-auto w-75">This campaign got an EPC of {{ number_format(( $top_campaigns['DK']->payout / $top_campaigns['DK']->unique_clicks),2, ',','.'). " DKK from the last 30 days." }}</p>
                                @else
                                    <p class="m-auto w-75">Though, this campaign got an EPC of 0 from the last 30 days.</p>
                                @endif
                            </div>
                            @else
                            <div class="text-center pt-3 mb-1"> <h4 class="mb-2 text-bold-600 text-black">No Top Campaign of the Month</h4> </div>
                            @endif
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-2 col-md-12 col-sm-12">
				<div class="card bg-analyticss text-black">
					<div class="card-content">
						<div class="card-body text-center">
							<div class="text-center">
                                @if($top_feed_sites['DK'])
                                    <h6 class="mb-2 text-bold-600 text-black">{{ $top_feed_sites['DK']->click_source_site_name }}</h6>
                                    <p class="mb-2 text-bold-600 text-black">Top Feed Site of the Month</p>
                                    <small class="m-auto w-75">This feed site made <strong> {{ $top_feed_sites['DK']->clicks }} </strong> clicks with a total payout of {{ number_format($top_feed_sites['DK']->total_payout, 2) }} from the last 30 days </small>
                                @else
                                <p class="mb-2 pt-3 text-bold-600 text-black">No Top Feed Site of the Month</p>
                                <small class="m-auto w-75">No feed site made any click from the last 30 days. </small>
                                @endif

							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-2 col-md-12 col-sm-12">
				<div class="card bg-analyticss text-black">
					<div class="card-content">
						<div class="card-body text-center">
							<div class="text-center">
                                @if($top_aff_networks['DK'])
                                    <h6 class="mb-2 text-bold-600 text-black">{{ $top_aff_networks['DK']->affiliate_network_name }}</h6>
                                    <p class="mb-2 text-bold-600 text-black">Top Aff Network of the Month</p>
                                    <small class="m-auto w-75">This aff network made <strong> {{ $top_aff_networks['DK']->clicks }} </strong> clicks with a total payout of {{ number_format($top_aff_networks['DK']->total_payout, 2) }} from the last 30 days </small>
                                @else
                                    <p class="mb-2 pt-3 text-bold-600 text-black">No Top Aff Network of the Month</p>
                                    <small class="m-auto w-75">No aff network made any click from the last 30 days. </small>
                                @endif
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-2 col-md-12 col-sm-12">
				<div class="card bg-analyticss text-black">
					<div class="card-content">
						<div class="card-body text-center">
							<div class="text-center">
                                @if($top_urls['DK'])
                                    <h6 class="mb-2 text-bold-600 text-black">{{ $top_urls['DK']->click_source_site_url }}</h6>
                                    <p class="mb-2 text-bold-600 text-black">Top Site Page of the Month</p>
                                    <small class="m-auto w-75">This site page made <strong> {{ $top_urls['DK']->clicks }} </strong> clicks with a total payout of {{ number_format($top_urls['DK']->total_payout, 2) }} from the last 30 days </small>
                                @else
                                    <p class="mb-2 pt-3 text-bold-600 text-black">No Top Site Page of the Month</p>
                                    <small class="m-auto w-75">No site page made any click from the last 30 days. </small>
                                @endif
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row dk-wrap">
			<div class="col-lg-3 col-sm-6 col-12">
				<div class="card today">
					<div class="card-header d-flex align-items-start pb-0">
						<div>
							<h2 id="today" class="text-white text-bold-700 mb-0"> - </h2>
							<p>
								<strong class="text-white">Revenue today</strong>
							</p>
						</div>
						<div class="avatar bg-rgba-warning p-50 m-0">
							<div class="avatar-content">
								<i class="fa fa-angle-right text-warning font-medium-5"></i>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-3 col-sm-6 col-12">
				<div class="card yesterday">
					<div class="card-header d-flex align-items-start pb-0">
						<div>
							<h2 id="yesterday" class="text-white text-bold-700 mb-0"> - </h2>
							<p>
								<strong class="text-white">Revenue yesterday</strong>
							</p>
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
				<div class="card this-week">
					<div class="card-header d-flex align-items-start pb-0">
						<div>
							<h2 id="this-week" class="text-white text-bold-700 mb-0"> - </h2>
							<p>
								<strong class="text-white">Revenue this week</strong>
							</p>
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
				<div class="card this-month">
					<div class="card-header d-flex align-items-start pb-0">
						<div>
							<h2 id="this-month" class="text-white text-bold-700 mb-0"> - </h2>
							<p>
								<strong class="text-white">Revenue this month</strong>
							</p>
						</div>
						<div class="avatar bg-rgba-primary p-50 m-0">
							<div class="avatar-content">
								<i class="fa fa-angle-right text-primary font-medium-5"></i>
							</div>
						</div>
					</div>
				</div>
			</div>
        </div>
        <!-- SE -->
        <div class="row se-wrap match-height">
            <div class="col-12 flag-title mb-1">
                <h5 class="text-bold-600 ">
                    <img src="{{ asset('images/flags/se.jpg') }}" width="40" height="40" class=" round mr-1" alt="card-img-left"> Sweden
                </h5>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12">
                <div class="card bg-analyticss text-black">
                    <div class="card-content">
                        <div class="card-body text-center">


                            @if($top_campaigns['SE']->campaign_logo)
                            <div class="text-center mb-1">

                                <img src="/storage/campaign_logo/{{  $top_campaigns['SE']->campaign_logo }}" alt="Campaign Logo" height="40" width="130">

                            </div>
                            <div class="text-center">
                                <h4 class="mb-2 text-bold-600 text-black">Top Campaign of the Month</h4>

                                @if($top_campaigns['SE']->unique_clicks > 0)
                                    <p class="m-auto w-75">This campaign got an EPC of {{ number_format(( $top_campaigns['SE']->payout/$top_campaigns['SE']->unique_clicks),2, ',','.'). " SEK from the last 30 days." }}</p>
                                @else
                                    <p class="m-auto w-75">Though, this campaign got an EPC of 0 from the last 30 days.</p>
                                @endif
                            </div>
                            @else
                            <div class="text-center pt-3 mb-1"> <h4 class="mb-2 text-bold-600 text-black">No Top Campaign of the Month</h4> </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-12 col-sm-12">
                <div class="card bg-analyticss text-black">
                    <div class="card-content">
                        <div class="card-body text-center">
							<div class="text-center">
                                @if($top_feed_sites['SE'])
                                    <h6 class="mb-2 text-bold-600 text-black">{{ $top_feed_sites['SE']->click_source_site_name }}</h6>
                                    <p class="mb-2 text-bold-600 text-black">Top Feed Site of the Month</p>
                                    <small class="m-auto w-75">This feed site made <strong> {{ $top_feed_sites['SE']->clicks }} </strong> clicks with a total payout of {{ number_format($top_feed_sites['SE']->total_payout, 2) }} from the last 30 days </small>
                                @else
                                <p class="mb-2 pt-3 text-bold-600 text-black">No Top Feed Site of the Month</p>
                                <small class="m-auto w-75">No feed site made any click from the last 30 days. </small>
                                @endif

							</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-12 col-sm-12">
                <div class="card bg-analyticss text-black">
                    <div class="card-content">
                        <div class="card-body text-center">
							<div class="text-center">
                                @if($top_aff_networks['SE'])
                                    <h6 class="mb-2 text-bold-600 text-black">{{ $top_aff_networks['SE']->affiliate_network_name }}</h6>
                                    <p class="mb-2 text-bold-600 text-black">Top Aff Network of the Month</p>
                                    <small class="m-auto w-75">This aff network made <strong> {{ $top_aff_networks['SE']->clicks }} </strong> clicks with a total payout of {{ number_format($top_aff_networks['SE']->total_payout, 2) }} from the last 30 days </small>
                                @else
                                <p class="mb-2 pt-3 text-bold-600 text-black">No Top Aff Network of the Month</p>
                                <small class="m-auto w-75">No aff network made any click from the last 30 days. </small>
                                @endif

							</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-12 col-sm-12">
                <div class="card bg-analyticss text-black">
                    <div class="card-content">
                        <div class="card-body text-center">
							<div class="text-center">
                                @if($top_urls['SE'])
                                    <h6 class="mb-2 text-bold-600 text-black">{{ $top_urls['SE']->click_source_site_url }}</h6>
                                    <p class="mb-2 text-bold-600 text-black">Top Site Page of the Month</p>
                                    <small class="m-auto w-75">This site page made <strong> {{ $top_urls['SE']->clicks }} </strong> clicks with a total payout of {{ number_format($top_urls['SE']->total_payout, 2) }} from the last 30 days </small>
                                @else
                                    <p class="mb-2 pt-3 text-bold-600 text-black">No Top Site Page of the Month</p>
                                    <small class="m-auto w-75">No site page made any click from the last 30 days. </small>
                                @endif
							</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="card today bg-gradient-light">
                    <div class="card-header d-flex align-items-start pb-0">
                        <div>
                            <h2 id="se-today" class="text-bold-700 text-white mb-0"> - </h2>
                            <p>
                                <strong>Revenue today</strong>
                            </p>
                        </div>
                        <div class="avatar bg-rgba-warning p-50 m-0">
                            <div class="avatar-content">
                                <i class="fa fa-angle-right text-warning font-medium-5"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="card yesterday bg-gradient-light">
                    <div class="card-header d-flex align-items-start pb-0">
                        <div>
                            <h2 id="se-yesterday" class="text-bold-700 text-white mb-0"> - </h2>
                            <p>
                                <strong>Revenue yesterday</strong>
                            </p>
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
                <div class="card this-week bg-gradient-light">
                    <div class="card-header d-flex align-items-start pb-0">
                        <div>
                            <h2 id="se-this-week" class="text-bold-700 text-white mb-0"> - </h2>
                            <p>
                                <strong>Revenue this week</strong>
                            </p>
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
                <div class="card this-month bg-gradient-light">
                    <div class="card-header d-flex align-items-start pb-0">
                        <div>
                            <h2 id="se-this-month" class="text-bold-700 text-white mb-0"> - </h2>
                            <p>
                                <strong>Revenue this month</strong>
                            </p>
                        </div>
                        <div class="avatar bg-rgba-primary p-50 m-0">
                            <div class="avatar-content">
                                <i class="fa fa-angle-right text-primary font-medium-5"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- NO -->
        <div class="row no-wrap match-height">
            <div class="col-12 flag-title mb-1">
                <h5 class="text-bold-600 ">
                    <img src="{{ asset('images/flags/no.jpg') }}" width="40" height="40" class=" round mr-1" alt="card-img-left"> Norway
                </h5>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12">
                <div class="card bg-analyticss text-black">
                    <div class="card-content">
                        <div class="card-body text-center">


                            @if($top_campaigns['NO']->campaign_logo)
                            <div class="text-center mb-1">

                                <img src="/storage/campaign_logo/{{  $top_campaigns['NO']->campaign_logo }}" alt="Campaign Logo" height="40" width="130">

                            </div>
                            <div class="text-center">
                                <h4 class="mb-2 text-bold-600 text-black">Top Campaign of the Month</h4>
                                @if( $top_campaigns['NO']->unique_clicks > 0)
                                    <p class="m-auto w-75">This campaign got an EPC of {{ number_format(( $top_campaigns['NO']->payout/ $top_campaigns['NO']->unique_clicks),2, ',','.'). " NOK from the last 30 days." }}</p>
                                @else
                                    <p class="m-auto w-75">Though, this campaign got an EPC of 0 from the last 30 days.</p>
                                @endif
                            </div>
                            @else
                            <div class="text-center pt-3 mb-1"> <h4 class="mb-2 text-bold-600 text-black">No Top Campaign of the Month</h4> </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-12 col-sm-12">
                <div class="card bg-analyticss text-black">
                    <div class="card-content">
                        <div class="card-body text-center">
							<div class="text-center">
                                @if($top_feed_sites['NO'])
                                    <h6 class="mb-2 text-bold-600 text-black">{{ $top_feed_sites['NO']->click_source_site_name }}</h6>
                                    <p class="mb-2 text-bold-600 text-black">Top Feed Site of the Month</p>
                                    <small class="m-auto w-75">This feed site made <strong> {{ $top_feed_sites['NO']->clicks }} </strong> clicks with a total payout of {{ number_format($top_feed_sites['NO']->total_payout, 2) }} from the last 30 days </small>
                                @else
                                <p class="mb-2 pt-3 text-bold-600 text-black">No Top Feed Site of the Month</p>
                                <small class="m-auto w-75">No feed site made any click from the last 30 days. </small>
                                @endif

							</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-12 col-sm-12">
                <div class="card bg-analyticss text-black">
                    <div class="card-content">
                        <div class="card-body text-center">
							<div class="text-center">
                                @if($top_aff_networks['NO'])
                                    <h6 class="mb-2 text-bold-600 text-black">{{ $top_aff_networks['NO']->affiliate_network_name }}</h6>
                                    <p class="mb-2 text-bold-600 text-black">Top Aff Network of the Month</p>
                                    <small class="m-auto w-75">This aff network made <strong> {{ $top_aff_networks['NO']->clicks }} </strong> clicks with a total payout of {{ number_format($top_aff_networks['NO']->total_payout, 2) }} from the last 30 days </small>
                                @else
                                <p class="mb-2 pt-3 text-bold-600 text-black">No Top Aff Network of the Month</p>
                                <small class="m-auto w-75">No aff network made any click from the last 30 days. </small>
                                @endif

							</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-12 col-sm-12">
                <div class="card bg-analyticss text-black">
                    <div class="card-content">
                        <div class="card-body text-center">
							<div class="text-center">
                                @if($top_urls['NO'])
                                    <h6 class="mb-2 text-bold-600 text-black">{{ $top_urls['NO']->click_source_site_url }}</h6>
                                    <p class="mb-2 text-bold-600 text-black">Top Site Page of the Month</p>
                                    <small class="m-auto w-75">This site page made <strong> {{ $top_urls['NO']->clicks }} </strong> clicks with a total payout of {{ number_format($top_urls['NO']->total_payout, 2) }} from the last 30 days </small>
                                @else
                                    <p class="mb-2 pt-3 text-bold-600 text-black">No Top Site Page of the Month</p>
                                    <small class="m-auto w-75">No site page made any click from the last 30 days. </small>
                                @endif
							</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="card today bg-gradient-light">
                    <div class="card-header d-flex align-items-start pb-0">
                        <div>
                            <h2 id="no-today" class="text-bold-700 text-white mb-0"> - </h2>
                            <p>
                                <strong>Revenue today</strong>
                            </p>
                        </div>
                        <div class="avatar bg-rgba-warning p-50 m-0">
                            <div class="avatar-content">
                                <i class="fa fa-angle-right text-warning font-medium-5"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="card yesterday bg-gradient-light">
                    <div class="card-header d-flex align-items-start pb-0">
                        <div>
                            <h2 id="no-yesterday" class="text-bold-700 text-white mb-0"> - </h2>
                            <p>
                                <strong>Revenue yesterday</strong>
                            </p>
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
                <div class="card this-week bg-gradient-light">
                    <div class="card-header d-flex align-items-start pb-0">
                        <div>
                            <h2 id="no-this-week" class="text-bold-700 text-white mb-0"> - </h2>
                            <p>
                                <strong>Revenue this week</strong>
                            </p>
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
                <div class="card this-month bg-gradient-light">
                    <div class="card-header d-flex align-items-start pb-0">
                        <div>
                            <h2 id="no-this-month" class="text-bold-700 text-white mb-0"> - </h2>
                            <p>
                                <strong>Revenue this month</strong>
                            </p>
                        </div>
                        <div class="avatar bg-rgba-primary p-50 m-0">
                            <div class="avatar-content">
                                <i class="fa fa-angle-right text-primary font-medium-5"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- UK -->
        <div class="row uk-wrap match-height">
            <div class="col-12 flag-title mb-1">
                <h5 class="text-bold-600 ">
                    <img src="{{ asset('images/flags/uk.png') }}" width="40" height="40" class=" round mr-1" alt="card-img-left"> United Kingdom
                </h5>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12">
                <div class="card bg-analyticss text-black">
                    <div class="card-content">
                        <div class="card-body text-center">


                            @if($top_campaigns['UK']->campaign_logo)
                                <div class="text-center mb-1">

                                    <img src="/storage/campaign_logo/{{  $top_campaigns['UK']->campaign_logo }}" alt="Campaign Logo" height="40" width="130">

                                </div>
                                <div class="text-center">
                                    <h4 class="mb-2 text-bold-600 text-black">Top Campaign of the Month</h4>
                                    @if( $top_campaigns['UK']->unique_clicks > 0)
                                        <p class="m-auto w-75">This campaign got an EPC of {{ number_format(( $top_campaigns['UK']->payout/ $top_campaigns['UK']->unique_clicks),2, ',','.'). " GBP from the last 30 days." }}</p>
                                    @else
                                        <p class="m-auto w-75">Though, this campaign got an EPC of 0 from the last 30 days.</p>
                                    @endif
                                </div>
                            @else
                                <div class="text-center pt-3 mb-1"> <h4 class="mb-2 text-bold-600 text-black">No Top Campaign of the Month</h4> </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-12 col-sm-12">
                <div class="card bg-analyticss text-black">
                    <div class="card-content">
                        <div class="card-body text-center">
                            <div class="text-center">
                                @if($top_feed_sites['UK'])
                                    <h6 class="mb-2 text-bold-600 text-black">{{ $top_feed_sites['UK']->click_source_site_name }}</h6>
                                    <p class="mb-2 text-bold-600 text-black">Top Feed Site of the Month</p>
                                    <small class="m-auto w-75">This feed site made <strong> {{ $top_feed_sites['UK']->clicks }} </strong> clicks with a total payout of {{ number_format($top_feed_sites['UK']->total_payout, 2) }} from the last 30 days </small>
                                @else
                                    <p class="mb-2 pt-3 text-bold-600 text-black">No Top Feed Site of the Month</p>
                                    <small class="m-auto w-75">No feed site made any click from the last 30 days. </small>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-12 col-sm-12">
                <div class="card bg-analyticss text-black">
                    <div class="card-content">
                        <div class="card-body text-center">
                            <div class="text-center">
                                @if($top_aff_networks['UK'])
                                    <h6 class="mb-2 text-bold-600 text-black">{{ $top_aff_networks['UK']->affiliate_network_name }}</h6>
                                    <p class="mb-2 text-bold-600 text-black">Top Aff Network of the Month</p>
                                    <small class="m-auto w-75">This aff network made <strong> {{ $top_aff_networks['UK']->clicks }} </strong> clicks with a total payout of {{ number_format($top_aff_networks['UK']->total_payout, 2) }} from the last 30 days </small>
                                @else
                                    <p class="mb-2 pt-3 text-bold-600 text-black">No Top Aff Network of the Month</p>
                                    <small class="m-auto w-75">No aff network made any click from the last 30 days. </small>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-12 col-sm-12">
                <div class="card bg-analyticss text-black">
                    <div class="card-content">
                        <div class="card-body text-center">
                            <div class="text-center">
                                @if($top_urls['UK'])
                                    <h6 class="mb-2 text-bold-600 text-black">{{ $top_urls['UK']->click_source_site_url }}</h6>
                                    <p class="mb-2 text-bold-600 text-black">Top Site Page of the Month</p>
                                    <small class="m-auto w-75">This site page made <strong> {{ $top_urls['UK']->clicks }} </strong> clicks with a total payout of {{ number_format($top_urls['UK']->total_payout, 2) }} from the last 30 days </small>
                                @else
                                    <p class="mb-2 pt-3 text-bold-600 text-black">No Top Site Page of the Month</p>
                                    <small class="m-auto w-75">No site page made any click from the last 30 days. </small>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="card today bg-gradient-light">
                    <div class="card-header d-flex align-items-start pb-0">
                        <div>
                            <h2 id="uk-today" class="text-bold-700 text-white mb-0"> - </h2>
                            <p>
                                <strong>Revenue today</strong>
                            </p>
                        </div>
                        <div class="avatar bg-rgba-warning p-50 m-0">
                            <div class="avatar-content">
                                <i class="fa fa-angle-right text-warning font-medium-5"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="card yesterday bg-gradient-light">
                    <div class="card-header d-flex align-items-start pb-0">
                        <div>
                            <h2 id="uk-yesterday" class="text-bold-700 text-white mb-0"> - </h2>
                            <p>
                                <strong>Revenue yesterday</strong>
                            </p>
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
                <div class="card this-week bg-gradient-light">
                    <div class="card-header d-flex align-items-start pb-0">
                        <div>
                            <h2 id="uk-this-week" class="text-bold-700 text-white mb-0"> - </h2>
                            <p>
                                <strong>Revenue this week</strong>
                            </p>
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
                <div class="card this-month bg-gradient-light">
                    <div class="card-header d-flex align-items-start pb-0">
                        <div>
                            <h2 id="uk-this-month" class="text-bold-700 text-white mb-0"> - </h2>
                            <p>
                                <strong>Revenue this month</strong>
                            </p>
                        </div>
                        <div class="avatar bg-rgba-primary p-50 m-0">
                            <div class="avatar-content">
                                <i class="fa fa-angle-right text-primary font-medium-5"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ES -->
		<div class="row es-wrap match-height">
			<div class="col-12 flag-title mb-1">
				<h5 class="text-bold-600 ">
					<img src="{{ asset('images/flags/es.png') }}" width="40" height="40" class=" round mr-1" alt="card-img-left"> Spain
				</h5>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12">
				<div class="card bg-analyticss text-black">
					<div class="card-content">
						<div class="card-body text-center">


                            @if($top_campaigns['ES']->campaign_logo)
							<div class="text-center mb-1">

                                <img src="/storage/campaign_logo/{{  $top_campaigns['ES']->campaign_logo }}" alt="Campaign Logo" height="40" width="130">

							</div>
							<div class="text-center">
								<h4 class="mb-2 text-bold-600 text-black">Top Campaign of the Month</h4>
                                @if($top_campaigns['ES']->unique_clicks > 0)
                                    <p class="m-auto w-75">This campaign got an EPC of {{ number_format(( $top_campaigns['ES']->payout/ $top_campaigns['ES']->unique_clicks),2, ',','.'). " EUR from the last 30 days." }}</p>
                                @else
                                    <p class="m-auto w-75">Though, this campaign got an EPC of 0 from the last 30 days.</p>
                                @endif
                            </div>
                            @else
                            <div class="text-center pt-3 mb-1"> <h4 class="mb-2 text-bold-600 text-black">No Top Campaign of the Month</h4> </div>
                            @endif
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-2 col-md-12 col-sm-12">
				<div class="card bg-analyticss text-black">
					<div class="card-content">
						<div class="card-body text-center">
							<div class="text-center">
                                @if($top_feed_sites['ES'])
                                    <h6 class="mb-2 text-bold-600 text-black">{{ $top_feed_sites['ES']->click_source_site_name }}</h6>
                                    <p class="mb-2 text-bold-600 text-black">Top Feed Site of the Month</p>
                                    <small class="m-auto w-75">This feed site made <strong> {{ $top_feed_sites['ES']->clicks }} </strong> clicks with a total payout of {{ number_format($top_feed_sites['ES']->total_payout, 2) }} from the last 30 days </small>
                                @else
                                <p class="mb-2 pt-3 text-bold-600 text-black">No Top Feed Site of the Month</p>
                                <small class="m-auto w-75">No feed site made any click from the last 30 days. </small>
                                @endif

							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-2 col-md-12 col-sm-12">
				<div class="card bg-analyticss text-black">
					<div class="card-content">
						<div class="card-body text-center">
							<div class="text-center">
                                @if($top_aff_networks['ES'])
                                    <h6 class="mb-2 text-bold-600 text-black">{{ $top_aff_networks['ES']->affiliate_network_name }}</h6>
                                    <p class="mb-2 text-bold-600 text-black">Top Aff Network of the Month</p>
                                    <small class="m-auto w-75">This aff network made <strong> {{ $top_aff_networks['ES']->clicks }} </strong> clicks with a total payout of {{ number_format($top_aff_networks['ES']->total_payout, 2) }} from the last 30 days </small>
                                @else
                                <p class="mb-2 pt-3 text-bold-600 text-black">No Top Aff Network of the Month</p>
                                <small class="m-auto w-75">No aff network made any click from the last 30 days. </small>
                                @endif

							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-2 col-md-12 col-sm-12">
				<div class="card bg-analyticss text-black">
					<div class="card-content">
						<div class="card-body text-center">
							<div class="text-center">
                                @if($top_urls['ES'])
                                    <h6 class="mb-2 text-bold-600 text-black">{{ $top_urls['ES']->click_source_site_url }}</h6>
                                    <p class="mb-2 text-bold-600 text-black">Top Site Page of the Month</p>
                                    <small class="m-auto w-75">This site page made <strong> {{ $top_urls['ES']->clicks }} </strong> clicks with a total payout of {{ number_format($top_urls['ES']->total_payout, 2) }} from the last 30 days </small>
                                @else
                                    <p class="mb-2 pt-3 text-bold-600 text-black">No Top Site Page of the Month</p>
                                    <small class="m-auto w-75">No site page made any click from the last 30 days. </small>
                                @endif
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-3 col-sm-6 col-12">
				<div class="card today bg-gradient-light">
					<div class="card-header d-flex align-items-start pb-0">
						<div>
							<h2 id="es-today" class="text-bold-700 text-black mb-0"> - </h2>
							<p class="text-dark">
								<strong >Revenue today</strong>
							</p>
						</div>
						<div class="avatar bg-rgba-warning p-50 m-0">
							<div class="avatar-content">
								<i class="fa fa-angle-right text-warning font-medium-5"></i>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-3 col-sm-6 col-12">
				<div class="card yesterday bg-gradient-light">
					<div class="card-header d-flex align-items-start pb-0">
						<div>
							<h2 id="es-yesterday" class="text-bold-700 text-black mb-0"> - </h2>
							<p class="text-dark">
								<strong>Revenue yesterday</strong>
							</p>
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
				<div class="card this-week bg-gradient-light">
					<div class="card-header d-flex align-items-start pb-0">
						<div>
							<h2 id="es-this-week" class="text-bold-700 text-black mb-0"> - </h2>
							<p class="text-dark">
								<strong >Revenue this week</strong>
							</p>
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
				<div class="card this-month bg-gradient-light">
					<div class="card-header d-flex align-items-start pb-0">
						<div>
							<h2 id="es-this-month" class="text-bold-700 text-black mb-0"> - </h2>
							<p class="text-dark">
								<strong >Revenue this month</strong>
							</p>
						</div>
						<div class="avatar bg-rgba-primary p-50 m-0">
							<div class="avatar-content">
								<i class="fa fa-angle-right text-primary font-medium-5"></i>
							</div>
						</div>
					</div>
				</div>
			</div>
        </div>
        <!-- MX -->
        <div class="row mx-wrap match-height">
			<div class="col-12 flag-title mb-1">
				<h5 class="text-bold-600 ">
					<img src="{{ asset('images/flags/mx.jpg') }}" width="40" height="40" class=" round mr-1" alt="card-img-left"> Mexico
				</h5>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12">
				<div class="card bg-analyticss text-black">
					<div class="card-content">
						<div class="card-body text-center">


                            @if($top_campaigns['MX']->campaign_logo)
							<div class="text-center mb-1">

                                <img src="/storage/campaign_logo/{{  $top_campaigns['MX']->campaign_logo }}" alt="Campaign Logo" height="40" width="130">

							</div>
							<div class="text-center">
								<h4 class="mb-2 text-bold-600 text-black">Top Campaign of the Month</h4>
                                @if($top_campaigns['MX']->unique_clicks > 0)
                                    <p class="m-auto w-75">This campaign got an EPC of {{ number_format(( $top_campaigns['MX']->payout/$top_campaigns['MX']->unique_clicks),2, ',','.'). " MXN from the last 30 days." }}</p>
                                @else
                                    <p class="m-auto w-75">Though, this campaign got an EPC of 0 from the last 30 days.</p>
                                @endif
                            </div>
                            @else
                            <div class="text-center pt-3 mb-1"> <h4 class="mb-2 text-bold-600 text-black">No Top Campaign of the Month</h4> </div>
                            @endif
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-2 col-md-12 col-sm-12">
				<div class="card bg-analyticss text-black">
					<div class="card-content">
						<div class="card-body text-center">
							<div class="text-center">
                                @if($top_feed_sites['MX'])
                                    <h6 class="mb-2 text-bold-600 text-black">{{ $top_feed_sites['MX']->click_source_site_name }}</h6>
                                    <p class="mb-2 text-bold-600 text-black">Top Feed Site of the Month</p>
                                    <small class="m-auto w-75">This feed site made <strong> {{ $top_feed_sites['MX']->clicks }} </strong> clicks with a total payout of {{ number_format($top_feed_sites['MX']->total_payout, 2) }} from the last 30 days </small>
                                @else
                                <p class="mb-2 pt-3 text-bold-600 text-black">No Top Feed Site of the Month</p>
                                <small class="m-auto w-75">No feed site made any click from the last 30 days. </small>
                                @endif

							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-2 col-md-12 col-sm-12">
				<div class="card bg-analyticss text-black">
					<div class="card-content">
						<div class="card-body text-center">
							<div class="text-center">
                                @if($top_aff_networks['MX'])
                                    <h6 class="mb-2 text-bold-600 text-black">{{ $top_aff_networks['MX']->affiliate_network_name }}</h6>
                                    <p class="mb-2 text-bold-600 text-black">Top Aff Network of the Month</p>
                                    <small class="m-auto w-75">This aff network made <strong> {{ $top_aff_networks['MX']->clicks }} </strong> clicks with a total payout of {{ number_format($top_aff_networks['DK']->total_payout, 2) }} from the last 30 days </small>
                                @else
                                <p class="mb-2 pt-3 text-bold-600 text-black">No Top Aff Network of the Month</p>
                                <small class="m-auto w-75">No aff network made any click from the last 30 days. </small>
                                @endif

							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-2 col-md-12 col-sm-12">
				<div class="card bg-analyticss text-black">
					<div class="card-content">
						<div class="card-body text-center">
							<div class="text-center">
                                @if($top_urls['MX'])
                                    <h6 class="mb-2 text-bold-600 text-black">{{ $top_urls['MX']->click_source_site_url }}</h6>
                                    <p class="mb-2 text-bold-600 text-black">Top Site Page of the Month</p>
                                    <small class="m-auto w-75">This site page made <strong> {{ $top_urls['MX']->clicks }} </strong> clicks with a total payout of {{ number_format($top_urls['MX']->total_payout, 2) }} from the last 30 days </small>
                                @else
                                    <p class="mb-2 pt-3 text-bold-600 text-black">No Top Site Page of the Month</p>
                                    <small class="m-auto w-75">No site page made any click from the last 30 days. </small>
                                @endif
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-3 col-sm-6 col-12">
				<div class="card today bg-gradient-light">
					<div class="card-header d-flex align-items-start pb-0">
						<div>
							<h2 id="mx-today" class="text-bold-700 text-white mb-0"> - </h2>
							<p>
								<strong>Revenue today</strong>
							</p>
						</div>
						<div class="avatar bg-rgba-warning p-50 m-0">
							<div class="avatar-content">
								<i class="fa fa-angle-right text-warning font-medium-5"></i>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-3 col-sm-6 col-12">
				<div class="card yesterday bg-gradient-light">
					<div class="card-header d-flex align-items-start pb-0">
						<div>
							<h2 id="mx-yesterday" class="text-bold-700 text-white mb-0"> - </h2>
							<p>
								<strong>Revenue yesterday</strong>
							</p>
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
				<div class="card this-week bg-gradient-light">
					<div class="card-header d-flex align-items-start pb-0">
						<div>
							<h2 id="mx-this-week" class="text-bold-700 text-white mb-0"> - </h2>
							<p>
								<strong>Revenue this week</strong>
							</p>
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
				<div class="card this-month bg-gradient-light">
					<div class="card-header d-flex align-items-start pb-0">
						<div>
							<h2 id="mx-this-month" class="text-bold-700 text-white mb-0"> - </h2>
							<p>
								<strong>Revenue this month</strong>
							</p>
						</div>
						<div class="avatar bg-rgba-primary p-50 m-0">
							<div class="avatar-content">
								<i class="fa fa-angle-right text-primary font-medium-5"></i>
							</div>
						</div>
					</div>
				</div>
			</div>
        </div>
        <!-- FI -->
        <div class="row fi-wrap match-height">
            <div class="col-12 flag-title mb-1">
                <h5 class="text-bold-600 ">
                    <img src="{{ asset('images/flags/fi.jpg') }}" width="40" height="40" class=" round mr-1" alt="card-img-left"> Finland
                </h5>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12">
                <div class="card bg-analyticss text-black">
                    <div class="card-content">
                        <div class="card-body text-center">


                            @if($top_campaigns['FI']->campaign_logo)
                            <div class="text-center mb-1">

                                <img src="/storage/campaign_logo/{{  $top_campaigns['FI']->campaign_logo }}" alt="Campaign Logo" height="40" width="130">

                            </div>
                            <div class="text-center">
                                <h4 class="mb-2 text-bold-600 text-black">Top Campaign of the Month</h4>
                                @if( $top_campaigns['FI']->unique_clicks > 0)
                                    <p class="m-auto w-75">This campaign got an EPC of {{ number_format(( $top_campaigns['FI']->payout/$top_campaigns['FI']->unique_clicks),2, ',','.'). " EUR from the last 30 days." }}</p>
                                @else
                                    <p class="m-auto w-75">Though, this campaign got an EPC of 0 from the last 30 days.</p>
                                @endif
                            </div>
                            @else
                            <div class="text-center pt-3 mb-1"> <h4 class="mb-2 text-bold-600 text-black">No Top Campaign of the Month</h4> </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-12 col-sm-12">
                <div class="card bg-analyticss text-black">
                    <div class="card-content">
                        <div class="card-body text-center">
							<div class="text-center">
                                @if($top_feed_sites['FI'])
                                    <h6 class="mb-2 text-bold-600 text-black">{{ $top_feed_sites['FI']->click_source_site_name }}</h6>
                                    <p class="mb-2 text-bold-600 text-black">Top Feed Site of the Month</p>
                                    <small class="m-auto w-75">This feed site made <strong> {{ $top_feed_sites['FI']->clicks }} </strong> clicks with a total payout of {{ number_format($top_feed_sites['FI']->total_payout, 2) }} from the last 30 days </small>
                                @else
                                <p class="mb-2 pt-3 text-bold-600 text-black">No Top Feed Site of the Month</p>
                                <small class="m-auto w-75">No feed site made any click from the last 30 days. </small>
                                @endif

							</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-12 col-sm-12">
                <div class="card bg-analyticss text-black">
                    <div class="card-content">
                        <div class="card-body text-center">
							<div class="text-center">
                                @if($top_aff_networks['FI'])
                                    <h6 class="mb-2 text-bold-600 text-black">{{ $top_aff_networks['FI']->affiliate_network_name }}</h6>
                                    <p class="mb-2 text-bold-600 text-black">Top Aff Network of the Month</p>
                                    <small class="m-auto w-75">This aff network made <strong> {{ $top_aff_networks['FI']->clicks }} </strong> clicks with a total payout of {{ number_format($top_aff_networks['FI']->total_payout, 2) }} from the last 30 days </small>
                                @else
                                <p class="mb-2 pt-3 text-bold-600 text-black">No Top Aff Network of the Month</p>
                                <small class="m-auto w-75">No aff network made any click from the last 30 days. </small>
                                @endif

							</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-12 col-sm-12">
                <div class="card bg-analyticss text-black">
                    <div class="card-content">
                        <div class="card-body text-center">
							<div class="text-center">
                                @if($top_urls['FI'])
                                    <h6 class="mb-2 text-bold-600 text-black">{{ $top_urls['FI']->click_source_site_url }}</h6>
                                    <p class="mb-2 text-bold-600 text-black">Top Site Page of the Month</p>
                                    <small class="m-auto w-75">This site page made <strong> {{ $top_urls['FI']->clicks }} </strong> clicks with a total payout of {{ number_format($top_urls['FI']->total_payout, 2) }} from the last 30 days </small>
                                @else
                                    <p class="mb-2 pt-3 text-bold-600 text-black">No Top Site Page of the Month</p>
                                    <small class="m-auto w-75">No site page made any click from the last 30 days. </small>
                                @endif
							</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="card today bg-gradient-light">
                    <div class="card-header d-flex align-items-start pb-0">
                        <div>
                            <h2 id="fi-today" class="text-bold-700 text-white mb-0"> - </h2>
                            <p>
                                <strong>Revenue today</strong>
                            </p>
                        </div>
                        <div class="avatar bg-rgba-warning p-50 m-0">
                            <div class="avatar-content">
                                <i class="fa fa-angle-right text-warning font-medium-5"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="card yesterday bg-gradient-light">
                    <div class="card-header d-flex align-items-start pb-0">
                        <div>
                            <h2 id="fi-yesterday" class="text-bold-700 text-white mb-0"> - </h2>
                            <p>
                                <strong>Revenue yesterday</strong>
                            </p>
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
                <div class="card this-week bg-gradient-light">
                    <div class="card-header d-flex align-items-start pb-0">
                        <div>
                            <h2 id="fi-this-week" class="text-bold-700 text-white mb-0"> - </h2>
                            <p>
                                <strong>Revenue this week</strong>
                            </p>
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
                <div class="card this-month bg-gradient-light">
                    <div class="card-header d-flex align-items-start pb-0">
                        <div>
                            <h2 id="fi-this-month" class="text-bold-700 text-white mb-0"> - </h2>
                            <p>
                                <strong>Revenue this month</strong>
                            </p>
                        </div>
                        <div class="avatar bg-rgba-primary p-50 m-0">
                            <div class="avatar-content">
                                <i class="fa fa-angle-right text-primary font-medium-5"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- PL -->
        <div class="row pl-wrap match-height">
            <div class="col-12 flag-title mb-1">
                <h5 class="text-bold-600 ">
                    <img src="{{ asset('images/flags/pl.png') }}" width="40" height="40" class=" round mr-1" alt="card-img-left"> Poland
                </h5>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12">
                <div class="card bg-analyticss text-black">
                    <div class="card-content">
                        <div class="card-body text-center">


                            @if($top_campaigns['PL']->campaign_logo)
                            <div class="text-center mb-1">

                                <img src="/storage/campaign_logo/{{  $top_campaigns['PL']->campaign_logo }}" alt="Campaign Logo" height="40" width="130">

                            </div>
                            <div class="text-center">
                                <h4 class="mb-2 text-bold-600 text-black">Top Campaign of the Month</h4>
                                @if( $top_campaigns['PL']->unique_clicks > 0)
                                    <p class="m-auto w-75">This campaign got an EPC of {{ number_format(( $top_campaigns['PL']->payout/ $top_campaigns['PL']->unique_clicks),2, ',','.'). " EUR from the last 30 days." }}</p>
                                @else
                                    <p class="m-auto w-75">Though, this campaign got an EPC of 0 from the last 30 days.</p>
                                @endif
                            </div>
                            @else
                            <div class="text-center pt-3 mb-1"> <h4 class="mb-2 text-bold-600 text-black">No Top Campaign of the Month</h4> </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-12 col-sm-12">
                <div class="card bg-analyticss text-black">
                    <div class="card-content">
                        <div class="card-body text-center">
							<div class="text-center">
                                @if($top_feed_sites['PL'])
                                    <h6 class="mb-2 text-bold-600 text-black">{{ $top_feed_sites['PL']->click_source_site_name }}</h6>
                                    <p class="mb-2 text-bold-600 text-black">Top Feed Site of the Month</p>
                                    <small class="m-auto w-75">This feed site made <strong> {{ $top_feed_sites['PL']->clicks }} </strong> clicks with a total payout of {{ number_format($top_feed_sites['PL']->total_payout, 2) }} from the last 30 days </small>
                                @else
                                <p class="mb-2 pt-3 text-bold-600 text-black">No Top Feed Site of the Month</p>
                                <small class="m-auto w-75">No feed site made any click from the last 30 days. </small>
                                @endif

							</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-12 col-sm-12">
                <div class="card bg-analyticss text-black">
                    <div class="card-content">
                        <div class="card-body text-center">
							<div class="text-center">
                                @if($top_aff_networks['PL'])
                                    <h6 class="mb-2 text-bold-600 text-black">{{ $top_aff_networks['PL']->affiliate_network_name }}</h6>
                                    <p class="mb-2 text-bold-600 text-black">Top Aff Network of the Month</p>
                                    <small class="m-auto w-75">This aff network made <strong> {{ $top_aff_networks['PL']->clicks }} </strong> clicks with a total payout of {{ number_format($top_aff_networks['PL']->total_payout, 2) }} from the last 30 days </small>
                                @else
                                <p class="mb-2 pt-3 text-bold-600 text-black">No Top Aff Network of the Month</p>
                                <small class="m-auto w-75">No aff network made any click from the last 30 days. </small>
                                @endif

							</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-12 col-sm-12">
                <div class="card bg-analyticss text-black">
                    <div class="card-content">
                        <div class="card-body text-center">
							<div class="text-center">
                                @if($top_urls['PL'])
                                    <h6 class="mb-2 text-bold-600 text-black">{{ $top_urls['PL']->click_source_site_url }}</h6>
                                    <p class="mb-2 text-bold-600 text-black">Top Site Page of the Month</p>
                                    <small class="m-auto w-75">This site page made <strong> {{ $top_urls['PL']->clicks }} </strong> clicks with a total payout of {{ number_format($top_urls['PL']->total_payout, 2) }} from the last 30 days </small>
                                @else
                                    <p class="mb-2 pt-3 text-bold-600 text-black">No Top Site Page of the Month</p>
                                    <small class="m-auto w-75">No site page made any click from the last 30 days. </small>
                                @endif
							</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="card today bg-gradient-light">
                    <div class="card-header d-flex align-items-start pb-0">
                        <div>
                            <h2 id="pl-today" class="text-bold-700 text-white mb-0"> - </h2>
                            <p>
                                <strong>Revenue today</strong>
                            </p>
                        </div>
                        <div class="avatar bg-rgba-warning p-50 m-0">
                            <div class="avatar-content">
                                <i class="fa fa-angle-right text-warning font-medium-5"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="card yesterday bg-gradient-light">
                    <div class="card-header d-flex align-items-start pb-0">
                        <div>
                            <h2 id="pl-yesterday" class="text-bold-700 text-white mb-0"> - </h2>
                            <p>
                                <strong>Revenue yesterday</strong>
                            </p>
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
                <div class="card this-week bg-gradient-light">
                    <div class="card-header d-flex align-items-start pb-0">
                        <div>
                            <h2 id="pl-this-week" class="text-bold-700 text-white mb-0"> - </h2>
                            <p>
                                <strong>Revenue this week</strong>
                            </p>
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
                <div class="card this-month bg-gradient-light">
                    <div class="card-header d-flex align-items-start pb-0">
                        <div>
                            <h2 id="pl-this-month" class="text-bold-700 text-white mb-0"> - </h2>
                            <p>
                                <strong>Revenue this month</strong>
                            </p>
                        </div>
                        <div class="avatar bg-rgba-primary p-50 m-0">
                            <div class="avatar-content">
                                <i class="fa fa-angle-right text-primary font-medium-5"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</section>
</section>

<!-- Dashboard Analytics end -->
@endsection

@section('vendor-script')
        <!-- vendor files -->

@endsection
@section('page-script')
        <!-- Page js files -->
        <script src="{{ asset(mix('js/scripts/webix-list/statistics-page.js')) }}"></script>
        <script>
            $(window).on("load", function(){});
        </script>
@endsection
