<?php

namespace Modules\Standards\Tasks;

use Illuminate\Database\Eloquent\Model;
use Modules\Standards\Models\Standard;

class DeleteStandardTask
{
    public function run(int $id): Model
    {
        $standard = Standard::query()->findOrFail($id);
        $standard->delete();

        return $standard;
    }
}
