<?php

namespace Modules\WebResources\Tasks;
use Modules\WebResources\Models\WebResource;

class CreateWebResourceTask
{
    public function run(array $payload)
    {
        return WebResource::create($payload);
    }
}
