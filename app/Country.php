<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Country extends Model
{
    //
    protected $table = 'countries';

    protected $fillable = [
        'country_name',
        'country_code'
    ];

    public static function getStatistics($request){

        $statistics = DB::table('countries')
        ->select(
            'countries.country_name as country_name',
            DB::raw('count(click_events.id) as clicks'),
            DB::raw('count(case click_events.click_type when \'Unique\' then 1 else null end) as unique_clicks'),
            DB::raw('count(case click_events.click_type when \'Non-Unique\' then 1 else null end) as non_unique_clicks'),
            DB::raw('count(case when click_events.payout > 0 and click_events.click_type = \'Non-Unique\' then 1 else null end) as click_count'),
            DB::raw('count(case when click_events.payout > 0 then 1 else null end) as conversions'),
            DB::raw('sum(click_events.payout) as payout'),
            'countries.currency as currency',
            'click_events.created_at as created_at'
            )
        ->leftJoin('click_events', function($join)use($request){
            $date_start = new Carbon($request->get('period_from'));
            $date_end = new Carbon($request->get('period_to'));
            $join->on('click_events.campaign_country', '=', 'countries.country_name');

            if ($request->has('period_from') && $request->has('period_to')) {
                $date_start = new Carbon($request->get('period_from'));
                $date_end = new Carbon($request->get('period_to'));
                $join->whereBetween('click_events.updated_at', [$date_start->format('Y-m-d')." 00:00:00", $date_end->format('Y-m-d')." 23:59:59"]);
            }else{
                $join->whereDate('click_events.updated_at', Carbon::today());
            }
           
        })
        ->groupBy('countries.country_name')
        ->get();


        return $statistics;
     }


}
