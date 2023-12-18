<?php

namespace Modules\Roles\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\AdminUsers\Models\AdminUser;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesTableSeeder extends Seeder
{

    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            [
                'name' => 'roles.index',
                'module' => 'Roles',
                'description' => 'Просмотр ролей',
                'guard_name' => 'admin'
            ],
            [
                'name' => 'roles.create',
                'module' => 'Roles',
                'description' => 'Создание роли',
                'guard_name' => 'admin'
            ],
            [
                'name' => 'roles.edit',
                'module' => 'Roles',
                'description' => 'Редактирование роли',
                'guard_name' => 'admin'
            ],
            [
                'name' => 'roles.destroy',
                'module' => 'Roles',
                'description' => 'Удаление роли',
                'guard_name' => 'admin'
            ],
            [
                'name' => 'admin-users.index',
                'module' => 'Admin Users',
                'description' => 'Просмотр администраторов',
                'guard_name' => 'admin'
            ],
            [
                'name' => 'admin-users.create',
                'module' => 'Admin Users',
                'description' => 'Создание администратора',
                'guard_name' => 'admin'
            ],
            [
                'name' => 'admin-users.edit',
                'module' => 'Admin Users',
                'description' => 'Редактирование администратора',
                'guard_name' => 'admin'
            ],
            [
                'name' => 'admin-users.destroy',
                'module' => 'Admin Users',
                'description' => 'Удаление администратора',
                'guard_name' => 'admin'
            ],
            [
                'name' => 'users.index',
                'module' => 'Users',
                'description' => 'Просмотр пользователей',
                'guard_name' => 'admin'
            ],
            [
                'name' => 'users.create',
                'module' => 'Users',
                'description' => 'Создание пользователя',
                'guard_name' => 'admin'
            ],
            [
                'name' => 'users.edit',
                'module' => 'Users',
                'description' => 'Редактирование пользователя',
                'guard_name' => 'admin'
            ],
            [
                'name' => 'users.destroy',
                'module' => 'Users',
                'description' => 'Удаление пользователя',
                'guard_name' => 'admin'
            ],
            [
                'name' => 'statistics.index',
                'module' => 'Statistics',
                'description' => 'Просмотр статистики',
                'guard_name' => 'admin'
            ],
            [
                'name' => 'maps.towers.index',
                'module' => 'Maps',
                'description' => 'Просмотр карты вышека',
                'guard_name' => 'admin'
            ],
            [
                'name' => 'maps.tests.index',
                'module' => 'Maps',
                'description' => 'Просмотр карты тестов',
                'guard_name' => 'admin'
            ],
            [
                'name' => 'operators.index',
                'module' => 'Operators',
                'description' => 'Просмотр операторов',
                'guard_name' => 'admin'
            ],
            [
                'name' => 'operators.create',
                'module' => 'Operators',
                'description' => 'Создание оператора',
                'guard_name' => 'admin'
            ],
            [
                'name' => 'operators.edit',
                'module' => 'Operators',
                'description' => 'Редактирование оператора',
                'guard_name' => 'admin'
            ],
            [
                'name' => 'operators.destroy',
                'module' => 'Operators',
                'description' => 'Удаление оператора',
                'guard_name' => 'admin'
            ],
            [
                'name' => 'servers.index',
                'module' => 'Servers',
                'description' => 'Просмотр серверов',
                'guard_name' => 'admin'
            ],
            [
                'name' => 'servers.create',
                'module' => 'Servers',
                'description' => 'Создание сервера',
                'guard_name' => 'admin'
            ],
            [
                'name' => 'servers.edit',
                'module' => 'Servers',
                'description' => 'Редактирование сервера',
                'guard_name' => 'admin'
            ],
            [
                'name' => 'servers.destroy',
                'module' => 'Servers',
                'description' => 'Удаление сервера',
                'guard_name' => 'admin'
            ],
            [
                'name' => 'towers.index',
                'module' => 'Towers',
                'description' => 'Просмотр вышек',
                'guard_name' => 'admin'
            ],
            [
                'name' => 'towers.create',
                'module' => 'Towers',
                'description' => 'Создание вышки',
                'guard_name' => 'admin'
            ],
            [
                'name' => 'towers.edit',
                'module' => 'Towers',
                'description' => 'Редактирование вышки',
                'guard_name' => 'admin'
            ],
            [
                'name' => 'towers.destroy',
                'module' => 'Towers',
                'description' => 'Удаление вышки',
                'guard_name' => 'admin'
            ],
            [
                'name' => 'standards.index',
                'module' => 'Standards',
                'description' => 'Просмотр стандартов',
                'guard_name' => 'admin'
            ],
            [
                'name' => 'standards.create',
                'module' => 'Standards',
                'description' => 'Создание стандарта',
                'guard_name' => 'admin'
            ],
            [
                'name' => 'standards.edit',
                'module' => 'Standards',
                'description' => 'Редактирование стандарта',
                'guard_name' => 'admin'
            ],
            [
                'name' => 'standards.destroy',
                'module' => 'Standards',
                'description' => 'Удаление стандарта',
                'guard_name' => 'admin'
            ],
            [
                'name' => 'web-resources.index',
                'module' => 'Web Resources',
                'description' => 'Просмотр web ресурсов',
                'guard_name' => 'admin'
            ],
            [
                'name' => 'web-resources.create',
                'module' => 'Web Resources',
                'description' => 'Создание web ресурса',
                'guard_name' => 'admin'
            ],
            [
                'name' => 'web-resources.edit',
                'module' => 'Web Resources',
                'description' => 'Редактирование web ресурса',
                'guard_name' => 'admin'
            ],
            [
                'name' => 'web-resources.destroy',
                'module' => 'Web Resources',
                'description' => 'Удаление web ресурса',
                'guard_name' => 'admin'
            ],
            [
                'name' => 'connection-types.index',
                'module' => 'Connection Types',
                'description' => 'Просмотр технологий',
                'guard_name' => 'admin'
            ],
            [
                'name' => 'connection-types.create',
                'module' => 'Connection Types',
                'description' => 'Создание технологии',
                'guard_name' => 'admin'
            ],
            [
                'name' => 'connection-types.edit',
                'module' => 'Connection Types',
                'description' => 'Редактирование технологии',
                'guard_name' => 'admin'
            ],
            [
                'name' => 'connection-types.destroy',
                'module' => 'Connection Types',
                'description' => 'Удаление технологии',
                'guard_name' => 'admin'
            ],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }

        $permissions = Permission::all();

        $roles = [
            [
                'name' => 'Super Admin',
                'guard_name' => 'admin'
            ],
            [
                'name' => 'Admin',
                'guard_name' => 'admin'
            ]
        ];

        foreach ($roles as $role) {
            $role =  Role::create($role);
            $role->syncPermissions($permissions);
        }

        $admins = AdminUser::all();

        foreach ($admins as $admin) {
            $admin->assignRole($role);
        }
    }
}
