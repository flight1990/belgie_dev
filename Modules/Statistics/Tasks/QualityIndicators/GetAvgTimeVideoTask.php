<?php

namespace Modules\Statistics\Tasks\QualityIndicators;

use Illuminate\Database\Eloquent\Collection;

class GetAvgTimeVideoTask
{
    public function run(Collection $collection): float|int|null
    {
        return round($collection
            ->where('time_start', '>', 0)
            ->avg('time_start'), 2);
    }
}
