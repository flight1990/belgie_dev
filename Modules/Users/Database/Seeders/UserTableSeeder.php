<?php

namespace Modules\Users\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Users\Models\User;

class UserTableSeeder extends Seeder
{
    public function run(): void
    {
       User::factory('50')->create();
    }
}
