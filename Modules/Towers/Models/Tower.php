<?php

namespace Modules\Towers\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Operators\Models\Operator;
use Modules\Standards\Models\Standard;
use Modules\Tests\Models\Test;
use Modules\Towers\Database\factories\TowerFactory;

class Tower extends Model
{
    use HasFactory;

    protected $fillable = [
        'standard_id',
        'operator_id',
        'bsn',
        'lac',
        'cell_id',
        'mnc',
        'x',
        'y',
        'band',
        'sector',
    ];

    protected static function newFactory(): TowerFactory
    {
        return TowerFactory::new();
    }

    public function getDistance($coordinates): float|int
    {
        return (6371 * acos(cos(deg2rad($coordinates['x']))
                * cos(deg2rad($this['x']))
                * cos(deg2rad($this['y']) - deg2rad($coordinates['y']))
                + sin(deg2rad($coordinates['x'])) * sin(deg2rad( $this['x']))));
    }

    public function standard(): BelongsTo
    {
        return $this->belongsTo(Standard::class);
    }

    public function operator(): BelongsTo
    {
        return $this->belongsTo(Operator::class);
    }

    public function tests(): HasMany
    {
        return $this->hasMany(Test::class);
    }

    public function getCountTestsAttribute(): int
    {
        $count_tests = Test::where('tower_id', $this['id'])->count();
        return is_null($count_tests) ? 0 : $count_tests;
    }
}
