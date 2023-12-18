<?php

namespace Modules\AdminUsers\Actions;

use Illuminate\Database\Eloquent\Collection;
use Modules\AdminUsers\Tasks\GetAdminsTask;

class GetAdminsAction
{
    public function run(): Collection
    {
        return app(GetAdminsTask::class)->run();
    }
}
