<?php

namespace Modules\Statistics\Tasks\QualityParameters;

use Illuminate\Database\Eloquent\Collection;

class GetCountIpPaketTask
{
    public function run(Collection $collection): int
    {
        return $collection
            ->where('max_ping', '>', 0)
            ->count();
    }
}
