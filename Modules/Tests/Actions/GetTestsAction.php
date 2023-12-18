<?php

namespace Modules\Tests\Actions;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Modules\Tests\Tasks\GetTestsTask;

class GetTestsAction
{
    public function run(array $params = []): LengthAwarePaginator
    {
        return app(GetTestsTask::class)->run($params);
    }
}
