<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class FeedCategoryExtraField extends Model
{
    //
    protected $table = 'feed_category_extra_fields';

    protected $fillable = [
        'feed_category_id',
        'feed_category_field_name',
        'feed_category_field_type',
        'feed_category_field_label',
        'feed_category_field_required'
    ];

    // Fetch Provider Categories
    public static function getFields($feed_category_id, $fcf_ids = array()){

        $value = DB::table('feed_category_extra_fields')
        ->where('feed_category_id', $feed_category_id)
        ->select(
        'feed_category_extra_fields.id as id',
        'feed_category_extra_fields.feed_category_field_name as name',
        'feed_category_extra_fields.feed_category_field_type as type',
        'feed_category_extra_fields.feed_category_field_label as label',
        'feed_category_extra_fields.feed_category_field_required as required',
        'feed_category_extra_fields.feed_category_field_label_help as help',
        'feed_category_extra_fields.feed_category_field_options as options')
        ->get(); 

        return $value;

    }

}
