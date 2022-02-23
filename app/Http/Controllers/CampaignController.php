<?php

namespace App\Http\Controllers;

use App\AffiliateNetwork;
use App\Campaign;
use App\CampaignDisplaySettings;
use App\CampaignFeedSubcategory;
use App\ClickEvent;
use App\Country;
use App\FeedCategory;
use App\FeedSite;
use App\FeedSubcategory;
use Browser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Stevebauman\Location\Facades\Location;

class CampaignController extends Controller
{

  public function get_campaigns(Request $request)
  {

    $site_url = $request->get('site_url');
    //$site_url = 'http://localhost/feedjon';
    $is_mobile = $request->get('is_mobile');

    if ($request->has('feed_campaign_id')) {
      $final_campaigns = Campaign::where('id', $request->get('feed_campaign_id'))->get();

      $country = Country::find($final_campaigns[0]->country_id);
      $feed_category = FeedCategory::find($final_campaigns[0]->feed_category_id);
    } else {
      // Get All Campaigns under Feed Subcategory
      $feed_subcategory_campaigns = CampaignFeedSubcategory::where(
        'feed_subcategory_id',
        $request->get('feed_subcategory_id')
      )->pluck('campaign_id');
      // Get Current Feed Site

      $feed_site = FeedSite::where('feed_site_domain', '=', $site_url)->where('feed_site_status', '=', 'active')->first(
      );
      if ($feed_site) {

        // Get all display settings
        $campaigns_display_setting = CampaignDisplaySettings::whereIn(
          'campaign_id',
          $feed_subcategory_campaigns
        )->where('feed_site_id', '=', $feed_site->id)->get();
        $feed_subcategory = FeedSubcategory::find($request->get('feed_subcategory_id'));

        switch ($feed_subcategory->sort_by) {
          case "epc":
            $campaigns = Campaign::sortbyEpc($feed_subcategory_campaigns, $feed_subcategory);

            $newcampaigns = collect($campaigns)->map(
              function ($item) {


                if ($item->campaign_initial_epc == 0) {
                  if ($item->total_clicks > 0 && $item->total_payout > 0) {
                    $item->epc = (float)$item->total_payout / (float)$item->total_clicks;
                  } else {
                    $item->epc = 0;
                  }
                } else {
                  $item->epc = (float)$item->campaign_initial_epc;
                }

                return $item;
              }
            );

            $campaigns = $newcampaigns->sortByDesc('epc');

            break;
          case "alphabetical":
            $campaigns = Campaign::whereIn('id', $feed_subcategory_campaigns)->orderBy(
              'campaign_name',
              $feed_subcategory->sort_order
            )->get();
            break;
          case "created":
            $campaigns = Campaign::whereIn('id', $feed_subcategory_campaigns)->orderBy(
              'created_at',
              $feed_subcategory->sort_order
            )->get();
            break;
          default:
            $campaigns = Campaign::whereIn('id', $feed_subcategory_campaigns)->orderBy(
              'campaign_initial_epc',
              'desc'
            )->get();
        }

        //$campaigns = Campaign::whereIn('id', $feed_subcategory_campaigns)->orderBy('created_at', 'desc')->get();
        // Filter Campaigns by Display Settings

        $final_campaigns = $this->filterCampaignIdByDisplaySettings($campaigns, $campaigns_display_setting);
      } else {
        // Return Inactive Feed Site
        return "Feed Site currently Inactive, please change status of Feed Site on Administration!";
      }

      $feed_subcategory = FeedSubcategory::find($request->get('feed_subcategory_id'));
      $country = Country::find($feed_subcategory->country_id);
      $feed_category = FeedCategory::find($feed_subcategory->feed_category_id);
    }

    $tran_path = app_path() . "/languages/translations/";
    if (file_exists($tran_path . $this->slugify($country->country_code) . ".php")) {
      include($tran_path . $this->slugify($country->country_code) . ".php");
    } else {
      include($tran_path . "uk.php");
    }

    $layout_folder = $this->feedLayout($feed_category->feed_category_name, $country->country_code, $is_mobile);
    $view = view(
      $layout_folder,
      [
        'campaigns' => $final_campaigns,
        'localize'  => $localize
      ]
    );

    $view = $view->render();

    return $view;
  }

  /**
   * @param Request $request
   *
   * @return false|string
   */
  public function find_campaigns(Request $request)
  {
    $campaigns = Campaign::findByCountryIdCategoryId($request->get('country_id'), $request->get('feed_category_id'));

    return json_encode($campaigns);
  }

