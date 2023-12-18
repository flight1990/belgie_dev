<?php

namespace Modules\Roles\Actions;

use Modules\Roles\Tasks\CreateRoleTask;

class CreateRoleAction
{
    public function run(array $data)
    {
        return app(CreateRoleTask::class)->run($data);
    }
}
