<?php

namespace Modules\Operators\Actions;

use Illuminate\Database\Eloquent\Collection;
use Modules\Operators\Tasks\GetOperatorsTask;

class GetOperatorsAction
{
    public function run(): Collection
    {
        return app(GetOperatorsTask::class)->run();
    }
}
