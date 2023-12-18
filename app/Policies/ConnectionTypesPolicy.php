<?php

namespace App\Policies;

use Modules\AdminUsers\Models\AdminUser;
use Modules\ConnectionTypes\Models\ConnectionType;
use Illuminate\Auth\Access\HandlesAuthorization;

class ConnectionTypesPolicy
{
    use HandlesAuthorization;

    public function viewAny(AdminUser $adminUser): bool
    {
        return true;
    }

    public function view(AdminUser $adminUser, Connectiontype $connecctionType): bool
    {
        return true;
    }

    public function create(AdminUser $adminUser): bool
    {
        return true;
    }

    public function update(AdminUser $adminUser, Connectiontype $connecctionType): bool
    {
        return true;
    }

    public function delete(AdminUser $adminUser, Connectiontype $connecctionType): bool
    {
        return true;
    }
}
