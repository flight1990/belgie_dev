<?php

namespace Modules\Operators\Actions;

use Illuminate\Database\Eloquent\Model;
use Modules\Operators\Tasks\FindOperatorByIdTask;

class FindOperatorByIdAction
{
    public function run(int $id): Model
    {
        return app(FindOperatorByIdTask::class)->run($id);
    }
}
