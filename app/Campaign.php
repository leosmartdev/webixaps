<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Campaign extends Model
{
    //
    protected $table = 'campaigns';

    protected $fillable = [
        'country_id',
        'country_name',
        'feed_category_id',
        'feed_category_name',
        'campaign_name' ,
        'clean_url',
        'affiliate_network_url',
        'affiliate_network_id',
        'campaign_logo',
        'display_setting',
        'rating'
    ];


    public static function getStatistics($request){


        $statistics = DB::table('campaigns')
        ->select(
            'campaigns.id as campaign_id',
            'campaigns.campaign_name as campaign_name',
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

            }else{
                $date_start = new Carbon(date('j F, Y'));
                $date_end = new Carbon(date('j F, Y'));
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
        //dd ($result);
        return $result;
    }


    public static function sortbyEpc($c, $fsc){
        $date_start = Carbon::now()->subDays(30);
        $date_end = Carbon::now();

        $start = $date_start->format('Y-m-d'). " 00:00:00";
        $end = $date_end->format('Y-m-d'). " 23:59:59";

        $clist = str_replace( array('[',']') ,'', $c );
        $campaigns = DB::select(
            "SELECT `campaigns`.*, (SELECT SUM(`postbacks`.`payout`)
                FROM `postbacks`
                WHERE `campaigns`.id = `postbacks`.`campaign_id`
                AND `postbacks`.`updated_at` BETWEEN '$start' AND '$end') AS total_payout,
            (SELECT COUNT(`click_events`.`id`)
                FROM `click_events`
                WHERE `campaigns`.id = `click_events`.`campaign_id`
                AND `click_events`.`click_type` = 'Unique'
                AND `click_events`.`updated_at` BETWEEN '$start' AND '$end') AS total_clicks
            FROM `campaigns`
            WHERE `campaigns`.`id` IN ($clist)
            GROUP BY `campaigns`.`id`");

        return $campaigns;
    }


    public static function getTopCampaign($country_name){

        $statistics = DB::table('campaigns')
        ->select(
            'campaigns.campaign_name as campaign_name',
            'campaigns.campaign_logo as campaign_logo',
            DB::raw('count(click_events.id) as clicks'),
            DB::raw('count(case click_events.click_type when \'Unique\' then 1 else null end) as unique_clicks'),
            DB::raw('count(case click_events.click_type when \'Non-Unique\' then 1 else null end) as non_unique_clicks'),
            DB::raw('count(case when click_events.payout > 0 and click_events.click_type = \'Non-Unique\' then 1 else null end) as click_count'),
            DB::raw('count(case when click_events.payout > 0 then 1 else null end) as conversions'),
            DB::raw('sum(payout) as payout'),
            'click_events.updated_at as updated_at'
            )
        ->leftJoin('click_events', function($join)use($country_name){
            $date_start = Carbon::now()->subDays(30);
            $date_end = Carbon::now();
            $join->on('click_events.campaign_id', '=', 'campaigns.id');
            $join->whereBetween('click_events.updated_at', [$date_start->format('Y-m-d')." 00:00:00", $date_end->format('Y-m-d')." 23:59:59"]);
            $join->where('click_events.campaign_country', $country_name);
        });
        $statistics->where('campaigns.country_name', $country_name);
        $statistics->groupBy('campaigns.campaign_name');
        $result = $statistics->orderBy('payout', 'desc')->first();
        // dd ($result);
        return $result;
    }

    public static function getTrends(){

        $statistics = DB::table('campaigns')
        ->select(
            'campaigns.id as campaign_id',
            'campaigns.campaign_name as campaign_name',
            DB::raw('sum(click_events.payout) as payout')
            )
        ->leftJoin('click_events', function($join){

            $join->on('click_events.campaign_id', '=', 'campaigns.id');
            $join->where("click_events.updated_at",">", Carbon::now()->subMonths(12));


        });


        $statistics->groupBy('campaigns.campaign_name');


        $result = $statistics->orderBy('payout', 'desc')->take(50)->pluck('campaign_name');
        //dd ($result);
        return $result;


    }

    public static function getTrendsEpc(){

        $statistics = DB::table('campaigns')
        ->select(
            'campaigns.id as campaign_id',
            'campaigns.campaign_name as campaign_name',
            DB::raw('count(case click_events.click_type when \'Unique\' then 1 else null end) as unique_clicks'),
            DB::raw('count(case when click_events.payout > 0 and click_events.click_type = \'Non-Unique\' then 1 else null end) as click_count'),
            DB::raw('sum(click_events.payout) as payout')
            )
        ->leftJoin('click_events', function($join){

            $join->on('click_events.campaign_id', '=', 'campaigns.id');
            $join->where("click_events.updated_at",">", Carbon::now()->subMonths(12));


        });


        $statistics->groupBy('campaigns.campaign_name');


        $result = $statistics->orderBy('payout', 'desc')->take(50)->get();
        //dd ($result);
        return $result;


    }

    public static function getTrendsClicks(){

        $statistics = DB::table('campaigns')
        ->select(
            'campaigns.id as campaign_id',
            'campaigns.campaign_name as campaign_name',
            DB::raw('count(click_events.id) as clicks')
            )
        ->leftJoin('click_events', function($join){

            $join->on('click_events.campaign_id', '=', 'campaigns.id');
            $join->where("click_events.updated_at",">", Carbon::now()->subMonths(12));


        });


        $statistics->groupBy('campaigns.campaign_name');


        $result = $statistics->orderBy('clicks', 'desc')->take(50)->pluck('campaign_name');
        //dd ($result);
        return $result;


    }

    public static function getTrendsConversions(){

        $statistics = DB::table('campaigns')
        ->select(
            'campaigns.id as campaign_id',
            'campaigns.campaign_name as campaign_name',
            DB::raw('count(case when click_events.payout > 0 then 1 else null end) as conversions')
            )
        ->leftJoin('click_events', function($join){

            $join->on('click_events.campaign_id', '=', 'campaigns.id');
            $join->where("click_events.updated_at",">", Carbon::now()->subMonths(12));


        });


        $statistics->groupBy('campaigns.campaign_name');


        $result = $statistics->orderBy('conversions', 'desc')->take(50)->pluck('campaign_name');
        //dd ($result);
        return $result;


    }

    public static function getMonthlyResult($month, $campaign){
       // $month = "August 2020";

        $statistics = DB::table('campaigns')
        ->select(
            'campaigns.campaign_name',
            DB::raw('sum(click_events.payout) as payout')
            )
        ->leftJoin('click_events', function($join)use($month){

            $date_start = new Carbon('first day of '.$month);
            $date_end = new Carbon('last day of '.$month);


            $join->on('click_events.campaign_id', '=', 'campaigns.id');

            $join->whereBetween('click_events.updated_at', [$date_start->format('Y-m-d')." 00:00:00", $date_end->format('Y-m-d')." 23:59:59"]);


        });

        $statistics->where('campaigns.campaign_name',$campaign);
        $statistics->groupBy('campaigns.campaign_name');
        $result = $statistics->first();

        return $result;
    }

    public static function getMonthlyResultEpc($month, $campaign){
        // $month = "August 2020";

         $statistics = DB::table('campaigns')
         ->select(
            'campaigns.id as campaign_id',
            'campaigns.campaign_name as campaign_name',
            DB::raw('count(case click_events.click_type when \'Unique\' then 1 else null end) as unique_clicks'),
            DB::raw('count(case when click_events.payout > 0 and click_events.click_type = \'Non-Unique\' then 1 else null end) as click_count'),
            DB::raw('sum(click_events.payout) as payout')
             )
         ->leftJoin('click_events', function($join)use($month){

             $date_start = new Carbon('first day of '.$month);
             $date_end = new Carbon('last day of '.$month);


             $join->on('click_events.campaign_id', '=', 'campaigns.id');

             $join->whereBetween('click_events.updated_at', [$date_start->format('Y-m-d')." 00:00:00", $date_end->format('Y-m-d')." 23:59:59"]);


         });

         $statistics->where('campaigns.campaign_name',$campaign);
         $statistics->groupBy('campaigns.campaign_name');
         $result = $statistics->first();

         return $result;
    }

    public static function getMonthlyResultClicks($month, $campaign){
        // $month = "August 2020";

         $statistics = DB::table('campaigns')
         ->select(
            'campaigns.id as campaign_id',
            'campaigns.campaign_name as campaign_name',
            DB::raw('count(click_events.id) as clicks')
            )
         ->leftJoin('click_events', function($join)use($month){

             $date_start = new Carbon('first day of '.$month);
             $date_end = new Carbon('last day of '.$month);


             $join->on('click_events.campaign_id', '=', 'campaigns.id');

             $join->whereBetween('click_events.updated_at', [$date_start->format('Y-m-d')." 00:00:00", $date_end->format('Y-m-d')." 23:59:59"]);


         });

         $statistics->where('campaigns.campaign_name',$campaign);
         $statistics->groupBy('campaigns.campaign_name');
         $result = $statistics->first();

         return $result;
    }

    public static function getMonthlyResultConversions($month, $campaign){
        // $month = "August 2020";

         $statistics = DB::table('campaigns')
         ->select(
            'campaigns.id as campaign_id',
            'campaigns.campaign_name as campaign_name',
            DB::raw('count(case when click_events.payout > 0 then 1 else null end) as conversions')
            )
         ->leftJoin('click_events', function($join)use($month){

             $date_start = new Carbon('first day of '.$month);
             $date_end = new Carbon('last day of '.$month);


             $join->on('click_events.campaign_id', '=', 'campaigns.id');

             $join->whereBetween('click_events.updated_at', [$date_start->format('Y-m-d')." 00:00:00", $date_end->format('Y-m-d')." 23:59:59"]);


         });

         $statistics->where('campaigns.campaign_name',$campaign);
         $statistics->groupBy('campaigns.campaign_name');
         $result = $statistics->first();

         return $result;
    }

  public static function findByCountryIdCategoryId($country_id, $feed_category_id)
  {
    $value = DB::table('campaigns')
      ->select('id', 'campaign_name as name')
      ->where('country_id', '=', $country_id)
      ->where('feed_category_id', '=', $feed_category_id)
      ->orderBy('campaign_name', 'asc')
      ->get();

    return $value;
  }


}
