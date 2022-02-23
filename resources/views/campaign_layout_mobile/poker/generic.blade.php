@extends('campaign_layout.feed')

@section('content')
    <section id="casino_campaigns">
        <div class="container-fluid p-0">

            <div class="header d-none d-md-flex text-center mb-2">
                <div class="col-3">
                    <div class="w-25 float-left">
                        <p class="rank text-left">{{ $localize['casino_rank'] }}</p>
                    </div>
                    <div class="w-75">
                        <p>{{ $localize['casino_website'] }}</p>
                    </div>
                </div>
                <div class="col-3"><p>{{ $localize['casino_bonus'] }}</p></div>
                <div class="col-2"><p>{{ $localize['casino_cashout'] }}</p></div>
                <div class="col-2"><p>{{ $localize['casino_rating'] }}</p></div>
                <div class="col-2"><p>{{ $localize['casino_sign_up'] }}</p></div>
            </div>
            @php
                $i = 0;
            @endphp
            @foreach($campaigns as $campaign)
                @php $cefv = unserialize($campaign->campaign_extra_field_value); $i++; @endphp
                <div class="card card-casino">
                    <div class="card-body">
                        <div class="row m-0">
                            <div class="col-md-3 card-casino-section-1  d-flex justify-content-center flex-row">
                                <div class="w-25 d-none d-md-flex justify-content-center flex-column">
                                    <p class="nr">{{$i}}</p>
                                </div>
                                <div class="w-75">
                                    <a class="d-flex align-items-center flex-column flex-md-row text-decoration-none"
                                       href="/comparison/go/feed/{{ $campaign->clean_url }}" target="_blank" rel="sponsored">
                                        <img class="loan-img mr-2 mb-2 mb-lg-0"
                                             src="https://ai.webixaps.com/storage/campaign_logo/{{  $campaign->campaign_logo }}"
                                             alt="{{  $campaign->campaign_name}}"
                                             title="{{  $campaign->campaign_name}}">
                                        <p class="text-bold-600 text m-0">{{$cefv['brandname'] ?? $campaign->campaign_name}}</p>
                                    </a>
                                </div>
                            </div>


                            <div class="col-md-3 card-casino-section-2 d-flex flex-column justify-content-center align-items-center">
                                <p class="text">{{$cefv['bonus_text'] ?? ''}}</p>
                            </div>
                            <div class="col-md-2 card-casino-section-3 d-flex justify-content-center align-items-center">
                                <p class="text">{{$cefv['requiremts'] ?? ''}}</p>
                            </div>
                            <div class="col-md-2 card-casino-section-4 text-center d-flex justify-content-center flex-column">
                                <div class="d-flex mb-2 justify-content-center">
                                    @php
                                        $star_count = floor($campaign->rating / 20);
                                        $x = 1;
                                        while($x <= $star_count) {
                                           echo '<div class="star">&#9733;</div>';
                                           $x++;
                                       }
                                       for ($xi = $star_count; $xi <5; $xi++){
                                         echo '<div class="star shadow">&#9733;</div>';
                                       }
                                    @endphp
                                </div>
                                @if(isset($cefv['review_link']))
                                    <a href="{{$cefv['review_link']}}"
                                       class="link">{{ $localize['casino_see_full_review'] }}</a>
                                @else
                                    <p class="link text-decoration-none">{{ $localize['casino_see_full_review'] }}</p>
                                @endif
                            </div>
                            <div class="col-md-2 align-self-center text-center card-casino-section-5">
                                @if(isset($cefv['promocode']) && $cefv['promocode'] != '' && strtolower(trim($cefv['promocode'])) != 'no code')
                                    <div class="form mb-2">
                                        <input type="text" id="promo-code-{{$i}}" class="promo-code"
                                               value="{{$cefv['promocode'] ?? ''}}"
                                               name="promo-code" readonly>
                                        <button class="button" onclick="copyFunc('promo-code-{{$i}}')">Copy</button>
                                    </div>
                                @endif
                                <div>
                                    <a href="/comparison/go/feed/{{ $campaign->clean_url }}" target="_blank"
                                       class="btn text-uppercase" rel="sponsored">{{ $localize['casino_get_bonus'] }}</a>
                                    @if(isset($cefv['advertising_text']))
                                        <p class="mt-2" style="font-size: 0.8rem;">{{$cefv['advertising_text']}}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @if(isset($cefv['terms']))
                        <div class="card-footer">
                            <p>{!! $cefv['terms'] !!}</p>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </section>
    <script>
      function copyFunc(id) {
        var copyText = document.getElementById(id);
        copyText.select();
        copyText.setSelectionRange(0, 99999);
        document.execCommand("copy");
      }
    </script>
@endsection

