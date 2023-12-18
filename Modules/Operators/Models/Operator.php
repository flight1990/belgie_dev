<?php

namespace Modules\Operators\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Tests\Models\Test;

class Operator extends Model
{
    protected $fillable = [
        'name',
        'provider',
        'mnc',
    ];

    public function tests(): HasMany
    {
        return $this->hasMany(Test::class);
    }
}
