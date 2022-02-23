<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CampaignDisplaySettings extends Model
{
    //
    protected $table = 'campaign_display_settings';

    protected $fillable = [
        'campaign_id',
        'feed_site_id',
        'feed_display_type'
    ];
}
