<?php

namespace Modules\Statistics\Tasks\QualityParameters;

use Illuminate\Database\Eloquent\Collection;

class GetCountDlTask
{
    public function run(Collection $collection): int
    {
        return $collection
            ->where('medium_speed_download', '>', 0)
            ->count();
    }
}
