<?php

namespace Modules\Standards\Tasks;

use Illuminate\Database\Eloquent\Model;
use Modules\Standards\Models\Standard;

class FindStandardByIdTask
{
    public function run(int $id): Model
    {
        return Standard::query()->findOrFail($id);
    }
}
