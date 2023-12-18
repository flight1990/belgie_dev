<?php

namespace Modules\Roles\Actions;

use Modules\Roles\Tasks\DeleteRoleTask;

class DeleteRoleAction
{
    public function run(int $id)
    {
        return app(DeleteRoleTask::class)->run($id);
    }
}
