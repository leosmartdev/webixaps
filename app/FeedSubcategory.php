<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class FeedSubcategory extends Model
{
    //
    protected $table = 'feed_subcategories';

    protected $fillable = [
        'feed_subcategory_name',
        'country_id',
        'feed_category_id',
    ];

    public function feed_subcategory_feed_category()
    {
        return $this->hasOne('App\FeedCategory');
    }

    public function feed_subcategory_country()
    {
        return $this->hasOne('App\Country');
    }

    public static function getFeedSubCategories(){

        $value = DB::table('feed_subcategories')
        ->join('countries', 'feed_subcategories.country_id', '=', 'countries.id')
        ->join('feed_categories', 'feed_subcategories.feed_category_id', '=', 'feed_categories.id')
        ->select('feed_subcategories.id', 'feed_subcategories.feed_subcategory_name','countries.country_name', 'feed_categories.feed_category_name')
        ->orderBy('feed_subcategories.created_at', 'asc')->get(); 

        return $value;

    }
    public static function findFeedSubCategories($country_id, $feed_category_id){

        $value = DB::table('feed_subcategories')
        ->orderBy('feed_subcategories.created_at', 'asc')
        ->where('feed_subcategories.country_id', '=', $country_id)
        ->where('feed_subcategories.feed_category_id', '=', $feed_category_id)
        ->select('feed_subcategories.id', 'feed_subcategories.feed_subcategory_name')
        ->get(); 

        return $value;

    }

}
