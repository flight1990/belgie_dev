<?php

namespace Modules\Operators\Tasks;

use Illuminate\Database\Eloquent\Collection;
use Modules\Operators\Models\Operator;

class GetOperatorsTask
{
    public function run(): Collection
    {
        return Operator::query()
            ->select(['id', 'name', 'provider', 'mnc'])
            ->get();
    }
}
