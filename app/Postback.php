<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Postback extends Model
{
    //
    protected $table = 'postbacks';

    protected $fillable = [
        'campaign_id',
        'click_event_id',
        'affiliate_network_id',
        'currency',
        'payout',
        'commission',
        'status',
        'email'
    ];


    public static function getPostbacks($request){
        $postbacks = DB::table('postbacks')
        ->join('campaigns', 'postbacks.campaign_id', '=', 'campaigns.id')
        ->join('affiliate_networks', 'postbacks.affiliate_network_id', '=', 'affiliate_networks.id')
        ->select(
            'postbacks.id',
            'campaigns.campaign_name as campaign_name',
            'affiliate_networks.affiliate_network_name as affiliate_network_name',
            'postbacks.payout',
            'postbacks.status',
            'postbacks.created_at'
        );
        if ($request->has('filter')){
            if ($request->get('campaign_id') != "All") {
                $postbacks->where('postbacks.campaign_id', $request->get('campaign_id'));
            }
            if ($request->get('affiliate_network_id') != "All") {
                $postbacks->where('postbacks.affiliate_network_id', $request->get('affiliate_network_id'));
            }
            if ($request->has('period_from') && $request->has('period_to')) {
                $date_start = new Carbon($request->get('period_from'));
                $date_end = new Carbon($request->get('period_to'));
                $postbacks->whereBetween('postbacks.created_at', [$date_start->format('Y-m-d')." 00:00:00", $date_end->format('Y-m-d')." 23:59:59"]);
            }
        }else{
            $date_start = new Carbon(date('j F, Y'));
            $date_end = new Carbon(date('j F, Y'));
            $postbacks->whereBetween('postbacks.created_at', [$date_start->format('Y-m-d')." 00:00:00", $date_end->format('Y-m-d')." 23:59:59"]);
        }
        $result = $postbacks->orderBy('postbacks.created_at', 'desc')->get();  
        return $result;
    }

    public static function getStatistics($request){

        $statistics = DB::table('campaigns')
        ->select(
            'campaigns.id as campaign_id',
            'campaigns.campaign_name as campaign_name',
            'campaigns.feed_category_name as feed_category_name',
            DB::raw('count(click_events.id) as clicks'),
            DB::raw('count(case click_events.click_type when \'Unique\' then 1 else null end) as unique_clicks'),
            DB::raw('count(case click_events.click_type when \'Non-Unique\' then 1 else null end) as non_unique_clicks'),
            DB::raw('count(case when click_events.payout > 0 and click_events.click_type = \'Non-Unique\' then 1 else null end) as click_count'),
            DB::raw('count(case when click_events.payout > 0 then 1 else null end) as conversions'),
            DB::raw('sum(click_events.payout) as payout'),
            'click_events.updated_at as updated_at'
            )
        ->leftJoin('click_events', function($join)use($request){
            $date_start = new Carbon($request->get('period_from'));
            $date_end = new Carbon($request->get('period_to'));
            $join->on('click_events.campaign_id', '=', 'campaigns.id');

            if ($request->has('filter')){
                if ($request->has('period_from') && $request->has('period_to')) {
                    $date_start = new Carbon($request->get('period_from'));
                    $date_end = new Carbon($request->get('period_to'));
                    $join->whereBetween('click_events.updated_at', [$date_start->format('Y-m-d')." 00:00:00", $date_end->format('Y-m-d')." 23:59:59"]);
                }

                if ($request->get('utm_source') != "All") {
                    $join->where('click_events.utm_source', $request->get('utm_source'));
                }
                if ($request->get('utm_medium') != "All") {
                    $join->where('click_events.utm_medium', $request->get('utm_medium'));
                }
                if ($request->get('utm_content') != "All") {
                    $join->where('click_events.utm_content', $request->get('utm_content'));
                }
                //$join->where('click_events.payout', '>', 0);

            }else{
                $date_start = new Carbon(date('j F, Y'));
                $date_end = new Carbon(date('j F, Y'));
               // $join->where('click_events.payout', '>', 0);
                $join->whereBetween('click_events.updated_at', [$date_start->format('Y-m-d')." 00:00:00", $date_end->format('Y-m-d')." 23:59:59"]);
            }

            
            
        });

        if ($request->has('filter')){
            if ($request->get('campaign_id') != "All") {
                $statistics->where('click_events.campaign_id', $request->get('campaign_id'));
            }
            if ($request->get('country_id') != "All") {
                $statistics->where('campaigns.country_id', $request->get('country_id'));
            }
            if ($request->get('feed_category_id') != "All") {
                $statistics->where('campaigns.feed_category_id', $request->get('feed_category_id'));
            }
            if ($request->get('feed_subcategory') != "All") {
                $feed_subcategory_campaigns = CampaignFeedSubcategory::where('feed_subcategory_id',$request->get('feed_subcategory'))->pluck('campaign_id');
                $statistics->whereIn('campaigns.id', $feed_subcategory_campaigns);
            }


        }


        $statistics->groupBy('campaigns.campaign_name');


        $result = $statistics->get();  
        
        /*$statistics = DB::table('postbacks')
        ->select(
            'postbacks.id',
            'postbacks.campaign_id',
            'postbacks.click_event_id',
            'campaigns.campaign_name as campaign_name',
            'affiliate_networks.affiliate_network_name as affiliate_network_name',
            'postbacks.payout',
            'postbacks.status'
        )
        ->leftJoin('campaigns','postbacks.campaign_id','=','campaigns.id')
        ->leftJoin('click_events','postbacks.click_event_id','=','click_events.id')
        ->leftjoin('affiliate_networks', 'postbacks.affiliate_network_id', '=', 'affiliate_networks.id');

        $result = $statistics->get(); 
*/
       // dd ($result);
        return $result;
    }

}
