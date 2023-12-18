<?php

namespace App\Policies;

use Modules\AdminUsers\Models\AdminUser;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminUsersPolicy
{
    use HandlesAuthorization;

    public function viewAny(AdminUser $adminUser): bool
    {
        return true;
    }

    public function view(AdminUser $adminUser, AdminUser $user): bool
    {
        return true;
    }

    public function create(AdminUser $adminUser): bool
    {
        return true;
    }

    public function update(AdminUser $adminUser, AdminUser $user): bool
    {
        return true;
    }

    public function delete(AdminUser $adminUser, AdminUser $user): bool
    {
        return true;
    }
}
