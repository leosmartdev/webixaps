<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Country;

class CountryController extends Controller
{
    
    public function country_ajax_list(){

        $countries = Country::all();
        $countriesJson = json_encode($countries);
        
        return $countriesJson;
    }
}
