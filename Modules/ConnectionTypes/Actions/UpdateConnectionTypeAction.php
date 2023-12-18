<?php

namespace Modules\ConnectionTypes\Actions;

use Illuminate\Database\Eloquent\Model;
use Modules\ConnectionTypes\Tasks\UpdateConnectionTypeTask;

class UpdateConnectionTypeAction
{
    public function run(array $payload, int $id): Model
    {
        return app(UpdateConnectionTypeTask::class)->run($payload, $id);
    }
}
