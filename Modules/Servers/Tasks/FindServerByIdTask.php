<?php

namespace Modules\Servers\Tasks;

use Illuminate\Database\Eloquent\Model;
use Modules\Servers\Models\Server;

class FindServerByIdTask
{
    public function run(int $id): Model
    {
        return Server::query()->findOrFail($id);
    }
}
