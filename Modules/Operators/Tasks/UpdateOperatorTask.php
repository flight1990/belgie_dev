<?php

namespace Modules\Operators\Tasks;

use Illuminate\Database\Eloquent\Model;
use Modules\Operators\Models\Operator;

class UpdateOperatorTask
{
    public function run(array $payload, int $id): Model
    {
        $operator = Operator::query()->findOrFail($id);
        $operator->update($payload);

        return $operator;
    }
}
