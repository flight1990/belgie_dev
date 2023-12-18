<?php

namespace Modules\Towers\Actions;

use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Towers\Tasks\GetTowersTask;

class GetTowersAction
{
    public function run(array $params = []): LengthAwarePaginator
    {
        return app(GetTowersTask::class)->run($params);
    }
}
