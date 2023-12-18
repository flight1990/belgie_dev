<?php

namespace Modules\Users\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use Inertia\Response;
use Modules\Users\Actions\CreateUserAction;
use Modules\Users\Actions\DeleteUserAction;
use Modules\Users\Actions\GetUsersAction;
use Modules\Users\Actions\UpdateUserAction;
use Modules\Users\Http\Requests\CreateUserRequest;
use Modules\Users\Http\Requests\UpdateUserRequest;
use Modules\Users\Transformers\UserResource;

class UsersController extends Controller
{
    public function index(Request $request): Response
    {
        return Inertia::render('Users::Index/Page', [
            'users' => Inertia::lazy(
                fn() => UserResource::collection(
                    app(GetUsersAction::class)->run($request->all())
                )
            ),
        ]);
    }

    public function store(CreateUserRequest $request): RedirectResponse
    {
        app(CreateUserAction::class)->run($request->validated());

        return redirect()->route('users.index')->with('message', [
            'message' => 'Запись успешно создана.',
            'type' => 'success'
        ]);
    }

    public function update(UpdateUserRequest $request, int $id): RedirectResponse
    {
        app(UpdateUserAction::class)->run($request->validated(), $id);

        return redirect()->route('users.index')->with('message', [
            'message' => 'Запись успешно обновлена.',
            'type' => 'success'
        ]);
    }

    public function destroy(int $id): RedirectResponse
    {
        app(DeleteUserAction::class)->run($id);

        return redirect()->route('users.index')->with('message', [
            'message' => 'Запись успешно удалена.',
            'type' => 'success'
        ]);
    }
}
