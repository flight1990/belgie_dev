<?php

namespace Modules\Standards\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Tests\Models\Test;

class Standard extends Model
{
    protected $fillable = [
        'id',
        'name',
    ];

    public function tests(): HasMany
    {
        return $this->hasMany(Test::class);
    }
}
