<?php

namespace Modules\AdminUsers\Database\Seeders;

use Illuminate\Database\Seeder;

class AdminUsersDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminUserTableSeeder::class
        ]);
    }
}
