<?php

namespace Modules\Towers\Actions;

use Illuminate\Database\Eloquent\Model;
use Modules\Towers\Tasks\FindTowerByIdTask;

class FindTowerByIdAction
{
    public function run(int $id): Model
    {
        return app(FindTowerByIdTask::class)->run($id);
    }
}
