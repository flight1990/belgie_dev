<?php

namespace Modules\Servers\Actions;

use Illuminate\Database\Eloquent\Collection;
use Modules\Servers\Tasks\GetServersTask;

class GetServersAction
{
    public function run(): Collection
    {
        return app(GetServersTask::class)->run();
    }
}
