<?php

namespace Modules\ConnectionTypes\Tasks;

use Illuminate\Database\Eloquent\Collection;
use Modules\ConnectionTypes\Models\ConnectionType;

class GetConnectionTypesTask
{
    public function run(): Collection
    {
        return ConnectionType::query()
            ->select(['id', 'name'])
            ->get();
    }
}
