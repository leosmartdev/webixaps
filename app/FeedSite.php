<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeedSite extends Model
{
    //
    protected $table = 'feed_sites';

    protected $fillable = [
        'feed_site_name',
        'feed_site_domain',
        'feed_site_status'
    ];
}
