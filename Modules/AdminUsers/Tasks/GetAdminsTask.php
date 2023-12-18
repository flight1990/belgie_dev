<?php

namespace Modules\AdminUsers\Tasks;

use Illuminate\Database\Eloquent\Collection;
use Modules\AdminUsers\Models\AdminUser;

class GetAdminsTask
{
    public function run(): Collection
    {
        return AdminUser::query()
            ->where('id', '!=', 1)
            ->select(['id', 'name', 'email', 'login', 'created_at', 'updated_at'])
            ->get();
    }
}
