<?php

namespace Modules\Statistics\Tasks\QualityIndicators;

use Illuminate\Database\Eloquent\Collection;

class GetCoefficientLossTask
{
    public function run(Collection $collection): float|int
    {
        $condition1 = $collection
            ->where('loss_ping', '>', 0)
            ->avg('loss_ping');

        $condition2 = $collection
            ->where('medium_ping', '>', 0)
            ->avg('medium_ping');

        return round($condition2 > 0 ? $condition1 / $condition2 * 100 : 0, 2);
    }
}
