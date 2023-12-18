<?php

namespace Modules\AdminUsers\Tasks;

use Illuminate\Database\Eloquent\Model;
use Modules\AdminUsers\Models\AdminUser;

class FindAdminByIdTask
{
    public function run(int $id): Model
    {
        return AdminUser::query()
            ->where('id', '!=', 1)
            ->findOrFail($id);
    }
}
