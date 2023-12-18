<?php

namespace Modules\WebResources\Tasks;

use Illuminate\Database\Eloquent\Model;
use Modules\WebResources\Models\WebResource;

class FindWebResourceByIdTask
{
    public function run(int $id): Model
    {
        return WebResource::query()->findOrFail($id);
    }
}
