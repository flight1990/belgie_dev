<?php

namespace Modules\Users\Database\Seeders;

use Illuminate\Database\Seeder;

class UsersDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserTableSeeder::class
        ]);
    }
}
