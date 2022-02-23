<?php

namespace App\Http\Controllers\Admin;

use App\AffiliateNetwork;
use App\Campaign;
use App\CampaignDisplaySettings;
use App\CampaignFeedSubcategory;
use App\Country;
use App\FeedCategory;
use App\FeedCategoryExtraField;
use App\FeedSite;
use App\FeedSubcategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CampaignController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    //
    $breadcrumbs = [
      ['link' => "/admin/dashboard", 'name' => "Dashboard"],
      ['name' => "Campaign List"]
    ];

    return view(
      'admin/campaigns/index',
      [
        'breadcrumbs' => $breadcrumbs
      ]
    );
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
    $breadcrumbs = [
      ['link' => "/admin/dashboard", 'name' => "Dashboard"],
      ['link' => "/admin/campaigns", 'name' => "Campaign List"],
      ['name' => "Add Campaign"]
    ];
    $countries = Country::all();
    $feed_categories = FeedCategory::all();
    $affiliate_networks = AffiliateNetwork::all();
    $feed_sites = FeedSite::all();

    return view(
      'admin/campaigns/create',
      [
        'breadcrumbs'        => $breadcrumbs,
        'countries'          => $countries,
        'feed_categories'    => $feed_categories,
        'affiliate_networks' => $affiliate_networks,
        'feed_sites'         => $feed_sites
      ]
    );
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param \Illuminate\Http\Request $request
   *
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $rule = [
      'country_id'            => 'required|exists:countries,id',
      'country_name'          => 'required|min:3|max:100',
      'feed_category_id'      => 'required|exists:feed_categories,id',
      'feed_category_name'    => 'required|min:2|max:100',
      'campaign_name'         => 'required|min:2|max:100',
      'clean_url'             => 'required|min:2|max:100|unique:campaigns,clean_url',
      'affiliate_network_id'  => 'required|exists:affiliate_networks,id',
      'affiliate_network_url' => 'required|min:2|max:255',
      'campaign_logo'         => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:max_width=220,max_height=127',
      'rating'                => 'required'
    ];

    $validator = Validator::make($request->all(), $rule);

    if ($validator->fails()) {
      return redirect()->back()->withInput($request->all())->withErrors($validator);
    }

    $campaign_logo = $request->get('campaign_name') . '_logo_130_40_' . time() . '.' . request(
      )->campaign_logo->getClientOriginalExtension();
    $request->campaign_logo->storeAs('campaign_logo', $campaign_logo);
    $campaign_banner_small = '';
    if ($request->hasFile('campaign_banner_small')) {
      $campaign_banner_small = $request->get('campaign_name') . '_banner_small_' . time() . '.' . request(
        )->campaign_banner_small->getClientOriginalExtension();
      $request->campaign_banner_small->storeAs('campaign_banner_small', $campaign_banner_small);
    }
    $campaign_banner_medium = '';
    if ($request->hasFile('campaign_banner_medium')) {
      $campaign_banner_medium = $request->get('campaign_name') . '_banner_medium_' . time() . '.' . request(
        )->campaign_banner_medium->getClientOriginalExtension();
      $request->campaign_banner_medium->storeAs('campaign_banner_medium', $campaign_banner_medium);
    }
    $campaign_banner_large = '';
    if ($request->hasFile('campaign_banner_large')) {
      $campaign_banner_large = $request->get('campaign_name') . '_banner_large_' . time() . '.' . request(
        )->campaign_banner_large->getClientOriginalExtension();
      $request->campaign_banner_large->storeAs('campaign_banner_large', $campaign_banner_large);
    }

    $campaign = new Campaign(
      [
        'country_id'             => $request->get('country_id'),
        'country_name'           => $request->get('country_name'),
        'feed_category_id'       => $request->get('feed_category_id'),
        'feed_category_name'     => $request->get('feed_category_name'),
        'campaign_name'          => $request->get('campaign_name'),
        'clean_url'              => $request->get('clean_url'),
        'affiliate_network_id'   => $request->get('affiliate_network_id'),
        'affiliate_network_url'  => $request->get('affiliate_network_url'),
        'display_setting'        => $request->get('display_setting'),
        'campaign_logo'          => $campaign_logo,
        'campaign_ribbon'        => $request->get('campaign_ribbon'),
        'campaign_banner_small'  => $campaign_banner_small,
        'campaign_banner_medium' => $campaign_banner_medium,
        'campaign_banner_large'  => $campaign_banner_large,
        'campaign_initial_epc'   => $request->get('campaign_initial_epc'),
        'rating'                 => $request->get('rating'),
      ]
    );
    $campaign->save();

    foreach ($request->get('feed_subcategories') as $feed_subcategory) {
      $cfs = new CampaignFeedSubcategory(
        [
          'campaign_id'         => $campaign->id,
          'feed_subcategory_id' => $feed_subcategory
        ]
      );
      $cfs->save();
    }

    if ($request->has('display_only_on')) {
      foreach ($request->get('display_only_on') as $display_only_on) {
        $ds = new CampaignDisplaySettings(
          [
            'campaign_id'       => $campaign->id,
            'feed_site_id'      => $display_only_on,
            'feed_display_type' => 'display_only_on'
          ]
        );
        $ds->save();
      }
    }

    if ($request->has('display_on_all_except')) {
      foreach ($request->get('display_on_all_except') as $display_on_all_except) {
        $dse = new CampaignDisplaySettings(
          [
            'campaign_id'       => $campaign->id,
            'feed_site_id'      => $display_on_all_except,
            'feed_display_type' => 'display_on_all_except'
          ]
        );
        $dse->save();
      }
    }

    return redirect('admin/campaigns/' . $campaign->id . '/edit')->with('success', 'New Campaign Added!');
  }

  /**
   * Display the specified resource.
   *
   * @param int $id
   *
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param int $id
   *
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    //
    $breadcrumbs = [
      ['link' => "/admin/dashboard", 'name' => "Dashboard"],
      ['link' => "/admin/campaigns", 'name' => "Campaign List"],
      ['name' => "Edit Campaign"]
    ];

    $campaign = Campaign::find($id);
    $campaign_feed_subcategories = CampaignFeedSubcategory::where('campaign_id', '=', $campaign->id)->get();
    $feed_subcategories = FeedSubcategory::where(
      [['feed_category_id', '=', $campaign->feed_category_id], ['country_id', '=', $campaign->country_id]]
    )->get();
    $final_feed_subcategories = array();
    foreach ($feed_subcategories as $key => $feed_subcategory) {

      $final_feed_subcategories[$key]['id'] = $feed_subcategory->id;
      $final_feed_subcategories[$key]['feed_subcategory_name'] = $feed_subcategory->feed_subcategory_name;
      $fsc = $this->searchForFeedCategory($feed_subcategory->id, $campaign_feed_subcategories);
      if (!is_null($fsc)) {
        $final_feed_subcategories[$key]['campaign_feed_subcategory_id'] = $fsc['id'];
      } else {
        $final_feed_subcategories[$key]['campaign_feed_subcategory_id'] = null;
      }
    }

    $feed_sites = FeedSite::all();
    // Get All Display on
    $campaign_feed_display_on = CampaignDisplaySettings::where('campaign_id', '=', $campaign->id)->where(
      'feed_display_type',
      '=',
      'display_only_on'
    )->get();
    $final_feed_display_on = array();
    foreach ($feed_sites as $key => $feed_site) {

      $final_feed_display_on[$key]['id'] = $feed_site->id;
      $final_feed_display_on[$key]['feed_site_name'] = $feed_site->feed_site_name;
      $fd_on = $this->searchForFeedSite($feed_site->id, $campaign_feed_display_on);
      if (!is_null($fd_on)) {
        $final_feed_display_on[$key]['campaign_feed_site_id'] = $fd_on['id'];
      } else {
        $final_feed_display_on[$key]['campaign_feed_site_id'] = null;
      }
    }

    // Get All Display on all except
    $campaign_feed_display_on_except = CampaignDisplaySettings::where('campaign_id', '=', $campaign->id)->where(
      'feed_display_type',
      '=',
      'display_on_all_except'
    )->get();
    $final_feed_display_on_except = array();
    foreach ($feed_sites as $key => $feed_site) {

      $final_feed_display_on_except[$key]['id'] = $feed_site->id;
      $final_feed_display_on_except[$key]['feed_site_name'] = $feed_site->feed_site_name;
      $fd_on = $this->searchForFeedSite($feed_site->id, $campaign_feed_display_on_except);
      if (!is_null($fd_on)) {
        $final_feed_display_on_except[$key]['campaign_feed_site_id'] = $fd_on['id'];
      } else {
        $final_feed_display_on_except[$key]['campaign_feed_site_id'] = null;
      }
    }

    $feed_category = FeedCategory::find($campaign->feed_category_id);
    $fcfs = FeedCategoryExtraField::getFields($feed_category->id, array());
    $affiliate_networks = AffiliateNetwork::all();

    return view(
      'admin/campaigns/edit',
      [
        'breadcrumbs'                   => $breadcrumbs,
        'campaign'                      => $campaign,
        'campaign_extra_field_value'    => unserialize($campaign->campaign_extra_field_value),
        'fields'                        => $fcfs,
        'final_feed_subcategories'      => $final_feed_subcategories,
        'affiliate_networks'            => $affiliate_networks,
        'final_feed_display_ons'        => $final_feed_display_on,
        'final_feed_display_on_excepts' => $final_feed_display_on_except,
      ]
    );
  }

  /**
   * Update the specified resource in storage.
   *
   * @param \Illuminate\Http\Request $request
   * @param int                      $id
   *
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    //
    $request->validate(
      [
        'campaign_name'         => 'required|min:2|max:100',
        'clean_url'             => 'required|min:2|max:100|unique:campaigns,clean_url,' . $id,
        'affiliate_network_url' => 'required|min:2|max:255',
        'affiliate_network_id'  => 'required',
      ]
    );

    $campaign = Campaign::find($id);
    $campaign->campaign_name = $request->get('campaign_name');
    $campaign->clean_url = $request->get('clean_url');
    $campaign->affiliate_network_id = $request->get('affiliate_network_id');
    $campaign->affiliate_network_url = $request->get('affiliate_network_url');
    $campaign->campaign_initial_epc = $request->get('campaign_initial_epc');
    $campaign->rating = $request->get('rating');
    if ($request->has('campaign_ribbon')) {
      //
      $campaign->campaign_ribbon = $request->get('campaign_ribbon');
    }

    if ($request->hasFile('campaign_logo')) {
      $campaign_logo = $request->get('campaign_name') . '_logo_130_40_' . time() . '.' . request(
        )->campaign_logo->getClientOriginalExtension();
      $request->campaign_logo->storeAs('campaign_logo', $campaign_logo);
      $campaign->campaign_logo = $campaign_logo;
    }

    if ($request->hasFile('campaign_banner_small')) {
      $campaign_banner_small = $request->get('campaign_name') . '_banner_small_' . time() . '.' . request(
        )->campaign_banner_small->getClientOriginalExtension();
      $request->campaign_banner_small->storeAs('campaign_banner_small', $campaign_banner_small);
      $campaign->campaign_logo = $campaign_banner_small;
    }

    if ($request->hasFile('campaign_banner_medium')) {
      $campaign_banner_medium = $request->get('campaign_name') . '_banner_medium_' . time() . '.' . request(
        )->campaign_banner_medium->getClientOriginalExtension();
      $request->campaign_banner_medium->storeAs('campaign_banner_medium', $campaign_banner_medium);
      $campaign->campaign_medium = $campaign_banner_medium;
    }

    if ($request->hasFile('campaign_banner_large')) {
      $campaign_banner_large = $request->get('campaign_name') . '_banner_large_' . time() . '.' . request(
        )->campaign_banner_large->getClientOriginalExtension();
      $request->campaign_banner_large->storeAs('campaign_banner_large', $campaign_banner_large);
      $campaign->campaign_large = $campaign_banner_large;
    }

    if ($request->has('campaign_extra_field_value')) {

      $campaign->campaign_extra_field_value = serialize($request->get('campaign_extra_field_value'));
    }

    if ($request->has('display_setting')) {
      //
      $campaign->display_setting = $request->get('display_setting');
    }

    $campaign->save();

    foreach ($request->get('feed_subcategories') as $feed_subcategory) {
      $cf = CampaignFeedSubcategory::where(
        [['campaign_id', '=', $campaign->id], ['feed_subcategory_id', '=', $feed_subcategory]]
      )->first();
      if ($cf === null) {
        $cfs = new CampaignFeedSubcategory(
          [
            'campaign_id'         => $campaign->id,
            'feed_subcategory_id' => $feed_subcategory
          ]
        );
        $cfs->save();
      }
    }

    return redirect()->back()->with('success', 'Campaign Updated!');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param int $id
   *
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    //
  }

  public function campaign_ajax_list()
  {

    $campaigns = Campaign::all();
    $campaignsJson = json_encode($campaigns);

    return $campaignsJson;
  }

  private function searchForFeedCategory($id, $array)
  {
    foreach ($array as $key => $val) {
      if ($val->feed_subcategory_id === $id) {
        return $val;
      }
    }

    return null;
  }

  private function searchForFeedSite($id, $array)
  {
    foreach ($array as $key => $val) {
      if ($val->feed_site_id === $id) {
        return $val;
      }
    }

    return null;
  }

}
