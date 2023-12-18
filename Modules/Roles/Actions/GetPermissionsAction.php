<?php

namespace Modules\Roles\Actions;

use Modules\Roles\Tasks\GetPermissionsTask;

class GetPermissionsAction
{
    public function run()
    {
        return app(GetPermissionsTask::class)->run();
    }

}
