<?php

namespace Modules\Standards\Tasks;

use Illuminate\Database\Eloquent\Collection;
use Modules\Standards\Models\Standard;

class GetStandardsTask
{
    public function run(): Collection
    {
        return Standard::query()
            ->select(['id', 'name'])
            ->get();
    }
}
