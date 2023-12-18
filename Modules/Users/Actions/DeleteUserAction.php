<?php

namespace Modules\Users\Actions;

use Illuminate\Database\Eloquent\Model;
use Modules\Users\Tasks\DeleteUserTask;

class DeleteUserAction
{
    public function run(int $id): Model
    {
        return app(DeleteUserTask::class)->run($id);
    }
}
