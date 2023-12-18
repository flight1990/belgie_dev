<?php

namespace Modules\Operators\Tasks;

use Illuminate\Database\Eloquent\Model;
use Modules\Operators\Models\Operator;

class CreateOperatorTask
{
    public function run(array $payload): Model
    {
        return Operator::create($payload);
    }
}
