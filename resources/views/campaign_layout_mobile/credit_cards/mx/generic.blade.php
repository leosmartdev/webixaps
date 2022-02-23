
<section id="campaigns">
    <div class="container">
    @foreach($campaigns as $campaign)
        @php $cefv = unserialize($campaign->campaign_extra_field_value); @endphp

        <div class="card">
            <a href="/comparison/go/feed/{{ $campaign->clean_url }}" target="_blank" class="tracking_url" rel="sponsored"></a>
            <div class="row top-wrapper">
                <div class="col-md-2 campaign-image-wrapper">
                    <img class="credit-img" src="https://ai.webixaps.com/storage/campaign_logo/{{  $campaign->campaign_logo }}" alt="{{  $campaign->campaign_name}}"  title="{{  $campaign->campaign_name}}" width="130" height="80">
                </div>
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-4  credit-range-wrapper text-center">
                            <p class="strong"> {{  $cefv['maximum_credit_amount'] }} {{ $localize['currency'] }} </p>
                            <small> {{ $localize['min_duration_credit'] }} </small>
                        </div>
                        <div class="col-md-3 duration-wrapper text-center">
                            <p class="strong"> {{  $cefv['yearly_fee'] }} {{ $localize['currency'] }}  </p>
                            <small> {{ $localize['maxStartupFee'] }} </small>
                        </div>
                        <div class="col-md-3 min-age-wrapper text-center">
                            <p class="strong"> {{  $cefv['credit_period'] }} {{ (isset($cefv['duration_type']) && $cefv['duration_type'] =='Months')?$localize['monthes']:$localize['days'] }} </p>
                            <small> {{ $localize['deferral'] }} </small>
                        </div>
                        <div class="col-md-2 rating-wrapper text-center">
                            <p class="strong">
                               @php
                                 $star_count = floor($campaign->rating / 20);
                                 $x = 1;
                                 while($x <= $star_count) {
                                    echo "&#9733;";
                                    $x++;
                                }
                               @endphp
                            </p>
                            <small> {{ $localize['evaluation'] }} </small>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 button-wrapper text-center">
                <a href="/comparison/go/feed/{{ $campaign->clean_url }}" target="_blank" class="btn btn-success btn-block" rel="sponsored"> {{ $localize['button1'] }} </a>
                </div>
            </div>
            <div class="row middle-wrapper ">
                <div class="col-md-2 sponsored-wrapper">
                   &nbsp;
                </div>
                <div class="col-md-8 row-wrapper text-center">
                @php
                    if ($cefv['credit_text_1'] != ""){
                        echo '<span class="text-wrapper">'.$cefv['credit_text_1']. '</span>';
                    }
                    if ($cefv['credit_text_2'] != ""){
                        echo '<span class="text-wrapper">'.$cefv['credit_text_2']. '</span>';
                    }
                    if ($cefv['credit_text_3'] != ""){
                        echo '<span class="text-wrapper">'.$cefv['credit_text_3']. '</span>';
                    }
                    if ($cefv['credit_text_4'] != ""){
                        echo '<span class="text-wrapper">'.$cefv['credit_text_4']. '</span>';
                    }
                @endphp
                </div>
                <div class="col-md-2 row-wrapper rights-wrapper">
                    &nbsp;
                </div>
            </div>


        </div>
        <div class="credit-example-wrapper">
            <p> {{ $localize['loan_example'] }}: {{ $cefv['credit_example'] }} </p>
        </div>
    @endforeach
    </div>
</section>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<style>
    .row.top-wrapper, .row.middle-wrapper {
        padding: 15px;
    }

    #campaigns {
        margin-bottom: 25px;
    }
    section#campaigns .container {
        padding: 0;
    }
    section#campaigns p {
        margin: 0;
        font-size: 14px;
    }
    .middle-wrapper p {
        width: 100%;
    }
    section#campaigns .card {
        overflow: hidden;
        position: relative;
        margin: .5rem 0 1rem;
        background-color: #f5f5f5;
        border-radius: 2px;
        box-shadow: 0 2px 5px 0 rgba(0,0,0,.16), 0 2px 10px 0 rgba(0,0,0,.12);
        box-sizing: inherit;
        margin-bottom: 5px;
        margin-top: 20px;

    }
    section#campaigns p.strong{
        font-weight: bolder;
    }
    section#campaigns .card small {
        font-size: 12px;
    }
    .button-wrapper a {
        background-color: #80ba05 !important;
        border-color: #4cae4c !important;
        color: white !important;
        box-shadow: 0 5px 11px 0 rgba(0,0,0,.18), 0 4px 5px 0 rgba(0,0,0,.15);
        font-size: 14px;
        text-transform: uppercase;
    }
    .middle-wrapper span {
        padding: 0 20px;
        font-size: 14px;
    }
    .rating-wrapper p {
        color: #7fba05;
    }
    .credit-example-wrapper p {
        font-size: 10px !important;
        color: #5d5d5d;
    }
    .sponsored-wrapper, .rights-wrapper {
        font-size: 12px;
    }
    a.tracking_url {
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        z-index: 2;
    }
    .row.middle-wrapper {
        padding-top: 0;
    }
    .text-wrapper{
        background: url("{{ url('/images/icons/checkmark-job.png') }}") no-repeat;
        padding-left: 30px !important;
        background-size: 18px;
        background-position: 5px 2px;
    }
</style>
