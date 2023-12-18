<?php

namespace Modules\WebResources\Actions;

use Illuminate\Database\Eloquent\Model;
use Modules\WebResources\Tasks\DeleteWebResourceTask;

class DeleteWebResourceAction
{
    public function run(int $id): Model
    {
        return app(DeleteWebResourceTask::class)->run($id);
    }
}
