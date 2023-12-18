<?php

namespace Modules\Roles\Tasks;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class FindRoleByIdTasks
{
    public function run(int $id): Model|Collection|Builder|array|null
    {
        return Role::query()
            ->with(['permissions'])
            ->where('id', '!=', 1)
            ->findOrFail($id);
    }
}
