<?php

namespace App\Policies;

use Modules\Operators\Models\Operator;
use Modules\AdminUsers\Models\AdminUser;
use Illuminate\Auth\Access\HandlesAuthorization;

class OperatorsPolicy
{
    use HandlesAuthorization;

    public function viewAny(AdminUser $adminUser): bool
    {
        return true;
    }

    public function view(AdminUser $adminUser, Operator $operator): bool
    {
        return true;
    }

    public function create(AdminUser $adminUser): bool
    {
        return true;
    }

    public function update(AdminUser $adminUser, Operator $operator): bool
    {
        return true;
    }

    public function delete(AdminUser $adminUser, Operator $operator): bool
    {
        return true;
    }

}
