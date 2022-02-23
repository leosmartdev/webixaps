<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ClickEvent extends Model
{
    protected $table = 'click_events';

    protected $fillable = [
        "campaign_id",
        "campaign_country",
        "campaign_feed_category",
        "campaign_affiliate_network",
        "client_ip_address",
        "client_country",
        "client_region",
        "client_city",
        "client_platform",
        "client_device",
        "client_browser",
        "click_type",
        "click_source_site_url",
        "click_source_site_name",
        "click_source_site_domain",
        "click_destination",
        "utm_source",
        "utm_medium",
        "utm_content",
        "utm_campaign",
        "customer"
    ];

    public static function getClickEvents($request){

        $clicks = DB::table('click_events')
        ->join('campaigns', 'click_events.campaign_id', '=', 'campaigns.id')
        ->join('affiliate_networks', 'click_events.campaign_affiliate_network', '=', 'affiliate_networks.id')
        ->select(
            'click_events.id',
            'campaigns.campaign_name as campaign_id',
            'click_events.campaign_country',
            'click_events.campaign_feed_category',
            'affiliate_networks.affiliate_network_name as campaign_affiliate_network',
            'click_events.click_type',
            'click_events.utm_content',
            'click_events.utm_medium',
            'click_events.payout',
            'click_events.conversion_status',
            'click_events.created_at'
        );

        if ($request->has('filter')){
            if ($request->get('campaign_id') != "All") {
                $clicks->where('click_events.campaign_id', $request->get('campaign_id'));
            }


            if ($request->get('country_name') != "All") {
                $clicks->where('click_events.campaign_country', $request->get('country_name'));
            }

            if ($request->has('period_from') && $request->has('period_to')) {
                $date_start = new Carbon($request->get('period_from'));
                $date_end = new Carbon($request->get('period_to'));
                $clicks->whereBetween('click_events.created_at', [$date_start->format('Y-m-d')." 00:00:00", $date_end->format('Y-m-d')." 23:59:59"]);
            }
        }else{
            $date_start = new Carbon(date('j F, Y'));
            $date_end = new Carbon(date('j F, Y'));
            $clicks->whereBetween('click_events.created_at', [$date_start->format('Y-m-d')." 00:00:00", $date_end->format('Y-m-d')." 23:59:59"]);
        }

        $result = $clicks->orderBy('click_events.created_at', 'desc')->get();

        return $result;

    }

  public static function getClickEventsConversions()
  {
    return DB::table('click_events')
      ->join('postbacks', 'click_events.id', '=', 'postbacks.click_event_id')
      ->join('affiliate_networks', 'click_events.campaign_affiliate_network', '=', 'affiliate_networks.id')
      ->select(
        'click_events.click_source_site_url as id',
        'affiliate_networks.affiliate_network_name as campaign_name',
        'click_events.payout as payout',
        'click_events.currency as currency',
        'postbacks.created_at as created_at'
      )
      ->whereNotNull('click_events.click_source_site_url')
      ->whereNotNull('click_events.payout')
      ->whereDate('click_events.created_at', '>=', Carbon::now()->subDays(30))
      ->get();
  }

    public static function getTopFeedSite($country_name){
        $date_start = Carbon::now()->subDays(30);
        $date_end = Carbon::now();

        $statistics = DB::table('click_events');
        $statistics->select('click_source_site_name',
         DB::raw('count(click_source_site_name) as clicks'),
         DB::raw('sum(payout) as total_payout')
        );

        $statistics->whereBetween('created_at', [$date_start->format('Y-m-d')." 00:00:00", $date_end->format('Y-m-d')." 23:59:59"]);
        $statistics->where('campaign_country', $country_name);
        $statistics->groupBy('click_source_site_name');


        $result = $statistics->orderBy('total_payout', 'desc')->first();
        return $result;
    }

    public static function getTopAffiliateNetwork($country_name){
        $date_start = Carbon::now()->subDays(30);
        $date_end = Carbon::now();

        $statistics = DB::table('click_events')->join('affiliate_networks', 'click_events.campaign_affiliate_network', '=', 'affiliate_networks.id');
        $statistics->select('affiliate_networks.affiliate_network_name',
         DB::raw('count(click_events.campaign_affiliate_network) as clicks'),
         DB::raw('sum(click_events.payout) as total_payout')
        );

        $statistics->whereBetween('click_events.created_at', [$date_start->format('Y-m-d')." 00:00:00", $date_end->format('Y-m-d')." 23:59:59"]);
        $statistics->where('click_events.campaign_country', $country_name);
        $statistics->groupBy('affiliate_networks.affiliate_network_name');


        $result = $statistics->orderBy('total_payout', 'desc')->first();

        return $result;
    }

    public static function getTopURL($country_name){
        $date_start = Carbon::now()->subDays(30);
        $date_end = Carbon::now();

        $statistics = DB::table('click_events');
        $statistics->select('click_source_site_url',
         DB::raw('count(click_source_site_url) as clicks'),
         DB::raw('sum(payout) as total_payout')
        );

        $statistics->whereBetween('created_at', [$date_start->format('Y-m-d')." 00:00:00", $date_end->format('Y-m-d')." 23:59:59"]);
        $statistics->where('campaign_country', $country_name);
        $statistics->groupBy('click_source_site_url');


        $result = $statistics->orderBy('total_payout', 'desc')->first();
        return $result;
    }

    public static function getCampaignTopDetails($campaign_id){




        $date_start = Carbon::now()->subDays(30);
        $date_end = Carbon::now();
        $statistics = DB::table('click_events');
        $statistics->select(
        DB::raw('count(click_source_site_url) as clicks'),
        DB::raw('sum(payout) as total_payout')
       );
        $statistics->whereBetween('created_at', [$date_start->format('Y-m-d')." 00:00:00", $date_end->format('Y-m-d')." 23:59:59"]);
        $statistics->where('campaign_id', $campaign_id);


        $result = $statistics->orderBy('click_events.created_at', 'desc')->get();

        return $result;

    }


    public static function getCampaignTotalClicks($campaign_id , $request){
        $endDate = Carbon::now(); //returns current day
        $date_now = Carbon::now();
        $firstDay = Carbon::now();


        $statistics = DB::table('click_events')
        ->select(
            DB::raw('count(case click_type when \'Unique\' then 1 end) as unique_clicks'),
            DB::raw('count(case click_type when \'Non-Unique\' then 1 end) as non_unique_clicks')
        );
        $statistics->whereBetween('updated_at', [$firstDay->format('Y-m-d')." 00:00:00", $endDate->format('Y-m-d')." 23:59:59"]);
        /*if ($request->has('postback')){
            $statistics->where('payout', '>', 0);
        }*/
        $statistics->where('campaign_id', $campaign_id);
        $result = $statistics->first();

        return $result;
    }


    public static function getCampaignTopFeedSite($campaign_id , $request){
        $endDate = Carbon::now(); //returns current day
        $date_now = Carbon::now();
        $firstDay = Carbon::now();

        $statistics = DB::table('click_events');
        $statistics->select('click_source_site_name',
         DB::raw('count(click_source_site_name) as clicks'),
         DB::raw('sum(payout) as total_payout')
        );

        $statistics->whereBetween('updated_at', [$firstDay->format('Y-m-d')." 00:00:00", $endDate->format('Y-m-d')." 23:59:59"]);
        if ($request->has('postback')){
            $statistics->where('click_events.payout', '>', 0);
        }
        $statistics->where('campaign_id', $campaign_id);
        $statistics->groupBy('click_source_site_name');


        $result = $statistics->orderBy('total_payout', 'desc')->first();
        return $result;
    }


    public static function getCampaignTotalPostback($campaign_id , $request){




        $endDate = Carbon::now(); //returns current day
        $date_now = Carbon::now();
        $firstDay = Carbon::now();



        $statistics = DB::table('click_events')
        ->select(
            DB::raw('count(case when payout > 0 then 1 else null end) as total_postback')
        );
        $statistics->whereBetween('updated_at', [$firstDay->format('Y-m-d')." 00:00:00", $endDate->format('Y-m-d')." 23:59:59"]);
        if ($request->has('postback')){
            $statistics->where('click_events.payout', '>', 0);
        }
        $statistics->where('campaign_id', $campaign_id);
        $result = $statistics->first();

        return $result;

    }

    public static function getCampaignTotalPayout($campaign_id , $request){




        $endDate = Carbon::now(); //returns current day
        $date_now = Carbon::now();
        $firstDay = Carbon::now();



        $statistics = DB::table('click_events')
        ->select(
            DB::raw('sum(payout) as total_payout')
        );
        $statistics->whereBetween('updated_at', [$firstDay->format('Y-m-d')." 00:00:00", $endDate->format('Y-m-d')." 23:59:59"]);
        if ($request->has('postback')){
            $statistics->where('click_events.payout', '>', 0);
        }
        $statistics->where('campaign_id', $campaign_id);
        $result = $statistics->first();

        return $result;

    }

    public static function getUTMS($request, $utm_key){

        $utms = DB::table('click_events')->select($utm_key);
        if ($request->has('filter')){
            if ($request->has('period_from') && $request->has('period_to')) {
                $date_start = new Carbon($request->get('period_from'));
                $date_end = new Carbon($request->get('period_to'));
                $utms->whereBetween('click_events.updated_at', [$date_start->format('Y-m-d')." 00:00:00", $date_end->format('Y-m-d')." 23:59:59"]);
            }
        }else{
            $date_start = new Carbon(date('j F, Y'));
            $date_end = new Carbon(date('j F, Y'));
            $utms->whereBetween('click_events.updated_at', [$date_start->format('Y-m-d')." 00:00:00", $date_end->format('Y-m-d')." 23:59:59"]);
        }
        if ($request->has('postback')){
            $utms->where('click_events.payout', '>', 0);
        }

        $result = $utms->whereNotNull($utm_key)->distinct()->get();

        return $result;

    }

    public static function getChartsData($request, $key){
        $chart = DB::table('click_events')->select(
            $key,
            DB::raw('count(*) as count')
            );
        if ($request->has('filter')){
            if ($request->has('period_from') && $request->has('period_to')) {
                $date_start = new Carbon($request->get('period_from'));
                $date_end = new Carbon($request->get('period_to'));
                $chart->whereBetween('click_events.updated_at', [$date_start->format('Y-m-d')." 00:00:00", $date_end->format('Y-m-d')." 23:59:59"]);
            }
        }else{
            $date_start = new Carbon(date('j F, Y'));
            $date_end = new Carbon(date('j F, Y'));
            $chart->whereBetween('click_events.updated_at', [$date_start->format('Y-m-d')." 00:00:00", $date_end->format('Y-m-d')." 23:59:59"]);
        }
        if ($request->has('postback')){
            $chart->where('click_events.payout', '>', 0);
        }
        $result = $chart->whereNotNull($key)->groupBy($key)->orderBy('count', 'desc')->limit(5)->get();

        return $result;
    }

    public static function getCampaignTotalNonUniquePostback($campaign_id , $request){
        $endDate = Carbon::now(); //returns current day
        $date_now = Carbon::now();
        $firstDay = Carbon::now();


        $statistics = DB::table('click_events')
        ->select(
            DB::raw('count(case when click_events.payout > 0 and click_events.click_type = \'Non-Unique\' then 1 else null end) as click_count')
        );
        $statistics->whereBetween('updated_at', [$firstDay->format('Y-m-d')." 00:00:00", $endDate->format('Y-m-d')." 23:59:59"]);
        if ($request->has('postback')){
            $statistics->where('click_events.payout', '>', 0);
        }
        $statistics->where('campaign_id', $campaign_id);
        $result = $statistics->first();

        return $result;
    }

    public static function getClickEventsByCampaign($request, $campaign_id){

        $clicks = DB::table('click_events')
        ->join('campaigns', 'click_events.campaign_id', '=', 'campaigns.id')
        ->join('affiliate_networks', 'click_events.campaign_affiliate_network', '=', 'affiliate_networks.id')
        ->select(
            'click_events.id',
            'campaigns.campaign_name as campaign_id',
            'click_events.campaign_country',
            'click_events.campaign_feed_category',
            'affiliate_networks.affiliate_network_name as campaign_affiliate_network',
            'click_events.click_type',
            'click_events.utm_content',
            'click_events.utm_medium',
            'click_events.payout',
            'click_events.conversion_status',
            'click_events.client_city',
            'click_events.client_device',
            'click_events.client_browser',
            'click_events.client_platform',
            'click_events.updated_at',
            'click_events.created_at'
        );

        if ($request->has('filter')){


            if ($request->has('period_from') && $request->has('period_to')) {
                $date_start = new Carbon($request->get('period_from'));
                $date_end = new Carbon($request->get('period_to'));
                $clicks->whereBetween('click_events.updated_at', [$date_start->format('Y-m-d')." 00:00:00", $date_end->format('Y-m-d')." 23:59:59"]);
            }
        }else{
            $date_start = new Carbon(date('j F, Y'));
            $date_end = new Carbon(date('j F, Y'));
            $clicks->whereBetween('click_events.updated_at', [$date_start->format('Y-m-d')." 00:00:00", $date_end->format('Y-m-d')." 23:59:59"]);
        }

        if ($request->has('postback')){
            $clicks->where('click_events.payout', '>', 0);
        }
        $clicks->where('click_events.campaign_id', $campaign_id);
        $result = $clicks->orderBy('click_events.updated_at', 'desc')->get();

        return $result;

    }

    public static function getCampaignChartsData($request, $campaign_id ,$key){
        $chart = DB::table('click_events')->select(
            $key,
            DB::raw('count(*) as count')
            );
        if ($request->has('filter')){
            if ($request->has('period_from') && $request->has('period_to')) {
                $date_start = new Carbon($request->get('period_from'));
                $date_end = new Carbon($request->get('period_to'));
                $chart->whereBetween('click_events.updated_at', [$date_start->format('Y-m-d')." 00:00:00", $date_end->format('Y-m-d')." 23:59:59"]);
            }
        }else{
            $date_start = new Carbon(date('j F, Y'));
            $date_end = new Carbon(date('j F, Y'));
            $chart->whereBetween('click_events.updated_at', [$date_start->format('Y-m-d')." 00:00:00", $date_end->format('Y-m-d')." 23:59:59"]);
        }
        if ($request->has('postback')){
            $chart->where('click_events.payout', '>', 0);
        }
        $chart->where('click_events.campaign_id', $campaign_id);
        $result = $chart->whereNotNull($key)->groupBy($key)->orderBy('count', 'desc')->limit(5)->get();

        return $result;
    }


    public static function getStatisticsByDomains($request){

        $clicks = DB::table('click_events')
        ->join('campaigns', 'click_events.campaign_id', '=', 'campaigns.id')
        ->join('affiliate_networks', 'click_events.campaign_affiliate_network', '=', 'affiliate_networks.id')
        ->select(
            'click_events.click_source_site_domain',
            DB::raw('count(click_events.id) as clicks'),
            DB::raw('count(case click_events.click_type when \'Unique\' then 1 else null end) as unique_clicks'),
            DB::raw('count(case click_events.click_type when \'Non-Unique\' then 1 else null end) as non_unique_clicks'),
            DB::raw('count(case when click_events.payout > 0 and click_events.click_type = \'Non-Unique\' then 1 else null end) as click_count'),
            DB::raw('count(case when click_events.payout > 0 then 1 else null end) as conversions'),
            DB::raw('sum(click_events.payout) as payout')
        );

        if ($request->has('filter')){
            /*if ($request->get('campaign_id') != "All") {
                $clicks->where('click_events.campaign_id', $request->get('campaign_id'));
            }


            if ($request->get('country_name') != "All") {
                $clicks->where('click_events.campaign_country', $request->get('country_name'));
            }*/

            if ($request->get('utm_source') != "All") {
                $clicks->where('click_events.utm_source', $request->get('utm_source'));
            }
            if ($request->get('utm_medium') != "All") {
                $clicks->where('click_events.utm_medium', $request->get('utm_medium'));
            }
            if ($request->get('utm_content') != "All") {
                $clicks->where('click_events.utm_content', $request->get('utm_content'));
            }

            if ($request->has('period_from') && $request->has('period_to')) {
                $date_start = new Carbon($request->get('period_from'));
                $date_end = new Carbon($request->get('period_to'));
                $clicks->whereBetween('click_events.updated_at', [$date_start->format('Y-m-d')." 00:00:00", $date_end->format('Y-m-d')." 23:59:59"]);
            }
        }else{
            $date_start = new Carbon(date('j F, Y'));
            $date_end = new Carbon(date('j F, Y'));
            $clicks->whereBetween('click_events.updated_at', [$date_start->format('Y-m-d')." 00:00:00", $date_end->format('Y-m-d')." 23:59:59"]);
        }

        $clicks->groupBy('click_events.click_source_site_domain');
        $result = $clicks->orderBy('click_events.updated_at', 'desc')->get();

        return $result;

    }

    public static function getStatisticsByDomain($request){

        $clicks = DB::table('click_events')
        ->join('campaigns', 'click_events.campaign_id', '=', 'campaigns.id')
        ->join('affiliate_networks', 'click_events.campaign_affiliate_network', '=', 'affiliate_networks.id')
        ->select(
            'click_events.click_source_site_domain',
            DB::raw('count(click_events.id) as clicks'),
            DB::raw('count(case click_events.click_type when \'Unique\' then 1 else null end) as unique_clicks'),
            DB::raw('count(case click_events.click_type when \'Non-Unique\' then 1 else null end) as non_unique_clicks'),
            DB::raw('count(case when click_events.payout > 0 and click_events.click_type = \'Non-Unique\' then 1 else null end) as click_count'),
            DB::raw('count(case when click_events.payout > 0 then 1 else null end) as conversions'),
            DB::raw('sum(click_events.payout) as payout')
        );

        if ($request->has('filter')){


            if ($request->has('utm_source') && $request->get('utm_source') != "All") {
                $clicks->where('click_events.utm_source', $request->get('utm_source'));
            }
            if ($request->has('utm_medium') && $request->get('utm_medium') != "All") {
                $clicks->where('click_events.utm_medium', $request->get('utm_medium'));
            }
            if ($request->has('utm_content') && $request->get('utm_content') != "All") {
                $clicks->where('click_events.utm_content', $request->get('utm_content'));
            }

            if ($request->has('period_from') && $request->has('period_to')) {
                $date_start = new Carbon($request->get('period_from'));
                $date_end = new Carbon($request->get('period_to'));
                $clicks->whereBetween('click_events.updated_at', [$date_start->format('Y-m-d')." 00:00:00", $date_end->format('Y-m-d')." 23:59:59"]);
            }
        }else{
            $date_start = new Carbon(date('j F, Y'));
            $date_end = new Carbon(date('j F, Y'));
            $clicks->whereBetween('click_events.updated_at', [$date_start->format('Y-m-d')." 00:00:00", $date_end->format('Y-m-d')." 23:59:59"]);
        }

        $clicks->where('click_events.click_source_site_domain',$request->get('name'));
        $result = $clicks->orderBy('click_events.updated_at', 'desc')->first();

        return $result;

    }

    public static function getClickEventsByDomain($request, $site_name){

        $clicks = DB::table('click_events')
        ->join('campaigns', 'click_events.campaign_id', '=', 'campaigns.id')
        ->join('affiliate_networks', 'click_events.campaign_affiliate_network', '=', 'affiliate_networks.id')
        ->select(
            'click_events.id',
            'campaigns.campaign_name as campaign_id',
            'click_events.campaign_country',
            'click_events.campaign_feed_category',
            'affiliate_networks.affiliate_network_name as campaign_affiliate_network',
            'click_events.click_type',
            'click_events.utm_content',
            'click_events.utm_medium',
            'click_events.payout',
            'click_events.conversion_status',
            'click_events.client_city',
            'click_events.client_device',
            'click_events.client_browser',
            'click_events.client_platform',
            'click_events.updated_at',
            'click_events.created_at'
        );

        if ($request->has('filter')){


            if ($request->has('period_from') && $request->has('period_to')) {
                $date_start = new Carbon($request->get('period_from'));
                $date_end = new Carbon($request->get('period_to'));
                $clicks->whereBetween('click_events.updated_at', [$date_start->format('Y-m-d')." 00:00:00", $date_end->format('Y-m-d')." 23:59:59"]);
            }
        }else{
            $date_start = new Carbon(date('j F, Y'));
            $date_end = new Carbon(date('j F, Y'));
            $clicks->whereBetween('click_events.updated_at', [$date_start->format('Y-m-d')." 00:00:00", $date_end->format('Y-m-d')." 23:59:59"]);
        }


        $clicks->where('click_events.click_source_site_domain', $site_name);
        $result = $clicks->orderBy('click_events.updated_at', 'desc')->get();

        return $result;

    }

    public static function getDomainChartsData($request, $site_name ,$key){
        $chart = DB::table('click_events')->select(
            $key,
            DB::raw('count(*) as count')
            );
        if ($request->has('filter')){
            if ($request->has('period_from') && $request->has('period_to')) {
                $date_start = new Carbon($request->get('period_from'));
                $date_end = new Carbon($request->get('period_to'));
                $chart->whereBetween('click_events.updated_at', [$date_start->format('Y-m-d')." 00:00:00", $date_end->format('Y-m-d')." 23:59:59"]);
            }
        }else{
            $date_start = new Carbon(date('j F, Y'));
            $date_end = new Carbon(date('j F, Y'));
            $chart->whereBetween('click_events.updated_at', [$date_start->format('Y-m-d')." 00:00:00", $date_end->format('Y-m-d')." 23:59:59"]);
        }

        $chart->where('click_events.click_source_site_domain', $site_name);
        $result = $chart->whereNotNull($key)->groupBy($key)->orderBy('count', 'desc')->limit(5)->get();

        return $result;
    }




}
