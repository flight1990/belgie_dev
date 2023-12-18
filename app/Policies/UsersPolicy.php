<?php

namespace App\Policies;

use Modules\Users\Models\User;
use Modules\AdminUsers\Models\AdminUser;
use Illuminate\Auth\Access\HandlesAuthorization;

class UsersPolicy
{
    use HandlesAuthorization;

    public function viewAny(AdminUser $adminUser): bool
    {
        return true;
    }

    public function view(AdminUser $adminUser, User $user): bool
    {
        return true;
    }

    public function create(AdminUser $adminUser): bool
    {
        return true;
    }

    public function update(AdminUser $adminUser, User $user): bool
    {
        return true;
    }

    public function delete(AdminUser $adminUser, User $user): bool
    {
        return true;
    }
}
