<?php

namespace Modules\WebResources\Actions;

use Illuminate\Database\Eloquent\Model;
use Modules\WebResources\Tasks\UpdateWebResourceTask;

class UpdateWebResourceAction
{
    public function run(array $payload, int $id):Model
    {
        return app(UpdateWebResourceTask::class)->run($payload, $id);
    }
}
