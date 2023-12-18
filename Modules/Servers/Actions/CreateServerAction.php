<?php

namespace Modules\Servers\Actions;

use Illuminate\Database\Eloquent\Model;
use Modules\Servers\Tasks\CreateServerTask;

class CreateServerAction
{
    public function run(array $payload): Model
    {
        return app(CreateServerTask::class)->run($payload);
    }
}
