<?php

namespace Modules\Roles\Tasks;

use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Role;

class GetRolesTask
{
    public function run(): Collection|array
    {
        return Role::query()
            ->select(['id', 'name'])
            ->where('id', '!=', 1)
            ->get();
    }
}