  public function get_campaign_landing_page(Request $request)
  {
    $campaign = Campaign::where('clean_url', '=', $request->get('clean_url'))->first();

    $ip = ($request->has('client_ip_address')) ? $request->get('client_ip_address') : $this->get_client_ip();
    $location = Location::get($ip);
    $platform = ($request->has('client_platform')) ? $request->get('client_platform') : $this->getClientPlatform();
    $device = ($request->has('client_device')) ? $request->get('client_device') : $this->getClientDevice();
    $browser = ($request->has('client_browser')) ? $request->get('client_browser') : $this->getClientBrowser();
    $customer = ($request->has('customer')) ? $request->get('customer') : "Webix";

    $click_data = [
      "campaign_id"                => $campaign->id,
      "campaign_country"           => $campaign->country_name,
      "campaign_feed_category"     => $campaign->feed_category_name,
      "campaign_affiliate_network" => $campaign->affiliate_network_id,
      "client_ip_address"          => $ip,
      "client_country"             => $location->countryName,
      "client_region"              => $location->regionName,
      "client_city"                => $location->cityName,
      "client_platform"            => $platform,
      "client_device"              => $device,
      "client_browser"             => $browser,
      "click_type"                 => $this->getClickType($campaign->id, $ip),
      "click_source_site_url"      => $request->get('utm_content'),
      "click_source_site_name"     => $request->get('site_name'),
      "click_source_site_domain"   => $request->get('utm_source'),
      "click_destination"          => "-",
      "utm_source"                 => $request->get('utm_source'),
      "utm_medium"                 => $request->get('utm_medium'),
      "utm_content"                => $request->get('utm_content'),
      "utm_campaign"               => $campaign->campaign_name,
      "customer"                   => $customer
    ];

    $click_event = new ClickEvent($click_data);
    $click_event->save();

    $redirect_url = $this->formatRedirectURL($campaign, $click_event->id);

    return $redirect_url;
  }

  public function go($clean_url, Request $request)
  {
    $referer = $_SERVER['HTTP_REFERER'] ?? "Direct Access";
    $campaign = Campaign::where('clean_url', '=', $clean_url)->first();
    $location = Location::get($this->get_client_ip());
    $customer = ($request->has('customer')) ? $request->get('customer') : "Webix";

    $click_data = [
      "campaign_id"                => $campaign->id,
      "campaign_country"           => $campaign->country_name,
      "campaign_feed_category"     => $campaign->feed_category_name,
      "campaign_affiliate_network" => $campaign->affiliate_network_id,
      "client_ip_address"          => $location->ip,
      "client_country"             => $location->countryName,
      "client_region"              => $location->regionName,
      "client_city"                => $location->cityName,
      "client_platform"            => $this->getClientPlatform(),
      "client_device"              => $this->getClientDevice(),
      "client_browser"             => $this->getClientBrowser(),
      "click_type"                 => $this->getClickType($campaign->id, $location->ip),
      "click_source_site_url"      => $referer,
      "click_source_site_name"     => $request->get('site_name'),
      "click_source_site_domain"   => $referer,
      "click_destination"          => "-",
      "utm_source"                 => $request->get('utm_source'),
      "utm_medium"                 => $request->get('utm_medium'),
      "utm_content"                => $request->get('utm_content'),
      "utm_campaign"               => $request->get('utm_campaign'),
      "customer"                   => $customer
    ];

    $click_event = new ClickEvent($click_data);
    $click_event->save();

    $redirect_url = $this->formatRedirectURL($campaign, $click_event->id);

    return redirect($redirect_url);
  }

