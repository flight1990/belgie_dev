<?php

namespace Modules\ConnectionTypes\Tasks;

use Illuminate\Database\Eloquent\Model;
use Modules\ConnectionTypes\Models\ConnectionType;

class UpdateConnectionTypeTask
{
    public function run(array $payload, int $id): Model
    {
        $connectionType = ConnectionType::query()->findOrFail($id);
        $connectionType->update($payload);

        return $connectionType;
    }
}
