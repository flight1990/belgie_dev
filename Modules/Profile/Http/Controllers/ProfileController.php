<?php

namespace Modules\Profile\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use Inertia\Response;
use Modules\Profile\Actions\UpdateProfileAction;
use Modules\Profile\Http\Requests\UpdateProfileRequest;
use Modules\Users\Transformers\UserResource;

class ProfileController extends Controller
{
    public function edit(): Response
    {
        $user = auth()->user();

        return Inertia::render('Profile::Page', [
            'user' => new UserResource($user),
        ]);
    }

    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        app(UpdateProfileAction::class)->run($request->validated(), auth()->id());

        return redirect()->route('profile.edit')->with('message', [
            'message' => 'Информация профиля успешно обновлена.',
            'type' => 'success'
        ]);
    }
}
