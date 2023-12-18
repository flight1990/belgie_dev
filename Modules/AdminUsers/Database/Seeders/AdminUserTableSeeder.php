<?php

namespace Modules\AdminUsers\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\AdminUsers\Models\AdminUser;

class AdminUserTableSeeder extends Seeder
{
    public function run(): void
    {
        $admins = [
            [
                'name' => 'Борисюк Владимир',
                'email' => 'vladimirborisiuk@gmail.com',
            ],
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
            ]
        ];

        foreach ($admins as $admin) {
            $user = AdminUser::factory()->create($admin);
        }
    }
}
