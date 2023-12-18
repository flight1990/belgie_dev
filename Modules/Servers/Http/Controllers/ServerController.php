<?php

namespace Modules\Servers\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use Inertia\Response;
use Modules\Servers\Actions\CreateServerAction;
use Modules\Servers\Actions\DeleteServerAction;
use Modules\Servers\Actions\GetServersAction;
use Modules\Servers\Actions\UpdateServerAction;
use Modules\Servers\Http\Requests\CreateServerRequest;
use Modules\Servers\Http\Requests\UpdateServerRequest;
use Modules\Servers\Transformers\ServerResource;

class ServerController extends Controller
{
    public function index(): Response
    {
        $servers = app(GetServersAction::class)->run();

        return Inertia::render('Servers::Index/Page', [
            'servers' => ServerResource::collection($servers)
        ]);
    }

    public function store(CreateServerRequest $request): RedirectResponse
    {
        app(CreateServerAction::class)->run($request->validated());

        return redirect()->route('servers.index')->with('message', [
            'message' => 'Запись успешно создана.',
            'type' => 'success'
        ]);
    }

    public function update(UpdateServerRequest $request, int $id): RedirectResponse
    {
        app(UpdateServerAction::class)->run($request->validated(), $id);

        return redirect()->route('servers.index')->with('message', [
            'message' => 'Запись успешно обновлена.',
            'type' => 'success'
        ]);
    }

    public function destroy(int $id): RedirectResponse
    {
        app(DeleteServerAction::class)->run($id);

        return redirect()->route('servers.index')->with('message', [
            'message' => 'Запись успешно удалена.',
            'type' => 'success'
        ]);
    }
}
