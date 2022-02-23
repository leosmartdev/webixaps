<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\FeedCategory;


class FeedCategoryController extends Controller
{
 
    public function feed_category_ajax_list(){
        $feed_categories = FeedCategory::orderBy('created_at', 'asc')->get();
        $feed_categoriesJson = json_encode($feed_categories);
        
        return $feed_categoriesJson;
    }
}
