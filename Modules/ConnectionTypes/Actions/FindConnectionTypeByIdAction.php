<?php

namespace Modules\ConnectionTypes\Actions;

use Illuminate\Database\Eloquent\Model;
use Modules\ConnectionTypes\Tasks\FindConnectionTypeByIdTask;

class FindConnectionTypeByIdAction
{
    public function run(int $id): Model
    {
        return app(FindConnectionTypeByIdTask::class)->run($id);
    }
}
