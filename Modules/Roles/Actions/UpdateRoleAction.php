<?php

namespace Modules\Roles\Actions;

use Modules\Roles\Tasks\UpdateRoleTask;

class UpdateRoleAction
{
    public function run(array $data, int $id)
    {
        return app(UpdateRoleTask::class)->run($data, $id);
    }
}
