<?php

namespace App\Policies;

use Modules\Towers\Models\Tower;
use Modules\AdminUsers\Models\AdminUser;
use Illuminate\Auth\Access\HandlesAuthorization;

class TowersPolicy
{
    use HandlesAuthorization;

    public function viewAny(AdminUser $adminUser): bool
    {
        return true;
    }

    public function view(AdminUser $adminUser, Tower $tower): bool
    {
        return true;
    }

    public function viewStandard(AdminUser $adminUser, Tower $tower): bool
    {
        return $this->view($adminUser, $tower);
    }

    public function viewOperator(AdminUser $adminUser, Tower $tower): bool
    {
        return $this->view($adminUser, $tower);
    }

    public function create(AdminUser $adminUser): bool
    {
        return true;
    }

    public function update(AdminUser $adminUser, Tower $tower): bool
    {
        return true;
    }

    public function delete(AdminUser $adminUser, Tower $tower): bool
    {
        return true;
    }

    public function getLocationTowers(AdminUser $adminUser, Tower $tower): bool
    {
        return  true;
    }

    public function getStartTower(AdminUser $adminUser, Tower $tower): bool
    {
        return  true;
    }

}
