<?php

namespace Modules\WebResources\Actions;

use Illuminate\Database\Eloquent\Model;
use Modules\WebResources\Tasks\FindWebResourceByIdTask;

class FindWebResourceByIdAction
{
    public function run(int $id):Model
    {
        return app(FindWebResourceByIdTask::class)->run($id);
    }
}
