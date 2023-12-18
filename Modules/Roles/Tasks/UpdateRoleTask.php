<?php

namespace Modules\Roles\Tasks;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class UpdateRoleTask
{
    public function run(array $data, int $id): Model|Collection|Builder|array|null
    {
        $role = Role::query()->findOrFail($id);

        $role->update([
            'name' => $data['name'],
        ]);

        $role->syncPermissions($data['permissions']);
        $role->users()->sync($data['users']);

        return $role;
    }
}
