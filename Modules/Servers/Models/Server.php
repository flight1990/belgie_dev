<?php

namespace Modules\Servers\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Tests\Models\Test;

class Server extends Model
{
    protected $fillable = [
        'id',
        'name',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function tests(): HasMany
    {
        return $this->hasMany(Test::class);
    }
}
