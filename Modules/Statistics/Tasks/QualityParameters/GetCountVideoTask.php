<?php

namespace Modules\Statistics\Tasks\QualityParameters;

use Illuminate\Database\Eloquent\Collection;

class GetCountVideoTask
{
    public function run(Collection $collection): int
    {
        return $collection
            ->whereNotNull('address_youtube')
            ->count();
    }
}
