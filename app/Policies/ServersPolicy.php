<?php

namespace App\Policies;

use Modules\Servers\Models\Server;
use Modules\AdminUsers\Models\AdminUser;
use Illuminate\Auth\Access\HandlesAuthorization;

class ServersPolicy
{
    use HandlesAuthorization;

    public function viewAny(AdminUser $adminUser): bool
    {
        return true;
    }

    public function view(AdminUser $adminUser, Server $server): bool
    {
        return true;
    }

    public function create(AdminUser $adminUser): bool
    {
        return true;
    }

    public function update(AdminUser $adminUser, Server $server): bool
    {
        return true;
    }

    public function delete(AdminUser $adminUser, Server $server)
    {
        return true;
    }
}
