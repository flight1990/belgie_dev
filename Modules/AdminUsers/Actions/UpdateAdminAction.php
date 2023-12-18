<?php

namespace Modules\AdminUsers\Actions;

use Illuminate\Database\Eloquent\Model;
use Modules\AdminUsers\Tasks\UpdateAdminTask;

class UpdateAdminAction
{
    public function run(array $data, int $id): Model
    {
        if (!empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        return app(UpdateAdminTask::class)->run($data, $id);
    }
}
