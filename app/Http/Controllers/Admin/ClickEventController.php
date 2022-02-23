<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Postback;
use Illuminate\Http\Request;
use App\ClickEvent;
use App\Campaign;
use App\Country;
use Carbon\Carbon;


class ClickEventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $breadcrumbs = [
            ['link'=>"/admin/dashboard",'name'=>"Dashboard"], ['name'=>"Click Events"]
        ];




        $click_events = ClickEvent::getClickEvents($request);
        $countries = Country::select('id','country_name')->orderBy('country_name', 'asc')->get();
        $campaigns = Campaign::select('id','campaign_name')->orderBy('campaign_name', 'asc')->get();
        return view('admin/click_events/index', [
            'breadcrumbs' => $breadcrumbs,
            'click_events' => $click_events,
            'filter' => $request,
            'countries' => $countries,
            'campaigns' => $campaigns
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //

        $click_event = ClickEvent::find($id);
        $postback = Postback::where('click_event_id', $id)->get();
        $campaign = Campaign::find($click_event->campaign_id);
        $breadcrumbs = [
            ['link'=>"/admin/dashboard",'name'=>"Dashboard"], ['name'=>"Click Event"]
        ];
        return view('admin/click_events/show', [
            'breadcrumbs' => $breadcrumbs,
            'click_event' => $click_event,
            'campaign' => $campaign,
            'postback' => $postback
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function get_all_click_events(){

    }
}
