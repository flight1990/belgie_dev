<?php

namespace Modules\Towers\Actions;

use Illuminate\Database\Eloquent\Model;
use Modules\Towers\Tasks\CreateTowerTask;

class CreateTowerAction
{
    public function run(array $payload): Model
    {
        return app(CreateTowerTask::class)->run($payload);
    }
}
