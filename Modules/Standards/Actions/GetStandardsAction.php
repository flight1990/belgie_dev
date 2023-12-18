<?php

namespace Modules\Standards\Actions;

use Illuminate\Database\Eloquent\Collection;
use Modules\Standards\Tasks\GetStandardsTask;

class GetStandardsAction
{
    public function run(): Collection
    {
        return app(GetStandardsTask::class)->run();
    }
}
