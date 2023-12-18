<?php

namespace Modules\Standards\Tasks;

use Illuminate\Database\Eloquent\Model;
use Modules\Standards\Models\Standard;

class UpdateStandardTask
{
    public function run(array $payload, int $id): Model
    {
        $standard = Standard::query()->findOrFail($id);
        $standard->update($payload);

        return $standard;
    }
}
