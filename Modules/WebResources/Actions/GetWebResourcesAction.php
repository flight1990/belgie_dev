<?php

namespace Modules\WebResources\Actions;

use Illuminate\Database\Eloquent\Collection;
use Modules\WebResources\Tasks\GetWebResourcesTask;

class GetWebResourcesAction
{
    public function run(): Collection
    {
        return app(GetWebResourcesTask::class)->run();
    }
}
