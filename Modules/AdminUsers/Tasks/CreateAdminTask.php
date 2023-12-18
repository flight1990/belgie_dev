<?php

namespace Modules\AdminUsers\Tasks;

use Illuminate\Database\Eloquent\Model;
use Modules\AdminUsers\Models\AdminUser;

class CreateAdminTask
{
    public function run(array $data): Model
    {
        $data['password'] = bcrypt($data['password']);

        $admin = AdminUser::create($data);
        $admin->syncRoles($data['roles']);

        return $admin;
    }
}
