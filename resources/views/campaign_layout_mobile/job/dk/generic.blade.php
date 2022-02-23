<section id="campaigns">

    @foreach($campaigns as $campaign)
        @php $cefv = unserialize($campaign->campaign_extra_field_value); @endphp

        <div class="card">
            <a href="/comparison/go/feed/{{ $campaign->clean_url }}" target="_blank" class="tracking_url" rel="sponsored"></a>
            <div class="row top-wrapper">
                <div class="col-md-12 campaign-image-wrapper text-center">
                    <img class="job-img" src="https://ai.webixaps.com/storage/campaign_logo/{{  $campaign->campaign_logo }}" title="{{  $campaign->campaign_name}}" alt="{{  $campaign->campaign_name}}" width="130" height="40">
                </div>
                <div class="col-md-12 sponsored-wrapper text-center">
                    {{ $localize['sponsoreret'] }}
                </div>
                <div class="col-md-12 rating-wrapper text-center">
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
                <div class="col-md-12 job-info job-range-wrapper">
                    <div class="left">  {{ $localize['insurrance_subscription'] }} </div>
                    <div class="right strong">  {{  $cefv['insurance_subscription'] }} {{ $localize['currency'] }}  </div>
                </div>
                <div class="col-md-12 job-info duration-wrapper">
                    <div class="left"> {{ $localize['open_for'] }} </div>
                    <div class="right strong"> {{  $cefv['members'] }}  </div>
                </div>
                <div class="col-md-12 job-info age-wrapper">
                    <div class="left"> {{ $localize['trade_union'] }} </div>
                    <div class="right strong"> {{  $cefv['union_subscription'] }} {{ $localize['currency'] }}  </div>
                </div>
                @php
                if ($cefv['job_text_1'] != ""){
                    echo '<div class="col-md-12 job-info text-center"><span class="text-wrapper">'.$cefv['job_text_1']. '</span></div>';
                }
                if ($cefv['job_text_2'] != ""){
                    echo '<div class="col-md-12 job-info text-center"><span class="text-wrapper"> '.$cefv['job_text_2']. '</span></div>';
                }
                if ($cefv['job_text_3'] != ""){
                    echo '<div class="col-md-12 job-info text-center"><span class="text-wrapper">'.$cefv['job_text_3']. '</span></div>';
                }
                if ($cefv['job_text_4'] != ""){
                    echo '<div class="col-md-12 job-info text-center"><span class="text-wrapper"> '.$cefv['job_text_4']. '</span></div>';
                }
                @endphp
                <div class="col-md-2 button-wrapper text-center">
                    <a href="/comparison/go/feed/{{ $campaign->clean_url }}" target="_blank" class="btn btn-success btn-block" rel="sponsored"> {{ $localize['button1'] }} </a>
                </div>
                <div class="col-md-12 row-wrapper text-center rights-wrapper">
                    {{ $localize['14_days_forry'] }}
                </div>

            </div>


        </div>

    @endforeach

</section>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<style>
    .row.top-wrapper, .row.middle-wrapper {
        padding: 15px;
    }

    .card .right {
        width: 48%;
        display: inline-block;
        text-align: right;
        font-weight: bold;
    }
    .card .left {
        width: 48%;
        display: inline-block;
        text-align: left;
        margin: 0;
        color: #5d5d5d;

    }
    .job-info {
        border-bottom: solid 1px #d6cfcf;
        margin: 5px 10px !important;
        padding: 0;
        padding-bottom: 5px;
        font-size: 14px;
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
    }
    .middle-wrapper span {
        padding: 0 20px;
    }
    .rating-wrapper p {
        color: #7fba05;
    }
    .job-example-wrapper p {
        font-size: 10px !important;
        color: #5d5d5d;
    }
    .sponsored-wrapper, .rights-wrapper {
        font-size: 12px;
        margin: 10px 0;
    }
    a.tracking_url {
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        z-index: 2;
    }
    .rating-wrapper {
        margin-bottom: 10px;
    }
    .button-wrapper {
        margin-top: 10px;
    }
    .text-wrapper{
        background: url("{{ url('/images/icons/checkmark-job.png') }}") no-repeat;
        padding-left: 30px !important;
        background-size: 18px;
        background-position: 5px 5px;
        display: inline-flex;
        width: auto;
    }
</style>
