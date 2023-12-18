<?php

namespace Modules\Standards\Actions;

use Illuminate\Database\Eloquent\Model;
use Modules\Standards\Tasks\DeleteStandardTask;

class DeleteStandardAction
{
    public function run(int $id): Model
    {
        return app(DeleteStandardTask::class)->run($id);
    }
}
