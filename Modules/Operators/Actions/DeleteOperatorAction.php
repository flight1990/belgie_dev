<?php

namespace Modules\Operators\Actions;

use Illuminate\Database\Eloquent\Model;
use Modules\Operators\Tasks\DeleteOperatorTask;

class DeleteOperatorAction
{
    public function run(int $id): Model
    {
        return app(DeleteOperatorTask::class)->run($id);
    }
}
