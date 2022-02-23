@extends('campaign_layout.feed')

@section('content')
    <section id="campaigns">
        <div class="container-fluid p-0">
            @foreach($campaigns as $campaign)
                @php $cefv = unserialize($campaign->campaign_extra_field_value); @endphp
                <div class="card">
                    <a href="/comparison/go/feed/{{ $campaign->clean_url }}" target="_blank" class="tracking_url" rel="sponsored"></a>
                    <div class="card-body">
                        <div class="row m-0">
                            <div class="d-md-flex col-lg-6 left-section">
                                <div class="col-12 col-md-4 ">
                                    <div class="col-12 text-center mb-2 p-0">
                                        <img src="https://ai.webixaps.com/storage/campaign_logo/{{  $campaign->campaign_logo }}"
                                             alt="{{  $campaign->campaign_name}}" title="{{  $campaign->campaign_name}}"
                                             width="130" height="40">
                                    </div>
                                    <div class="col-12 rating-wrapper text-center p-0">
                                        <h6>
                                            @php
                                                $star_count = floor($campaign->rating / 20);
                                                $x = 1;
                                                while($x <= $star_count) {
                                                   echo "&#9733;";
                                                   $x++;
                                               }
                                            @endphp
                                        </h6>
                                    </div>
                                </div>
                                <div class="col-12 col-md-8">
                                    <table class="table">
                                        <tbody>
                                        <tr>
                                            <td>{{ $localize['loans_between'] }}</td>
                                            <th class="text-right">{{  $cefv['minimum_loan_amount'] }}
                                                - {{ $cefv['maximum_loan_amount'] }} {{ $localize['currency'] }}</th>
                                        </tr>
                                        <tr>
                                            <td>{{ $localize['runningtime'] }}</td>
                                            <th class="text-right">{{  $cefv['minimum_duration'] }}
                                                - {{ $cefv['maximum_duration'] }} {{ (isset($cefv['duration_type']) && $cefv['duration_type'] =='Months')?$localize['monthes']:$localize['days'] }}</th>
                                        </tr>
                                        <tr>
                                            <td>{{ $localize['min_age'] }}</td>
                                            <th class="text-right">{{  $cefv['minimum_age'] }} {{ $localize['age'] }}</th>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="d-md-flex col-lg-6 right-section">
                                <div class="col-12 col-md-6 align-self-center p-0 mb-2 mb-lg-0">
                                    <ul class="list-group list-group-flush m-0">
                                        @php
                                            if ($cefv['loan_text_1'] != ""){
                                                echo '<li class="list-group-item pl-0 pr-0 pb-2"><p class="text-wrapper">'.$cefv['loan_text_1']. '</p></li>';
                                            }
                                            if ($cefv['loan_text_2'] != ""){
                                                echo '<li class="list-group-item pl-0 pr-0 pb-2"><p class="text-wrapper">'.$cefv['loan_text_2']. '</p></li>';
                                            }
                                            if ($cefv['loan_text_3'] != ""){
                                                echo '<li class="list-group-item pl-0 pr-0 pb-2"><p class="text-wrapper">'.$cefv['loan_text_3']. '</p></li>';
                                            }
                                            if ($cefv['loan_text_4'] != ""){
                                                echo '<li class="list-group-item pl-0 pr-0 pb-2"><p class="text-wrapper">'.$cefv['loan_text_4']. '</p></li>';
                                            }
                                        @endphp
                                    </ul>
                                </div>
                                <div class="col-12 col-md-6 align-self-center mb-2 mt-2 mt-lg-0 mb-lg-0">
                                    <a href="/comparison/go/feed/{{ $campaign->clean_url }}" target="_blank"
                                       class="btn custom-btn-success btn-block" rel="sponsored"> {{ $localize['button1'] }} </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <p> {{ $localize['loan_example'] }}: {{ $cefv['loan_example'] }} </p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endsection
