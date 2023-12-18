<?php

namespace Modules\Roles\Actions;

use Modules\Roles\Tasks\FindRoleByIdTasks;

class FindRoleByIdAction
{
    public function run(int $id)
    {
        return app(FindRoleByIdTasks::class)->run($id);
    }
}
