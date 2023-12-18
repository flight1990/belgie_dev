<?php

namespace Modules\Operators\Actions;

use Illuminate\Database\Eloquent\Model;
use Modules\Operators\Tasks\UpdateOperatorTask;

class UpdateOperatorAction
{
    public function run(array $payload, int $id): Model
    {
       return app(UpdateOperatorTask::class)->run($payload, $id);
    }
}
