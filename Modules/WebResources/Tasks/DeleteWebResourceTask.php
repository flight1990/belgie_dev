<?php

namespace Modules\WebResources\Tasks;

use Illuminate\Database\Eloquent\Model;
use Modules\WebResources\Models\WebResource;

class DeleteWebResourceTask
{
    public function run(int $id): Model
    {
        $webResource = WebResource::query()->findOrFail($id);
        $webResource->delete();

        return $webResource;
    }
}
