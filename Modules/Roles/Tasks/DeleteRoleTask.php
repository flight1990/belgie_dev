<?php

namespace Modules\Roles\Tasks;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class DeleteRoleTask
{
    public function run(int $id): Model|Collection|Builder|array|null
    {
        $role = Role::query()->findOrFail($id);
        $role->delete();

        return $role;
    }
}
