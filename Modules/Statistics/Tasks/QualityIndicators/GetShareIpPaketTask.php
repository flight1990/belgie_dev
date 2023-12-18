<?php

namespace Modules\Statistics\Tasks\QualityIndicators;

use Illuminate\Database\Eloquent\Collection;

class GetShareIpPaketTask
{
    public function run(Collection $collection): float|int
    {
        $condition1 = $collection
            ->where('medium_ping', '>', 400)
            ->count();

        $condition2 = $collection
            ->where('medium_ping', '>', 0)
            ->count();

        return round($condition2 > 0 ? $condition1 / $condition2 * 100 : 0, 2);
    }
}
