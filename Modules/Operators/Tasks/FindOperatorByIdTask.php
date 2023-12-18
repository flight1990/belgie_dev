<?php

namespace Modules\Operators\Tasks;

use Illuminate\Database\Eloquent\Model;
use Modules\Operators\Models\Operator;

class FindOperatorByIdTask
{
    public function run(int $id): Model
    {
        return Operator::query()->findOrFail($id);
    }
}
