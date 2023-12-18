<?php

namespace Modules\Statistics\Tasks\QualityIndicators;

use Illuminate\Database\Eloquent\Collection;

class GetAvgUlTask
{
    public function run(Collection $collection): float|int
    {
        return round($collection
            ->where('min_speed_upload', '>', 0)
            ->avg('min_speed_upload'), 2);
    }
}
