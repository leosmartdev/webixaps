<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeedCategory extends Model
{
    //
    protected $table = 'feed_categories';

    protected $fillable = [
        'feed_category_name'
    ];


}
