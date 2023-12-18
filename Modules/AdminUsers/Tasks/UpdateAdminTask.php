<?php

namespace Modules\AdminUsers\Tasks;

use Illuminate\Database\Eloquent\Model;
use Modules\AdminUsers\Models\AdminUser;

class UpdateAdminTask
{
    public function run(array $data, int $id): Model
    {
        $admin = AdminUser::query()->findOrFail($id);

        $admin->update($data);
        $admin->syncRoles($data['roles']);

        return $admin;
    }
}
