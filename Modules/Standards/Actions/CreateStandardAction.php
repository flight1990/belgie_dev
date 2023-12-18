<?php

namespace Modules\Standards\Actions;

use Illuminate\Database\Eloquent\Model;
use Modules\Standards\Tasks\CreateStandardTask;

class CreateStandardAction
{
    public function run(array $payload): Model
    {
        return app(CreateStandardTask::class)->run($payload);
    }
}
