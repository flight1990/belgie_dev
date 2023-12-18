<?php

namespace Modules\ConnectionTypes\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Tests\Models\Test;

class ConnectionType extends Model
{
    protected $fillable = [
        'name',
    ];

    public function tests(): HasMany
    {
        return $this->hasMany(Test::class);
    }
}
