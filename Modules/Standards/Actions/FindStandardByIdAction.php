<?php

namespace Modules\Standards\Actions;

use Illuminate\Database\Eloquent\Model;
use Modules\Standards\Tasks\FindStandardByIdTask;

class FindStandardByIdAction
{
    public function run(int $id): Model
    {
        return app(FindStandardByIdTask::class)->run($id);
    }
}
