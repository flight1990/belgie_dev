<?php

namespace App\Policies;

use Modules\Standards\Models\Standard;
use Modules\AdminUsers\Models\AdminUser;
use Illuminate\Auth\Access\HandlesAuthorization;

class StandardsPolicy
{
    use HandlesAuthorization;

    public function viewAny(AdminUser $adminUser): bool
    {
        return true;
    }

    public function view(AdminUser $adminUser, Standard $standard): bool
    {
        return true;
    }

    public function create(AdminUser $adminUser): bool
    {
        return true;
    }

    public function update(AdminUser $adminUser, Standard $standard): bool
    {
        return true;
    }

    public function delete(AdminUser $adminUser, Standard $standard): bool
    {
        return true;
    }
}
