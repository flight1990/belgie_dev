<?php

namespace Modules\Users\Actions;

use Illuminate\Database\Eloquent\Model;
use Modules\Users\Tasks\FindUserByIdTask;

class FindUserByIdAction
{
    public function run(int $id): Model
    {
        return app(FindUserByIdTask::class)->run($id);
    }
}
