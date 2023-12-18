<?php

namespace Modules\WebResources\Actions;

use Illuminate\Database\Eloquent\Model;
use Modules\WebResources\Tasks\CreateWebResourceTask;

class CreateWebResourceAction
{
    public function run(array $payload): Model
    {
        return app(CreateWebResourceTask::class)->run($payload);
    }
}
