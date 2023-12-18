<?php

namespace Modules\Roles\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use Inertia\Response;
use Modules\AdminUsers\Actions\GetAdminsAction;
use Modules\Roles\Actions\CreateRoleAction;
use Modules\Roles\Actions\DeleteRoleAction;
use Modules\Roles\Actions\FindRoleByIdAction;
use Modules\Roles\Actions\GetPermissionsAction;
use Modules\Roles\Actions\GetRolesAction;
use Modules\Roles\Actions\UpdateRoleAction;
use Modules\Roles\Http\Requests\CreateRoleRequest;
use Modules\Roles\Http\Requests\UpdateRoleRequest;
use Modules\Roles\Transformers\PermissionResource;
use Modules\Roles\Transformers\RoleResource;
use Modules\Users\Actions\GetUsersAction;
use Modules\Users\Transformers\UserResource;

class RolesController extends Controller
{
    public function index(): Response
    {
        $roles = app(GetRolesAction::class)->run();

        return Inertia::render('Roles::Index/Page', [
            'roles' => RoleResource::collection($roles)
        ]);
    }

    public function create(): Response
    {
        $permissions = app(GetPermissionsAction::class)->run();
        $users = app(GetAdminsAction::class)->run();

        return Inertia::render('Roles::Edit/Page', [
            'permissions' => PermissionResource::collection($permissions)->collection->groupBy('module'),
            'users' => UserResource::collection($users)
        ]);
    }

    public function store(CreateRoleRequest $request): RedirectResponse
    {
        app(CreateRoleAction::class)->run($request->validated());

        return redirect()->route('roles.index')->with('message', [
            'message' => 'Запись успешно создана.',
            'type' => 'success'
        ]);
    }

    public function edit(int $id): Response
    {
        $role = app(FindRoleByIdAction::class)->run($id);
        $rolePermissions = $role->permissions->pluck('id')->toArray();

        $permissions = app(GetPermissionsAction::class)->run();

        $users = app(GetAdminsAction::class)->run();
        $roleUsers = $role->users->where('id', '!=', 1)->pluck('id')->toArray();

        return Inertia::render('Roles::Edit/Page', [
            'role' => new RoleResource($role),
            'permissions' => PermissionResource::collection($permissions)->collection->groupBy('module'),
            'users' => UserResource::collection($users),
            'rolePermissions' => $rolePermissions,
            'roleUsers' => $roleUsers
        ]);
    }

    public function update(UpdateRoleRequest $request, int $id): RedirectResponse
    {
        app(UpdateRoleAction::class)->run($request->validated(), $id);

        return redirect()->route('roles.index')->with('message', [
            'message' => 'Запись успешно обновлена.',
            'type' => 'success'
        ]);
    }

    public function destroy(int $id): RedirectResponse
    {
        app(DeleteRoleAction::class)->run($id);

        return redirect()->route('roles.index')->with('message', [
            'message' => 'Запись успешно удалена.',
            'type' => 'success'
        ]);
    }
}
