<?php

namespace Modules\WebResources\Tasks;

use Illuminate\Database\Eloquent\Collection;
use Modules\WebResources\Models\WebResource;

class GetWebResourcesTask
{
    public function run(): Collection
    {
        return WebResource::query()
            ->select(['id', 'address_site_1', 'address_site_2', 'address_site_3', 'address_video', 'active'])
            ->get();
    }
}
