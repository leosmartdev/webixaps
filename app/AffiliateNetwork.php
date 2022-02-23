<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AffiliateNetwork extends Model
{
    //
    protected $table = 'affiliate_networks';

    protected $fillable = [
        'affiliate_network_name',
        'affiliate_network_parameter',
        'affiliate_network_postback_parameters'
    ];

}
