<?php

namespace Modules\Roles\Actions;

use Modules\Roles\Tasks\GetRolesTask;

class GetRolesAction
{
    public function run()
    {
        return app(GetRolesTask::class)->run();
    }
}
