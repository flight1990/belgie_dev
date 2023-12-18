<?php

namespace Modules\Statistics\Tasks\QualityIndicators;

use Illuminate\Database\Eloquent\Collection;

class GetAvgDlTask
{
    public function run(Collection $collection): float|int|null
    {
        return round($collection
            ->where('medium_speed_download', '>', 0)
            ->avg('medium_speed_download'), 2);
    }
}
