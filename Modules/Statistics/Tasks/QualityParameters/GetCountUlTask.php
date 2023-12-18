<?php

namespace Modules\Statistics\Tasks\QualityParameters;

use Illuminate\Database\Eloquent\Collection;

class GetCountUlTask
{
    public function run(Collection $collection): int
    {
        return $collection
            ->where('min_speed_upload', '>', 0)
            ->count();
    }
}
