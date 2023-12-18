<?php

namespace Modules\Users\Actions;

use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Users\Tasks\GetUsersTask;

class GetUsersAction
{
    public function run($params = []): LengthAwarePaginator
    {
        return app(GetUsersTask::class)->run($params);
    }
}
