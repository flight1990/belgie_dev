<?php

namespace Modules\Standards\Actions;

use Illuminate\Database\Eloquent\Model;
use Modules\Standards\Tasks\UpdateStandardTask;

class UpdateStandardAction
{
    public function run(array $payload, int $id): Model
    {
        return app(UpdateStandardTask::class)->run($payload, $id);
    }
}
