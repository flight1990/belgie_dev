<?php

namespace Modules\Operators\Tasks;

use Illuminate\Database\Eloquent\Model;
use Modules\Operators\Models\Operator;

class DeleteOperatorTask
{
    public function run(int $id): Model
    {
        $operator = Operator::query()->findOrFail($id);
        $operator->delete();

        return $operator;
    }
}
