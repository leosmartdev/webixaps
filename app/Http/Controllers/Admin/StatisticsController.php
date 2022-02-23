<?php

namespace App\Http\Controllers\Admin;

use App\Campaign;
use App\ClickEvent;
use App\Country;
use App\FeedCategory;
use App\Http\Controllers\Controller;
use App\Postback;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        //

        if ($request->has('get_revenue')){

            // Compute revenues
            $country_name = "Denmark";
            if ($request->has('country_name')){
                $country_name = $request->get('country_name');
            }

            $currencies = $this->getCurrency();

            $curr = $currencies[$country_name];

            $revenue['this_month'] = number_format($this->this_month_transactions($country_name), 2). " ".$curr;
            $revenue['this_week'] = number_format($this->this_week_transactions($country_name), 2). " ".$curr;
            $revenue['yesterday'] = number_format($this->yesterday_transactions($country_name), 2). " ".$curr;
            $revenue['today'] = number_format($this->today_transactions($country_name), 2). " ".$curr;


            return $revenue;
        }

        $statistics = Campaign::getStatistics($request);
        $utm_sources = ClickEvent::getUTMS($request, 'utm_source');
        $utm_mediums = ClickEvent::getUTMS($request, 'utm_medium');
        $utm_contents = ClickEvent::getUTMS($request, 'utm_content');

        $device_chart = ClickEvent::getChartsData($request, 'client_device');
        $browser_chart = ClickEvent::getChartsData($request, 'client_browser');
        $cities_chart = ClickEvent::getChartsData($request, 'client_city');
        $domains_chart = ClickEvent::getChartsData($request, 'utm_source');
        $urls_chart = ClickEvent::getChartsData($request, 'utm_content');
        $mediums_chart = ClickEvent::getChartsData($request, 'utm_medium');

        $campaigns = Campaign::select('id','campaign_name')->orderBy('campaign_name', 'asc')->get();
        $feed_categories = FeedCategory::all();
        $countries = Country::all();
        $campaign = array();
        if ($request->has('filter')){
            if ($request->get('campaign_id') != "All") {
                $campaign = Campaign::find($request->get('campaign_id'));
            }
        }

        $breadcrumbs = [
            ['link'=>"/admin/dashboard",'name'=>"Dashboard"], ['name'=>"Statistics"]
        ];
        return view('admin/statistics/index', [
            'breadcrumbs' => $breadcrumbs,
            'filter' => $request,
            'statistics' => $statistics,
            'campaigns' => $campaigns,
            'selcampaign' => $campaign,
            'countries' => $countries,
            'feed_categories' => $feed_categories,
            'utm_sources' => $utm_sources,
            'utm_mediums' => $utm_mediums,
            'utm_contents' => $utm_contents,
            'devices' => $this->arrangeChart($device_chart, 'client_device'),
            'browsers' => $this->arrangeChart($browser_chart, 'client_browser'),
            'cities' => $this->arrangeChart($cities_chart, 'client_city'),
            'domains' => $this->arrangeChart($domains_chart, 'utm_source'),
            'urls' => $this->arrangeChart($urls_chart, 'utm_content'),
            'mediums' => $this->arrangeChart($mediums_chart, 'utm_medium')
        ]);
    }


    public function getStatisticsByCampaign($campaign_id, Request $request){
        $campaign = Campaign::find($campaign_id);
        $currencies = $this->getCurrency();
        $curr = $currencies[$campaign->country_name];
        $campaign_total_clicks = ClickEvent::getCampaignTotalClicks($campaign_id, $request);
        $campaign_top_feed_site = ClickEvent::getCampaignTopFeedSite($campaign_id, $request);
        $campaign_total_payout = ClickEvent::getCampaignTotalPayout($campaign_id, $request);
        $campaign_total_postback = ClickEvent::getCampaignTotalPostback($campaign_id, $request);
        $campaign_total_non_unique_postback = ClickEvent::getCampaignTotalNonUniquePostback($campaign_id, $request);
        $click_events = ClickEvent::getClickEventsByCampaign($request, $campaign_id);

        $device_chart = ClickEvent::getCampaignChartsData($request, $campaign_id ,'client_device');
        $browser_chart = ClickEvent::getCampaignChartsData($request, $campaign_id ,'client_browser');
        $cities_chart = ClickEvent::getCampaignChartsData($request, $campaign_id ,'client_city');
        $domains_chart = ClickEvent::getCampaignChartsData($request, $campaign_id ,'utm_source');
        $urls_chart = ClickEvent::getCampaignChartsData($request, $campaign_id ,'utm_content');
        $mediums_chart = ClickEvent::getCampaignChartsData($request,$campaign_id , 'utm_medium');

        $campaign_top = array(
            'total_unique_clicks' => $campaign_total_clicks->unique_clicks + $campaign_total_non_unique_postback->click_count,
            'total_non_unique_clicks' => $campaign_total_clicks->non_unique_clicks - $campaign_total_non_unique_postback->click_count,
            'top_feed_site' => $campaign_top_feed_site->click_source_site_name ?? '',
            'total_payout' => $campaign_total_payout->total_payout ?? 0,
            'total_postback' => $campaign_total_postback->total_postback,
            'epc' => isset($campaign_total_payout->total_payout) ? ($campaign_total_payout->total_payout / ($campaign_total_clicks->unique_clicks +  $campaign_total_non_unique_postback->click_count)) : 0,
            'currency' => $curr
        );

        $breadcrumbs = [
            ['link'=>"/admin/dashboard",'name'=>"Dashboard"], ['name'=> $campaign->campaign_name." Statistics"]
        ];
        return view('admin/statistics/campaign_show', [
            'breadcrumbs' => $breadcrumbs,
            'filter' => $request,
            'campaign' => $campaign,
            'campaign_top' => $campaign_top,
            'click_events' => $click_events,
            'devices' => $this->arrangeChart($device_chart, 'client_device'),
            'browsers' => $this->arrangeChart($browser_chart, 'client_browser'),
            'cities' => $this->arrangeChart($cities_chart, 'client_city'),
            'domains' => $this->arrangeChart($domains_chart, 'utm_source'),
            'urls' => $this->arrangeChart($urls_chart, 'utm_content'),
            'mediums' => $this->arrangeChart($mediums_chart, 'utm_medium')
        ]);


    }

    public function getStatisticsByPostbacks(Request $request){


        $request->request->add(['postback' => true]);

        $campaign = array();
        $statistics = Postback::getStatistics($request);
        $utm_sources = ClickEvent::getUTMS($request, 'utm_source');
        $utm_mediums = ClickEvent::getUTMS($request, 'utm_medium');
        $utm_contents = ClickEvent::getUTMS($request, 'utm_content');

        $device_chart = ClickEvent::getChartsData($request, 'client_device');
        $browser_chart = ClickEvent::getChartsData($request, 'client_browser');
        $cities_chart = ClickEvent::getChartsData($request, 'client_platform');
        $domains_chart = ClickEvent::getChartsData($request, 'client_city');
        $urls_chart = ClickEvent::getChartsData($request, 'utm_content');
        $mediums_chart = ClickEvent::getChartsData($request, 'utm_medium');





        $campaigns = Campaign::select('id','campaign_name')->orderBy('campaign_name', 'asc')->get();
        $feed_categories = FeedCategory::all();
        $countries = Country::all();
        $campaign = array();
        if ($request->has('filter')){
            if ($request->get('campaign_id') != "All") {
                $campaign = Campaign::find($request->get('campaign_id'));
            }
        }


        $breadcrumbs = [
            ['link'=>"/admin/dashboard",'name'=>"Dashboard"], ['name'=>"Statistics"]
        ];
        return view('admin/statistics/postbacks', [
            'breadcrumbs' => $breadcrumbs,
            'filter' => $request,
            'statistics' => $statistics,
            'campaigns' => $campaigns,
            'selcampaign' => $campaign,
            'countries' => $countries,
            'feed_categories' => $feed_categories,
            'utm_sources' => $utm_sources,
            'utm_mediums' => $utm_mediums,
            'utm_contents' => $utm_contents,
            'devices' => $this->arrangeChart($device_chart, 'client_device'),
            'browsers' => $this->arrangeChart($browser_chart, 'client_browser'),
            'cities' => $this->arrangeChart($cities_chart, 'client_platform'),
            'domains' => $this->arrangeChart($domains_chart, 'client_city'),
            'urls' => $this->arrangeChart($urls_chart, 'utm_content'),
            'mediums' => $this->arrangeChart($mediums_chart, 'utm_medium')
        ]);


    }

    public function getStatisticsByTrends(){

        $statistics = Campaign::getTrends();
        $final_statistics = array();
        $months[] =  date("F Y", strtotime( date( 'Y-m-01' )));
        for ($i = 1; $i < 12; $i++) {
            $months[] = date("F Y", strtotime( date( 'Y-m-01' )." -$i months"));
        }

        foreach ($statistics as $statistic){


            foreach ($months as $month){
                $result = Campaign::getMonthlyResult($month, $statistic);
                $final_statistics[$statistic][$month] = $result->payout;
            }

        }


        $reverse_month = array_reverse($months);
        $breadcrumbs = [
            ['link'=>"/admin/dashboard",'name'=>"Dashboard"], ['name'=> "Trends Statistics"]
        ];


        return view('admin/statistics/trends', [
            'breadcrumbs' => $breadcrumbs,
            'months' => $reverse_month,
            'final_statistics' => $final_statistics
        ]);
    }

    public function getStatisticsByTrendsEpc(){

        $statistics = Campaign::getTrendsEpc();
       // $newstatistics = $statistics->pluck('campaign_name');

        $newstatistics = collect($statistics)->map(function ($item) {

            if (!is_null($item->unique_clicks) && !is_null($item->click_count) && !is_null($item->payout)){
                $total_clicks = $item->unique_clicks + $item->click_count;
                $item->epc = $item->payout / $total_clicks;
            }else{
                $item->epc = 0;
            }

            return $item;
        });

        $statistics = $newstatistics->sortByDesc('epc')->pluck('campaign_name');
        $final_statistics = array();
        $months[] =  date("F Y", strtotime( date( 'Y-m-01' )));
        for ($i = 1; $i < 12; $i++) {
            $months[] = date("F Y", strtotime( date( 'Y-m-01' )." -$i months"));
        }

        foreach ($statistics as $statistic){


            foreach ($months as $month){
                $item = Campaign::getMonthlyResultEpc($month, $statistic);
                if (!is_null($item->unique_clicks) && !is_null($item->click_count) && !is_null($item->payout)){
                    $total_clicks = $item->unique_clicks + $item->click_count;
                    $final_statistics[$statistic][$month] = $item->payout / $total_clicks;
                }else{
                    $final_statistics[$statistic][$month] = 0;
                }

            }

        }


        $reverse_month = array_reverse($months);
        $breadcrumbs = [
            ['link'=>"/admin/dashboard",'name'=>"Dashboard"], ['name'=> "Trends Statistics"]
        ];


        return view('admin/statistics/trends-epc', [
            'breadcrumbs' => $breadcrumbs,
            'months' => $reverse_month,
            'final_statistics' => $final_statistics
        ]);
    }

    public function getStatisticsByTrendsClicks(){

        $statistics = Campaign::getTrendsClicks();
        $final_statistics = array();
        $months[] =  date("F Y", strtotime( date( 'Y-m-01' )));
        for ($i = 1; $i < 12; $i++) {
            $months[] = date("F Y", strtotime( date( 'Y-m-01' )." -$i months"));
        }

        foreach ($statistics as $statistic){


            foreach ($months as $month){
                $result = Campaign::getMonthlyResultClicks($month, $statistic);
                $final_statistics[$statistic][$month] = $result->clicks;
            }

        }


        $reverse_month = array_reverse($months);
        $breadcrumbs = [
            ['link'=>"/admin/dashboard",'name'=>"Dashboard"], ['name'=> "Trends Statistics"]
        ];


        return view('admin/statistics/trends-clicks', [
            'breadcrumbs' => $breadcrumbs,
            'months' => $reverse_month,
            'final_statistics' => $final_statistics
        ]);
    }

    public function getStatisticsByTrendsConversions(){

        $statistics = Campaign::getTrendsConversions();
        $final_statistics = array();
        $months[] =  date("F Y", strtotime( date( 'Y-m-01' )));
        for ($i = 1; $i < 12; $i++) {
            $months[] = date("F Y", strtotime( date( 'Y-m-01' )." -$i months"));
        }

        foreach ($statistics as $statistic){


            foreach ($months as $month){
                $result = Campaign::getMonthlyResultConversions($month, $statistic);
                $final_statistics[$statistic][$month] = $result->conversions;
            }

        }


        $reverse_month = array_reverse($months);
        $breadcrumbs = [
            ['link'=>"/admin/dashboard",'name'=>"Dashboard"], ['name'=> "Trends Statistics"]
        ];


        return view('admin/statistics/trends-conversions', [
            'breadcrumbs' => $breadcrumbs,
            'months' => $reverse_month,
            'final_statistics' => $final_statistics
        ]);
    }

    public function getPostbackStatisticsByCampaign($campaign_id, Request $request){


        $request->request->add(['postback' => true]);
        $campaign = Campaign::find($campaign_id);
        $currencies = $this->getCurrency();
        $curr = $currencies[$campaign->country_name];
        $campaign_total_clicks = ClickEvent::getCampaignTotalClicks($campaign_id, $request);
        $campaign_top_feed_site = ClickEvent::getCampaignTopFeedSite($campaign_id, $request);
        $campaign_total_payout = ClickEvent::getCampaignTotalPayout($campaign_id, $request);
        $campaign_total_postback = ClickEvent::getCampaignTotalPostback($campaign_id, $request);
        $campaign_total_non_unique_postback = ClickEvent::getCampaignTotalNonUniquePostback($campaign_id, $request);
        $click_events = ClickEvent::getClickEventsByCampaign($request, $campaign_id);

        $device_chart = ClickEvent::getCampaignChartsData($request, $campaign_id ,'client_device');
        $browser_chart = ClickEvent::getCampaignChartsData($request, $campaign_id ,'client_browser');
        $cities_chart = ClickEvent::getCampaignChartsData($request, $campaign_id ,'client_platform');
        $domains_chart = ClickEvent::getCampaignChartsData($request, $campaign_id ,'client_city');
        $urls_chart = ClickEvent::getCampaignChartsData($request, $campaign_id ,'utm_content');
        $mediums_chart = ClickEvent::getCampaignChartsData($request,$campaign_id , 'utm_medium');


        $campaign_top = array(
            'total_unique_clicks' => $campaign_total_clicks->unique_clicks + $campaign_total_non_unique_postback->click_count,
            'total_non_unique_clicks' => $campaign_total_clicks->non_unique_clicks - $campaign_total_non_unique_postback->click_count,
            'top_feed_site' => $campaign_top_feed_site->click_source_site_name ?? '',
            'total_payout' => $campaign_total_payout->total_payout ?? 0,
            'total_postback' => $campaign_total_postback->total_postback,
            'epc' => isset($campaign_total_payout->total_payout) ?  $campaign_total_payout->total_payout / ($campaign_total_clicks->unique_clicks +  $campaign_total_non_unique_postback->click_count) : 0,
            'currency' => $curr
        );



        $breadcrumbs = [
            ['link'=>"/admin/dashboard",'name'=>"Dashboard"], ['name'=> $campaign->campaign_name." Statistics"]
        ];
        return view('admin/statistics/postback_campaign_show', [
            'breadcrumbs' => $breadcrumbs,
            'filter' => $request,
            'campaign' => $campaign,
            'campaign_top' => $campaign_top,
            'click_events' => $click_events,
            'devices' => $this->arrangeChart($device_chart, 'client_device'),
            'browsers' => $this->arrangeChart($browser_chart, 'client_browser'),
            'cities' => $this->arrangeChart($cities_chart, 'client_platform'),
            'domains' => $this->arrangeChart($domains_chart, 'client_city'),
            'urls' => $this->arrangeChart($urls_chart, 'utm_content'),
            'mediums' => $this->arrangeChart($mediums_chart, 'utm_medium')
        ]);


    }

    private function this_month_transactions($country_name)
    {
        $now = Carbon::now();
        $month = $now->month;
        $year = $now->year;
        if ($country_name == "Denmark"){
            return Postback::where('currency', 'DKK')->whereYear('updated_at', $year)->whereMonth('updated_at', $month)->sum('payout');
        }else{
            return ClickEvent::where('campaign_country', $country_name)->whereYear('updated_at', $year)->whereMonth('updated_at', $month)->sum('payout');
        }

    }

    private function this_week_transactions($country_name)
    {
        $now = Carbon::now();
        $year = $now->year;
        $week = $now->weekOfYear;
        $now->setISODate($year,$week);
        $start_date = $now->startOfWeek();
        $end_date = $now->copy()->endOfWeek();

        if ($country_name == "Denmark"){
            return Postback::where('currency', 'DKK')->whereBetween('updated_at', [$start_date->format('Y-m-d')." 00:00:00", $end_date->format('Y-m-d')." 23:59:59"])->sum('payout');
        }else{
            return ClickEvent::where('campaign_country', $country_name)->whereBetween('updated_at', [$start_date->format('Y-m-d')." 00:00:00", $end_date->format('Y-m-d')." 23:59:59"])->sum('payout');
        }

    }

    private function yesterday_transactions($country_name)
    {
        $yesterday = Carbon::yesterday();
        if ($country_name == "Denmark"){
            return Postback::where('currency', 'DKK')->whereBetween('updated_at', [$yesterday->format('Y-m-d')." 00:00:00",  $yesterday->format('Y-m-d')." 23:59:59"])->sum('payout');
        }else{
            return ClickEvent::where('campaign_country', $country_name)->whereBetween('updated_at', [$yesterday->format('Y-m-d')." 00:00:00",  $yesterday->format('Y-m-d')." 23:59:59"])->sum('payout');
        }
    }

    private function today_transactions($country_name)
    {
        $now = Carbon::now();
        if ($country_name == "Denmark"){
            return Postback::where('currency', 'DKK')->whereBetween('updated_at', [$now->format('Y-m-d')." 00:00:00",  $now->format('Y-m-d')." 23:59:59"])->sum('payout');
        }else{
            return ClickEvent::where('campaign_country', $country_name)->whereBetween('updated_at', [$now->format('Y-m-d')." 00:00:00",  $now->format('Y-m-d')." 23:59:59"])->sum('payout');
        }
    }

  private function getCurrency()
  {
    return array(
      'Denmark'        => 'DKK',
      'Spain'          => 'EUR',
      'Mexico'         => 'MXN',
      'Sweden'         => 'SEK',
      'Norway'         => 'NOK',
      'Finland'        => 'EUR',
      'Poland'         => 'EUR',
      'United Kingdom' => 'GBP'
    );
  }

    private function arrangeChart($chart_data, $key){
        $res['chart_label'] = [];
        $res['chart_count'] = [];
        if ($chart_data){
            foreach ($chart_data as $chart_info){
                $chart_label[] = $chart_info->$key;
                $chart_count[] = $chart_info->count;
            }
            $res['chart_label'] = $chart_label ?? [];
            $res['chart_count'] = $chart_count ?? [];
        }
        return $res;
    }

    public function getStatisticsByDomains(Request $request){


        //$request->request->add(['postback' => true]);

        $campaign = array();
        $statistics = ClickEvent::getStatisticsByDomains($request);
        $utm_sources = ClickEvent::getUTMS($request, 'utm_source');
        $utm_mediums = ClickEvent::getUTMS($request, 'utm_medium');
        $utm_contents = ClickEvent::getUTMS($request, 'utm_content');

        $device_chart = ClickEvent::getChartsData($request, 'client_device');
        $browser_chart = ClickEvent::getChartsData($request, 'client_browser');
        $cities_chart = ClickEvent::getChartsData($request, 'client_platform');
        $domains_chart = ClickEvent::getChartsData($request, 'client_city');
        $urls_chart = ClickEvent::getChartsData($request, 'utm_content');
        $mediums_chart = ClickEvent::getChartsData($request, 'utm_medium');





        $campaigns = Campaign::select('id','campaign_name')->orderBy('campaign_name', 'asc')->get();
        $feed_categories = FeedCategory::all();
        $countries = Country::all();
        $campaign = array();
        if ($request->has('filter')){
            if ($request->get('campaign_id') != "All") {
                $campaign = Campaign::find($request->get('campaign_id'));
            }
        }


        $breadcrumbs = [
            ['link'=>"/admin/dashboard",'name'=>"Dashboard"], ['name'=>"Statistics"]
        ];
        return view('admin/statistics/domains', [
            'breadcrumbs' => $breadcrumbs,
            'filter' => $request,
            'statistics' => $statistics,
            'campaigns' => $campaigns,
            'selcampaign' => $campaign,
            'countries' => $countries,
            'feed_categories' => $feed_categories,
            'utm_sources' => $utm_sources,
            'utm_mediums' => $utm_mediums,
            'utm_contents' => $utm_contents,
            'devices' => $this->arrangeChart($device_chart, 'client_device'),
            'browsers' => $this->arrangeChart($browser_chart, 'client_browser'),
            'cities' => $this->arrangeChart($cities_chart, 'client_platform'),
            'domains' => $this->arrangeChart($domains_chart, 'client_city'),
            'urls' => $this->arrangeChart($urls_chart, 'utm_content'),
            'mediums' => $this->arrangeChart($mediums_chart, 'utm_medium')
        ]);


    }

    public function getStatisticsByDomain(Request $request){



        $statistics = ClickEvent::getStatisticsByDomain($request);


        $click_events = ClickEvent::getClickEventsByDomain($request, $request->get('name'));


        $device_chart = ClickEvent::getDomainChartsData($request, $request->get('name') ,'client_device');
        $browser_chart = ClickEvent::getDomainChartsData($request, $request->get('name') ,'client_browser');
        $cities_chart = ClickEvent::getDomainChartsData($request, $request->get('name') ,'client_city');
        $domains_chart = ClickEvent::getDomainChartsData($request, $request->get('name') ,'utm_source');
        $urls_chart = ClickEvent::getDomainChartsData($request, $request->get('name') ,'utm_content');
        $mediums_chart = ClickEvent::getDomainChartsData($request, $request->get('name') , 'utm_medium');


        $site_top = array(
            'total_unique_clicks' => $statistics->unique_clicks + $statistics->click_count,
            'total_non_unique_clicks' => $statistics->non_unique_clicks - $statistics->click_count,
            'total_postback' => $statistics->conversions
        );



        $breadcrumbs = [
            ['link'=>"/admin/dashboard",'name'=>"Dashboard"], ['name'=> $request->get('name')." Statistics"]
        ];
        return view('admin/statistics/site_show', [
            'breadcrumbs' => $breadcrumbs,
            'filter' => $request,
            'site_top' => $site_top,
            'click_events' => $click_events,
            'devices' => $this->arrangeChart($device_chart, 'client_device'),
            'browsers' => $this->arrangeChart($browser_chart, 'client_browser'),
            'cities' => $this->arrangeChart($cities_chart, 'client_city'),
            'domains' => $this->arrangeChart($domains_chart, 'utm_source'),
            'urls' => $this->arrangeChart($urls_chart, 'utm_content'),
            'mediums' => $this->arrangeChart($mediums_chart, 'utm_medium')
        ]);


    }




}
