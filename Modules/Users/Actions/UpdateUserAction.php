<?php

namespace Modules\Users\Actions;

use Illuminate\Database\Eloquent\Model;
use Modules\Users\Tasks\UpdateUserTask;

class UpdateUserAction
{
    public function run(array $data, int $id): Model
    {
        if (!empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        return app(UpdateUserTask::class)->run($data, $id);
    }
}
