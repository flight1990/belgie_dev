<?php

namespace Modules\Servers\Actions;

use Illuminate\Database\Eloquent\Model;
use Modules\Servers\Tasks\UpdateServerTask;

class UpdateServerAction
{
    public function run(array $payload, int $id): Model
    {
        return app(UpdateServerTask::class)->run($payload, $id);
    }
}
