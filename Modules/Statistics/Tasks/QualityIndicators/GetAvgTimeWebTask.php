<?php

namespace Modules\Statistics\Tasks\QualityIndicators;

use Illuminate\Database\Eloquent\Collection;

class GetAvgTimeWebTask
{
    public function run(Collection $collection): float|int
    {
        $condition1 = $collection
            ->where('time_download_web_1', '>', 0)
            ->avg('time_download_web_1');

        $condition2 = $collection
            ->where('time_download_web_2', '>', 0)
            ->avg('time_download_web_2');

        $condition3 = $collection
            ->where('time_download_web_3', '>', 0)
            ->avg('time_download_web_3');

        return round(($condition1 + $condition2 + $condition3) / 3, 2);
    }
}
