<?php

namespace Modules\Roles\Tasks;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class CreateRoleTask
{
    public function run(array $data): Model|Builder
    {
        $role = Role::create(['name' => $data['name']]);

        $role->syncPermissions($data['permissions']);
        $role->users()->sync($data['users']);

        return $role;
    }
}
