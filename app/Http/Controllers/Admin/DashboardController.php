<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ClickEvent;
use App\Campaign;
use App\Country;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
        // Dashboard - Analytics
        public function dashboard(){
            $pageConfigs = [
                'pageHeader' => false
            ];

            // Get Countries
            $countries = Country::all();

            foreach($countries as $country){
                $country_top_campaign = Campaign::getTopCampaign($country->country_name);
                $country_top_feed_site = ClickEvent::getTopFeedSite($country->country_name); 
                $country_top_aff_networks = ClickEvent::getTopAffiliateNetwork($country->country_name); 
                $country_top_url = ClickEvent::getTopURL($country->country_name); 
                $top_campaigns[$country->country_code] = $country_top_campaign;
                $top_feed_sites[$country->country_code] = $country_top_feed_site;
                $top_aff_networks[$country->country_code] = $country_top_aff_networks;
                $top_urls[$country->country_code] = $country_top_url;
            }

            return view('/admin/dashboard', [
                'pageConfigs' => $pageConfigs,
                'top_campaigns' => $top_campaigns,
                'top_feed_sites' => $top_feed_sites,
                'top_aff_networks' => $top_aff_networks,
                'top_urls' => $top_urls
            ]);
        }
}
