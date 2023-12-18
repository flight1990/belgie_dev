<?php

namespace App\Policies;

use Modules\WebResources\Models\WebResource;
use Modules\AdminUsers\Models\AdminUser;
use Illuminate\Auth\Access\HandlesAuthorization;

class WebResourcesPolicy
{
    use HandlesAuthorization;

    public function viewAny(AdminUser $adminUser): bool
    {
        return  true;
    }

    public function view(AdminUser $adminUser, WebResource $webResource): bool
    {
        return true;
    }

    public function create(AdminUser $adminUser): bool
    {
        return true;
    }

    public function update(AdminUser $adminUser, WebResource $webResource): bool
    {
        return true;
    }

    public function delete(AdminUser $adminUser, WebResource $webResource): bool
    {
        return true;
    }
}
