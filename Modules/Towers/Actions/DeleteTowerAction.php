<?php

namespace Modules\Towers\Actions;

use Illuminate\Database\Eloquent\Model;
use Modules\Towers\Tasks\DeleteTowerTask;

class DeleteTowerAction
{
    public function run(int $id): Model
    {
        return app(DeleteTowerTask::class)->run($id);
    }
}
