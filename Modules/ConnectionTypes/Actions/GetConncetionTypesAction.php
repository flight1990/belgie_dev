<?php

namespace Modules\ConnectionTypes\Actions;

use Illuminate\Database\Eloquent\Collection;
use Modules\ConnectionTypes\Tasks\GetConnectionTypesTask;

class GetConncetionTypesAction
{
    public function run(): Collection
    {
        return app(GetConnectionTypesTask::class)->run();
    }
}
