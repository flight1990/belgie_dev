<?php

namespace Modules\ConnectionTypes\Actions;

use Illuminate\Database\Eloquent\Model;
use Modules\ConnectionTypes\Tasks\DeleteConnectionTypeTask;

class DeleteConnectionTypeAction
{
    public function run(int $id): Model
    {
        return app(DeleteConnectionTypeTask::class)->run($id);
    }
}
