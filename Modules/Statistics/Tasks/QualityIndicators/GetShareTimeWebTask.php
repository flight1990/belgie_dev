<?php

namespace Modules\Statistics\Tasks\QualityIndicators;

use Illuminate\Database\Eloquent\Collection;

class GetShareTimeWebTask
{
    public function run(Collection $collection): float|int
    {
        $condition1 = $collection
            ->where('time_download_web_1', '>', 6)
            ->count();

        $condition2 = $collection
            ->where('time_download_web_2', '>', 6)
            ->count();

        $condition3 = $collection
            ->where('time_download_web_3', '>', 6)
            ->count();

        $condition4 = $collection
            ->where('time_download_web_1', '>', 0)
            ->count();

        return round($condition4 > 0 ? ($condition1 + $condition2 + $condition3) / (($condition4 * 3) * 100) : 0, 2);
    }
}
