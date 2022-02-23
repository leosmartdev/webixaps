<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\FeedSubcategory;


class FeedSubcategoryController extends Controller
{
    public function find_subcategories(Request $request){

        $feed_subcategories = FeedSubcategory::findFeedSubCategories($request->get('country_id'), $request->get('feed_category_id'));

        //dd($feed_subcategories);
        $feed_subcategoriesJson = json_encode($feed_subcategories);
        
        echo $feed_subcategoriesJson;
    }
}
