<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\AdminUsers\Database\Seeders\AdminUsersDatabaseSeeder;
use Modules\ConnectionTypes\Database\Seeders\ConnectionTypesDatabaseSeeder;
use Modules\Operators\Database\Seeders\OperatorsDatabaseSeeder;
use Modules\Roles\Database\Seeders\RolesDatabaseSeeder;
use Modules\Servers\Database\Seeders\ServersDatabaseSeeder;
use Modules\Standards\Database\Seeders\StandardsDatabaseSeeder;
use Modules\Towers\Database\Seeders\TowersDatabaseSeeder;
use Modules\Users\Database\Seeders\UsersDatabaseSeeder;
use Modules\WebResources\Database\Seeders\WebResourcesDatabaseSeeder;
use Modules\Tests\Database\Seeders\TestsDatabaseSeeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminUsersDatabaseSeeder::class,
            UsersDatabaseSeeder::class,
            RolesDatabaseSeeder::class,
            ConnectionTypesDatabaseSeeder::class,
            OperatorsDatabaseSeeder::class,
            StandardsDatabaseSeeder::class,
            ServersDatabaseSeeder::class,
            WebResourcesDatabaseSeeder::class,
            TowersDatabaseSeeder::class,
            TestsDatabaseSeeder::class
        ]);
    }
}
