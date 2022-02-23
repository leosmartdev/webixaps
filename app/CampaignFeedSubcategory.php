<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CampaignFeedSubcategory extends Model
{
    //

    protected $table = 'campaign_feed_subcategories';

    protected $fillable = [
        'campaign_id',
        'feed_subcategory_id'
    ];
}
