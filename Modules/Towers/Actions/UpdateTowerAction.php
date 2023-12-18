<?php

namespace Modules\Towers\Actions;

use Illuminate\Database\Eloquent\Model;
use Modules\Towers\Tasks\UpdateTowerTask;

class UpdateTowerAction
{
    public function run(array $payload, int $id): Model
    {
        return app(UpdateTowerTask::class)->run($payload, $id);
    }
}
