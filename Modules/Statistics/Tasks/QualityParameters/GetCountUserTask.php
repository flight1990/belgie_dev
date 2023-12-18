<?php

namespace Modules\Statistics\Tasks\QualityParameters;

use Illuminate\Database\Eloquent\Collection;

class GetCountUserTask
{
    public function run(Collection $collection): int
    {
        return $collection
            ->unique('user_id')
            ->count();
    }
}
