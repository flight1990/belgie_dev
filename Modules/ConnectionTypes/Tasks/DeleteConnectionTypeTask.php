<?php

namespace Modules\ConnectionTypes\Tasks;

use Illuminate\Database\Eloquent\Model;
use Modules\ConnectionTypes\Models\ConnectionType;

class DeleteConnectionTypeTask
{
    public function run(int $id): Model
    {
        $connectionType = ConnectionType::query()->findOrFail($id);
        $connectionType->delete();

        return $connectionType;
    }
}
