<?php

namespace Modules\Servers\Actions;

use Illuminate\Database\Eloquent\Model;
use Modules\Servers\Tasks\FindServerByIdTask;

class FindServerByIdAction
{
    public function run(int $id): Model
    {
        return app(FindServerByIdTask::class)->run($id);
    }
}
