<?php

namespace Modules\Statistics\Tasks\QualityParameters;

use Illuminate\Database\Eloquent\Collection;

class GetCountWebTask
{
    public function run(Collection $collection): int
    {
        return $collection
            ->whereNotNull('address_site_1')
            ->count();
    }
}
