<?php

namespace Modules\Statistics\Tasks\QualityParameters;

use Illuminate\Database\Eloquent\Collection;

class GetCountFullTestsTask
{
    public function run(Collection $collection): int
    {
        return $collection
            ->where('medium_speed_download', '>', 0)
            ->whereNotNull('address_site_1')
            ->whereNotNull('address_youtube')
            ->count();
    }
}
