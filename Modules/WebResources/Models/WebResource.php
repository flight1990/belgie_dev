<?php

namespace Modules\WebResources\Models;

use Illuminate\Database\Eloquent\Model;

class WebResource extends Model
{
    protected $fillable = [
        'address_site_1',
        'address_site_2',
        'address_site_3',
        'address_video',
        'active'
    ];

    protected $casts = [
        'active' => 'boolean'
    ];
}
