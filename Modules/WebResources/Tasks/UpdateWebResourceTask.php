<?php

namespace Modules\WebResources\Tasks;

use Illuminate\Database\Eloquent\Model;
use Modules\WebResources\Models\WebResource;

class UpdateWebResourceTask
{
    public function run(array $payload, int $id): Model
    {
        $webResource = WebResource::query()->findOrFail($id);
        $webResource->update($payload);

        return $webResource;
    }
}
