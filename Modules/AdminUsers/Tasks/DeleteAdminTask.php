<?php

namespace Modules\AdminUsers\Tasks;

use Illuminate\Database\Eloquent\Model;
use Modules\AdminUsers\Models\AdminUser;

class DeleteAdminTask
{
    public function run(int $id): Model
    {
        $admin = AdminUser::query()->findOrFail($id);
        $admin->delete();

        return $admin;
    }
}
