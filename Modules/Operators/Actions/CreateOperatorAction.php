<?php

namespace Modules\Operators\Actions;

use Illuminate\Database\Eloquent\Model;
use Modules\Operators\Tasks\CreateOperatorTask;

class CreateOperatorAction
{
    public function run(array $payload): Model
    {
        return app(CreateOperatorTask::class)->run($payload);
    }
}
