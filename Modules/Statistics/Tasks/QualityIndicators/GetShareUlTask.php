<?php

namespace Modules\Statistics\Tasks\QualityIndicators;

use Illuminate\Database\Eloquent\Collection;

class GetShareUlTask
{
    public function run(Collection $collection): float|int
    {
        $condition1 = $collection
            ->whereBetween('min_speed_upload', [0.1, 1])
            ->count();

        $condition2 = $collection
            ->where('min_speed_upload', '>', 0)
            ->count();

        return round($condition2 > 0 ? $condition1 / $condition2 * 100 : 0, 2);
    }
}
