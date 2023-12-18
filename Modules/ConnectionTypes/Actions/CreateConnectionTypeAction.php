<?php

namespace Modules\ConnectionTypes\Actions;

use Modules\ConnectionTypes\Tasks\CreateConnectionTypeTask;

class CreateConnectionTypeAction
{
    public function run(array $payload)
    {
        return app(CreateConnectionTypeTask::class)->run($payload);
    }
}
