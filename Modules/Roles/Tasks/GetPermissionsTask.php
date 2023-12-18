<?php

namespace Modules\Roles\Tasks;

use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Permission;

class GetPermissionsTask
{
    public function run(): Collection|array
    {
        return Permission::query()
            ->select(['id', 'name', 'description', 'module'])
            ->get();
    }
}
