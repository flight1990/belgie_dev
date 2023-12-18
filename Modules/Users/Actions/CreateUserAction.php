<?php

namespace Modules\Users\Actions;

use Illuminate\Database\Eloquent\Model;
use Modules\Users\Tasks\CreateUserTask;

class CreateUserAction
{
    public function run(array $data): Model
    {
        return app(CreateUserTask::class)->run($data);
    }
}
