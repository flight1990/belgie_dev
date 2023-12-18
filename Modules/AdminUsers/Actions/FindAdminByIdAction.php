<?php

namespace Modules\AdminUsers\Actions;

use Illuminate\Database\Eloquent\Model;
use Modules\AdminUsers\Tasks\FindAdminByIdTask;

class FindAdminByIdAction
{
    public function run(int $id): Model
    {
        return app(FindAdminByIdTask::class)->run($id);
    }
}