  public function getIp()
  {
    foreach (array(
               'HTTP_CLIENT_IP',
               'HTTP_X_FORWARDED_FOR',
               'HTTP_X_FORWARDED',
               'HTTP_X_CLUSTER_CLIENT_IP',
               'HTTP_FORWARDED_FOR',
               'HTTP_FORWARDED',
               'REMOTE_ADDR'
             ) as $key) {
      if (array_key_exists($key, $_SERVER) === true) {
        foreach (explode(',', $_SERVER[$key]) as $ip) {
          $ip = trim($ip); // just to be safe
          if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
            return $ip;
          }
        }
      }
    }
  }

  public function get_client_ip()
  {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP')) {
      $ipaddress = getenv('HTTP_CLIENT_IP');
    } else {
      if (getenv('HTTP_X_FORWARDED_FOR')) {
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
      } else {
        if (getenv('HTTP_X_FORWARDED')) {
          $ipaddress = getenv('HTTP_X_FORWARDED');
        } else {
          if (getenv('HTTP_FORWARDED_FOR')) {
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
          } else {
            if (getenv('HTTP_FORWARDED')) {
              $ipaddress = getenv('HTTP_FORWARDED');
            } else {
              if (getenv('REMOTE_ADDR')) {
                $ipaddress = getenv('REMOTE_ADDR');
              } else {
                $ipaddress = '127.0.0.1';
              }
            }
          }
        }
      }
    }

    return $ipaddress;
  }

  /**
   * @param string $category_name
   * @param string $country_code
   * @param bool   $is_mobile
   *
   * @return array
   */
  protected function feedLayout(string $category_name, string $country_code, bool $is_mobile = false): string
  {
    $folder = $is_mobile ? 'campaign_layout_mobile' : 'campaign_layout';
    $category = $this->slugify($category_name);

    $layout_folder = sprintf('%s/%s/%s/generic', $folder, $category, $this->slugify($country_code));
    if (view()->exists($layout_folder)) {
      return $layout_folder;
    }

    return sprintf('%s/%s/generic', $folder, $category);
  }

  private function filterCampaignIdByDisplaySettings($campaigns, $campaigns_display_setting)
  {
    $final_campaigns = array();
    foreach ($campaigns as $campaign) {
      switch ($campaign->display_setting) {
        case "display_to_all":
          array_push($final_campaigns, $campaign);
          break;
        case "show_only_on":
          $search_items = array('campaign_id' => $campaign->id, 'feed_display_type' => "display_only_on");
          // Call search and pass the array and
          // the search list
          $res = $this->ds_search($campaigns_display_setting, $search_items);
          if ($res) {
            array_push($final_campaigns, $campaign);
          }
          break;
        case "do_not_show_on":
          $search_items = array('campaign_id' => $campaign->id, 'feed_display_type' => "display_on_all_except");
          // Call search and pass the array and
          // the search list
          $res = $this->ds_search($campaigns_display_setting, $search_items);
          if (!$res) {
            array_push($final_campaigns, $campaign);
          }
          break;
      }
    }

    return $final_campaigns;
  }

  private function ds_search($array, $search_list)
  {
    // Create the result array
    $result = array();

    // Iterate over each array element
    foreach ($array as $key => $value) {

      // Iterate over each search condition
      foreach ($search_list as $k => $v) {

        // If the array element does not meet
        // the search condition then continue
        // to the next element
        if (!isset($value[$k]) || $value[$k] != $v) {

          // Skip two loops
          continue 2;
        }
      }

      // Append array element's key to the
      //result array
      $result[] = $value;
    }

    // Return result
    return $result;
  }

  private function slugify($text)
  {
    // replace non letter or digits by _
    $text = preg_replace('~[^\pL\d]+~u', '_', $text);

    // transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);

    // trim
    $text = trim($text, '-');

    // remove duplicate -
    $text = preg_replace('~-+~', '-', $text);

    // lowercase
    $text = strtolower($text);

    if (empty($text)) {
      return 'n-a';
    }

    return $text;
  }

  private function getClickType($campaign_id, $ip)
  {
    $click_query = ClickEvent::whereDate('created_at', '=', Carbon::today())->where(
      'campaign_id',
      '=',
      $campaign_id
    )->where('client_ip_address', '=', $ip)->get();
    if (!$click_query->isEmpty()) {
      return "Non-Unique";
    } else {
      return "Unique";
    }
  }

  private function formatRedirectURL($campaign, $click_id)
  {
    // Determine What Affiliate Network it would be

    $aff_network = AffiliateNetwork::find($campaign->affiliate_network_id);
    $aff_parameters = explode("=", $aff_network->affiliate_network_parameter);
    $parameters = [
      $aff_parameters[0] => $click_id
    ];
    if (!is_null($campaign->affiliate_network_url)) {

      if ($aff_network->id == 2) {
        $redirect_url = $campaign->affiliate_network_url;
      } else {
        $redirect_url = $campaign->affiliate_network_url . '&' . http_build_query($parameters);
      }
    } else {
      $redirect_url = "-";
    }

    return $redirect_url;
  }

  private function getClientDevice()
  {
    $device = "";

    if (Browser::isMobile()) {
      $device = "Mobile";
    }
    if (Browser::isTablet()) {
      $device = "Tablet";
    }
    if (Browser::isDesktop()) {
      $device = "Desktop";
    }

    return $device;
  }

  private function getClientPlatform()
  {
    $iPod = stripos($_SERVER['HTTP_USER_AGENT'], "iPod");
    $iPhone = stripos($_SERVER['HTTP_USER_AGENT'], "iPhone");
    $iPad = stripos($_SERVER['HTTP_USER_AGENT'], "iPad");
    $Android = stripos($_SERVER['HTTP_USER_AGENT'], "Android");
    $webOS = stripos($_SERVER['HTTP_USER_AGENT'], "webOS");

    if ($iPod || $iPhone) {
      $device_type = "iPhone";
    } else {
      if ($iPad) {
        $device_type = "iPad";
      } else {
        if ($Android) {
          $device_type = "Android";
        } else {
          if ($webOS) {
            $device_type = "webOS";
          } else {
            $device_type = "Unknown";
          }
        }
      }
    }

    return $device_type;
  }

  private function getClientBrowser()
  {
    $platform = "Chrome";

    if (Browser::isFirefox()) {
      $platform = "Firefox";
    }
    if (Browser::isOpera()) {
      $platform = "Opera";
    }
    if (Browser::isSafari()) {
      $platform = "Safari";
    }
    if (Browser::isIE()) {
      $platform = "IE";
    }
    if (Browser::isEdge()) {
      $platform = "Microsoft Edge";
    }

    return $platform;
  }

}
