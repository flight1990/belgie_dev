<?php

namespace Modules\ConnectionTypes\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use Inertia\Response;
use Modules\ConnectionTypes\Actions\CreateConnectionTypeAction;
use Modules\ConnectionTypes\Actions\DeleteConnectionTypeAction;
use Modules\ConnectionTypes\Actions\GetConncetionTypesAction;
use Modules\ConnectionTypes\Actions\UpdateConnectionTypeAction;
use Modules\ConnectionTypes\Transformers\ConnectionTypeResource;
use Modules\ConnectionTypes\Http\Requests\CreateConnectionTypeRequest;
use Modules\ConnectionTypes\Http\Requests\UpdateConnectionTypeRequest;

class ConnectionTypeController extends Controller
{

    public function index(): Response
    {
        $connectionTypes = app(GetConncetionTypesAction::class)->run();

        return Inertia::render('ConnectionTypes::Index/Page', [
            'connectionTypes' => ConnectionTypeResource::collection($connectionTypes)
        ]);
    }

    public function store(CreateConnectionTypeRequest $request): RedirectResponse
    {
        app(CreateConnectionTypeAction::class)->run($request->validated());

        return redirect()->route('connection-types.index')->with('message', [
            'message' => 'Запись успешно создана.',
            'type' => 'success'
        ]);
    }

    public function update(UpdateConnectionTypeRequest $request, int $id): RedirectResponse
    {
        app(UpdateConnectionTypeAction::class)->run($request->validated(), $id);

        return redirect()->route('connection-types.index')->with('message', [
            'message' => 'Запись успешно обновлена.',
            'type' => 'success'
        ]);
    }

    public function destroy(int $id): RedirectResponse
    {
        app(DeleteConnectionTypeAction::class)->run($id);

        return redirect()->route('connection-types.index')->with('message', [
            'message' => 'Запись успешно удалена.',
            'type' => 'success'
        ]);
    }
}
