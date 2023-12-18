<?php

namespace App\Http\Middleware;

use Menu;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class GenerateMenus
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if ($user) {
            Menu::make('menu', function ($menu) use ($user) {

                $menu->add('Профиль', route('profile.edit'))
                    ->nickname('profile')
                    ->attr(['icon' => 'mdi-account-star']);

                $menu->add('Тесты', route('tests.index'))
                    ->nickname('tests')
                    ->attr(['icon' => 'mdi-poll']);

                if ($user->hasAnyPermission(['statistics.index'])) {
                    $menu->add('Статистика', route('statistics.index'))
                        ->nickname('statistics')
                        ->attr(['icon' => 'mdi-finance']);
                }

                $menu->add('Карты', ['disableActivationByURL' => true])
                    ->nickname('maps')
                    ->attr(['icon' => 'mdi-map-legend']);

                if ($user->hasAnyPermission(['maps.towers.index'])) {
                    $menu->item('maps')
                        ->add('Карта вышека', route('maps.towers.index'))
                        ->active('maps/towers/*')
                        ->attr(['icon' => 'mdi-radio-tower']);
                }

                if ($user->hasAnyPermission(['maps.tests.index'])) {
                    $menu->item('maps')
                        ->add('Карта тестов', route('maps.tests.index'))
                        ->active('maps/tests/*')
                        ->attr(['icon' => 'mdi-poll']);
                }

                $menu->add('Роли и пользователи', ['disableActivationByURL' => true])
                    ->nickname('acl')
                    ->attr(['icon' => 'mdi-briefcase-account']);

                if ($user->hasAnyPermission(['admin-users.index', 'admin-users.create', 'admin-users.edit', 'admin-users.destroy'])) {
                    $menu->item('acl')
                        ->add('Администраноры', route('admin-users.index'))
                        ->active('admin-users/*')
                        ->attr(['icon' => 'mdi-account-group']);
                }

                if ($user->hasAnyPermission(['roles.index', 'roles.create', 'roles.edit', 'roles.destroy'])) {
                    $menu->item('acl')
                        ->add('Роли', route('roles.index'))
                        ->active('roles/*')
                        ->attr(['icon' => 'mdi-treasure-chest']);
                }

                $menu->add('Администрирование', ['disableActivationByURL' => true])
                    ->nickname('administration')
                    ->attr(['icon' => 'mdi-list-box']);

                if ($user->hasAnyPermission(['users.index', 'users.create', 'users.edit', 'users.destroy'])) {
                    $menu->item('administration')
                        ->add('Пользователи', route('users.index'))
                        ->active('administration/users/*')
                        ->attr(['icon' => 'mdi-account-group']);
                }

                if ($user->hasAnyPermission(['operators.index', 'operators.create', 'operators.edit', 'operators.destroy'])) {
                    $menu->item('administration')
                        ->add('Операторы', route('operators.index'))
                        ->active('administration/operators/*')
                        ->attr(['icon' => 'mdi-cellphone-basic']);
                }

                if ($user->hasAnyPermission(['towers.index', 'towers.create', 'towers.edit', 'towers.destroy'])) {
                    $menu->item('administration')
                        ->add('Вышки', route('towers.index'))
                        ->active('administration/towers/*')
                        ->attr(['icon' => 'mdi-radio-tower']);
                }

                if ($user->hasAnyPermission(['servers.index', 'servers.create', 'servers.edit', 'servers.destroy'])) {
                    $menu->item('administration')
                        ->add('Серверы', route('servers.index'))
                        ->active('administration/servers/*')
                        ->attr(['icon' => 'mdi-server-network']);
                }

                if ($user->hasAnyPermission(['standards.index', 'standards.create', 'standards.edit', 'standards.destroy'])) {
                    $menu->item('administration')
                        ->add('Стандарты', route('standards.index'))
                        ->active('administration/standards/*')
                        ->attr(['icon' => 'mdi-standard-definition']);
                }

                if ($user->hasAnyPermission(['web-resources.index', 'web-resources.create', 'web-resources.edit', 'web-resources.destroy'])) {
                    $menu->item('administration')
                        ->add('Web ресурсы', route('web-resources.index'))
                        ->active('administration/web-resources/*')
                        ->attr(['icon' => 'mdi-web']);
                }

                if ($user->hasAnyPermission(['connection-types.index', 'connection-types.create', 'connection-types.edit', 'connection-types.destroy'])) {
                    $menu->item('administration')
                        ->add('Технологии', route('connection-types.index'))
                        ->active('administration/connection-types/*')
                        ->attr(['icon' => 'mdi-cast-connected']);
                }
            });
        }

        return $next($request);
    }
}
