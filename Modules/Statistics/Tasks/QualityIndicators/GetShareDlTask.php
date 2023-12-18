<?php

namespace Modules\Statistics\Tasks\QualityIndicators;

use Illuminate\Database\Eloquent\Collection;

class GetShareDlTask
{
    public function run(Collection $collection): float|int
    {
        $condition1 = $collection
            ->whereBetween('medium_speed_download', [0.1, 1])
            ->count();

        $condition2 = $collection
            ->where('medium_speed_download', '>', 0)
            ->count();

        return round($condition2 > 0 ? $condition1 / $condition2 * 100 : 0, 2);
    }
}
