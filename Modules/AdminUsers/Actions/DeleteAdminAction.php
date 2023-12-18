<?php

namespace Modules\AdminUsers\Actions;

use Illuminate\Database\Eloquent\Model;
use Modules\AdminUsers\Tasks\DeleteAdminTask;

class DeleteAdminAction
{
    public function run(int $id): Model
    {
        return app(DeleteAdminTask::class)->run($id);
    }
}
