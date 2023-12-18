<?php

namespace Modules\Servers\Actions;

use Illuminate\Database\Eloquent\Model;
use Modules\Servers\Tasks\DeleteServerTask;

class DeleteServerAction
{
    public function run(int $id):Model
    {
        return app(DeleteServerTask::class)->run($id);
    }
}
