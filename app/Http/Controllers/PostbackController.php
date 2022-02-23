<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ClickEvent;
use App\Postback;
use App\Campaign;
use App\Country;

class PostbackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //

        if ($request->has('click_id')) {

            $click_id = $request->get('click_id');
            $payout = $request->get('payout');

            $click_event = ClickEvent::find($click_id);

            if($click_event){

                // Validate Aff ID on Click Details

                if ($request->has('aff_id')) {
                    if ($request->get('aff_id') != $click_event->campaign_affiliate_network){
                        return "Affiliate ID not matched!";
                    }
                }else{
                    return "Affiliate ID not recognized!";
                }
                
                // Get Click Event Important Details
                $campaign_id = $click_event->campaign_id;
                $affiliate_network_id = $request->get('aff_id');

                // Get Campaign 

                $campaign = Campaign::find($campaign_id);

                // Get Country

                $country = Country::find($campaign->country_id);



                // Update Click Event
                $currencies = $this->getCurrency();


                $click_event->payout = $click_event->payout + (float) $payout;
                $click_event->currency = $currencies[$country->country_code];
                $click_event->conversion_status = ($request->has('status'))?$request->get('status'):"Accepted";
                $click_event->save();

                // Insert Postback
                $postback = new Postback([
                    'campaign_id' => $campaign_id,
                    'click_event_id' => $click_id,
                    'affiliate_network_id' => $affiliate_network_id,
                    'currency' => $currencies[$country->country_code],
                    'payout' => (float) $payout,
                    'commission' => ($request->has('commission'))?$request->get('commission'):0,
                    'status' => ($request->has('status'))?$request->get('status'):"Accepted",
                    'email' => ($request->has('email'))?$request->get('email'): null
                ]);

                $postback->save();
                return true;
            }else{
                return "Click ID not found!";
            }

        }else{
            return "Click ID Required!";
        }


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

    private function getCurrency(){
        return array(
            'AF' => 'AFN',
            'AL' => 'ALL',
            'DZ' => 'DZD',
            'AS' => 'USD',
            'AD' => 'EUR',
            'AO' => 'AOA',
            'AI' => 'XCD',
            'AQ' => 'XCD',
            'AG' => 'XCD',
            'AR' => 'ARS',
            'AM' => 'AMD',
            'AW' => 'AWG',
            'AU' => 'AUD',
            'AT' => 'EUR',
            'AZ' => 'AZN',
            'BS' => 'BSD',
            'BH' => 'BHD',
            'BD' => 'BDT',
            'BB' => 'BBD',
            'BY' => 'BYR',
            'BE' => 'EUR',
            'BZ' => 'BZD',
            'BJ' => 'XOF',
            'BM' => 'BMD',
            'BT' => 'BTN',
            'BO' => 'BOB',
            'BA' => 'BAM',
            'BW' => 'BWP',
            'BV' => 'NOK',
            'BR' => 'BRL',
            'IO' => 'USD',
            'BN' => 'BND',
            'BG' => 'BGN',
            'BF' => 'XOF',
            'BI' => 'BIF',
            'KH' => 'KHR',
            'CM' => 'XAF',
            'CA' => 'CAD',
            'CV' => 'CVE',
            'KY' => 'KYD',
            'CF' => 'XAF',
            'TD' => 'XAF',
            'CL' => 'CLP',
            'CN' => 'CNY',
            'HK' => 'HKD',
            'CX' => 'AUD',
            'CC' => 'AUD',
            'CO' => 'COP',
            'KM' => 'KMF',
            'CG' => 'XAF',
            'CD' => 'CDF',
            'CK' => 'NZD',
            'CR' => 'CRC',
            'HR' => 'HRK',
            'CU' => 'CUP',
            'CY' => 'EUR',
            'CZ' => 'CZK',
            'DK' => 'DKK',
            'DJ' => 'DJF',
            'DM' => 'XCD',
            'DO' => 'DOP',
            'EC' => 'ECS',
            'EG' => 'EGP',
            'SV' => 'SVC',
            'GQ' => 'XAF',
            'ER' => 'ERN',
            'EE' => 'EUR',
            'ET' => 'ETB',
            'FK' => 'FKP',
            'FO' => 'DKK',
            'FJ' => 'FJD',
            'FI' => 'EUR',
            'FR' => 'EUR',
            'GF' => 'EUR',
            'TF' => 'EUR',
            'GA' => 'XAF',
            'GM' => 'GMD',
            'GE' => 'GEL',
            'DE' => 'EUR',
            'GH' => 'GHS',
            'GI' => 'GIP',
            'GR' => 'EUR',
            'GL' => 'DKK',
            'GD' => 'XCD',
            'GP' => 'EUR',
            'GU' => 'USD',
            'GT' => 'QTQ',
            'GG' => 'GGP',
            'GN' => 'GNF',
            'GW' => 'GWP',
            'GY' => 'GYD',
            'HT' => 'HTG',
            'HM' => 'AUD',
            'HN' => 'HNL',
            'HU' => 'HUF',
            'IS' => 'ISK',
            'IN' => 'INR',
            'ID' => 'IDR',
            'IR' => 'IRR',
            'IQ' => 'IQD',
            'IE' => 'EUR',
            'IM' => 'GBP',
            'IL' => 'ILS',
            'IT' => 'EUR',
            'JM' => 'JMD',
            'JP' => 'JPY',
            'JE' => 'GBP',
            'JO' => 'JOD',
            'KZ' => 'KZT',
            'KE' => 'KES',
            'KI' => 'AUD',
            'KP' => 'KPW',
            'KR' => 'KRW',
            'KW' => 'KWD',
            'KG' => 'KGS',
            'LA' => 'LAK',
            'LV' => 'EUR',
            'LB' => 'LBP',
            'LS' => 'LSL',
            'LR' => 'LRD',
            'LY' => 'LYD',
            'LI' => 'CHF',
            'LT' => 'EUR',
            'LU' => 'EUR',
            'MK' => 'MKD',
            'MG' => 'MGF',
            'MW' => 'MWK',
            'MY' => 'MYR',
            'MV' => 'MVR',
            'ML' => 'XOF',
            'MT' => 'EUR',
            'MH' => 'USD',
            'MQ' => 'EUR',
            'MR' => 'MRO',
            'MU' => 'MUR',
            'YT' => 'EUR',
            'MX' => 'MXN',
            'FM' => 'USD',
            'MD' => 'MDL',
            'MC' => 'EUR',
            'MN' => 'MNT',
            'ME' => 'EUR',
            'MS' => 'XCD',
            'MA' => 'MAD',
            'MZ' => 'MZN',
            'MM' => 'MMK',
            'NA' => 'NAD',
            'NR' => 'AUD',
            'NP' => 'NPR',
            'NL' => 'EUR',
            'AN' => 'ANG',
            'NC' => 'XPF',
            'NZ' => 'NZD',
            'NI' => 'NIO',
            'NE' => 'XOF',
            'NG' => 'NGN',
            'NU' => 'NZD',
            'NF' => 'AUD',
            'MP' => 'USD',
            'NO' => 'NOK',
            'OM' => 'OMR',
            'PK' => 'PKR',
            'PW' => 'USD',
            'PA' => 'PAB',
            'PG' => 'PGK',
            'PY' => 'PYG',
            'PE' => 'PEN',
            'PH' => 'PHP',
            'PN' => 'NZD',
            'PL' => 'PLN',
            'PT' => 'EUR',
            'PR' => 'USD',
            'QA' => 'QAR',
            'RE' => 'EUR',
            'RO' => 'RON',
            'RU' => 'RUB',
            'RW' => 'RWF',
            'SH' => 'SHP',
            'KN' => 'XCD',
            'LC' => 'XCD',
            'PM' => 'EUR',
            'VC' => 'XCD',
            'WS' => 'WST',
            'SM' => 'EUR',
            'ST' => 'STD',
            'SA' => 'SAR',
            'SN' => 'XOF',
            'RS' => 'RSD',
            'SC' => 'SCR',
            'SL' => 'SLL',
            'SG' => 'SGD',
            'SK' => 'EUR',
            'SI' => 'EUR',
            'SB' => 'SBD',
            'SO' => 'SOS',
            'ZA' => 'ZAR',
            'GS' => 'GBP',
            'SS' => 'SSP',
            'ES' => 'EUR',
            'LK' => 'LKR',
            'SD' => 'SDG',
            'SR' => 'SRD',
            'SJ' => 'NOK',
            'SZ' => 'SZL',
            'SE' => 'SEK',
            'CH' => 'CHF',
            'SY' => 'SYP',
            'TW' => 'TWD',
            'TJ' => 'TJS',
            'TZ' => 'TZS',
            'TH' => 'THB',
            'TG' => 'XOF',
            'TK' => 'NZD',
            'TO' => 'TOP',
            'TT' => 'TTD',
            'TN' => 'TND',
            'TR' => 'TRY',
            'TM' => 'TMT',
            'TC' => 'USD',
            'TV' => 'AUD',
            'UG' => 'UGX',
            'UA' => 'UAH',
            'AE' => 'AED',
            'GB' => 'GBP',
            'US' => 'USD',
            'UM' => 'USD',
            'UY' => 'UYU',
            'UZ' => 'UZS',
            'VU' => 'VUV',
            'VE' => 'VEF',
            'VN' => 'VND',
            'VI' => 'USD',
            'WF' => 'XPF',
            'EH' => 'MAD',
            'YE' => 'YER',
            'ZM' => 'ZMW',
            'ZW' => 'ZWD',
        );
    }
}
