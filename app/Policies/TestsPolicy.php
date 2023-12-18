<?php

namespace App\Policies;

use Modules\Tests\Models\Test;
use Modules\AdminUsers\Models\AdminUser;
use Illuminate\Auth\Access\HandlesAuthorization;

class TestsPolicy
{
    use HandlesAuthorization;

    public function viewAny(AdminUser $adminUser): bool
    {
        return true;
    }


    public function view(AdminUser $adminUser, Test $test): bool
    {
        return true;
    }


    public function create(AdminUser $adminUser): bool
    {
        return true;
    }


    public function update(AdminUser $adminUser, Test $test): bool
    {
        return true;
    }


    public function delete(AdminUser $adminUser, Test $test): bool
    {
        return true;
    }
}
