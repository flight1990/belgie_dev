<?php

namespace Modules\AdminUsers\Actions;

use Illuminate\Database\Eloquent\Model;
use Modules\AdminUsers\Tasks\CreateAdminTask;

class CreateAdminAction
{
    public function run(array $data): Model
    {
        return app(CreateAdminTask::class)->run($data);
    }
}
