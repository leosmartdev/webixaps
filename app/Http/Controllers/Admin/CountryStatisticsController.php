<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Country;

class CountryStatisticsController extends Controller
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
        
        $statistics = Country::getStatistics($request);
 
        $breadcrumbs = [
            ['link'=>"/admin/dashboard",'name'=>"Dashboard"], ['name'=>"Statistics"]
        ];
        return view('admin/statistics/countries', [
            'breadcrumbs' => $breadcrumbs,
            'filter' => $request,
            'statistics' => $statistics
        ]);

    }
}
