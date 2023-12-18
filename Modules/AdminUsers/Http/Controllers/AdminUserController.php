<?php

namespace Modules\AdminUsers\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use Inertia\Response;
use Modules\AdminUsers\Actions\CreateAdminAction;
use Modules\AdminUsers\Actions\DeleteAdminAction;
use Modules\AdminUsers\Actions\FindAdminByIdAction;
use Modules\AdminUsers\Actions\GetAdminsAction;
use Modules\AdminUsers\Actions\UpdateAdminAction;
use Modules\AdminUsers\Http\Requests\CreateAdminUserRequest;
use Modules\AdminUsers\Http\Requests\UpdateAdminUserRequest;
use Modules\AdminUsers\Transformers\AdminUserResource;
use Modules\Roles\Actions\GetRolesAction;
use Modules\Roles\Transformers\RoleResource;

class AdminUserController extends Controller
{
    public function index(Request $request): Response
    {
        $admins = app(GetAdminsAction::class)->run();

        return Inertia::render('AdminUsers::Index/Page', [
            'admins' => AdminUserResource::collection($admins)
        ]);
    }

    public function create(): Response
    {
        $roles = app(GetRolesAction::class)->run();

        return Inertia::render('AdminUsers::Edit/Page', [
            'roles' => RoleResource::collection($roles)
        ]);
    }

    public function store(CreateAdminUserRequest $request): RedirectResponse
    {
        app(CreateAdminAction::class)->run($request->validated());

        return redirect()->route('admin-users.index')->with('message', [
            'message' => 'Запись успешно создана.',
            'type' => 'success'
        ]);
    }

    public function edit(int $id): Response
    {
        $admin = app(FindAdminByIdAction::class)->run($id);

        $roles = app(GetRolesAction::class)->run();
        $adminRoles = $admin->roles->where('id', '!=', 1)->pluck('id')->toArray();

        return Inertia::render('AdminUsers::Edit/Page', [
            'admin' => new AdminUserResource($admin),
            'roles' => RoleResource::collection($roles),
            'adminRoles' => $adminRoles
        ]);
    }

    public function update(UpdateAdminUserRequest $request, int $id): RedirectResponse
    {
        app(UpdateAdminAction::class)->run($request->validated(), $id);

        return redirect()->route('admin-users.index')->with('message', [
            'message' => 'Запись успешно обновлена.',
            'type' => 'success'
        ]);
    }

    public function destroy(int $id): RedirectResponse
    {
        app(DeleteAdminAction::class)->run($id);

        return redirect()->route('admin-users.index')->with('message', [
            'message' => 'Запись успешно удалена.',
            'type' => 'success'
        ]);
    }
}
