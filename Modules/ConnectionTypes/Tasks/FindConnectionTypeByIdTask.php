<?php

namespace Modules\ConnectionTypes\Tasks;

use Illuminate\Database\Eloquent\Model;
use Modules\ConnectionTypes\Models\ConnectionType;

class FindConnectionTypeByIdTask
{
    public function run(int $id): Model
    {
        return ConnectionType::query()->findOrFail($id);
    }
}
