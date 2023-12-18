<?php

namespace Modules\Standards\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use Inertia\Response;
use Modules\Standards\Actions\CreateStandardAction;
use Modules\Standards\Actions\DeleteStandardAction;
use Modules\Standards\Actions\GetStandardsAction;
use Modules\Standards\Actions\UpdateStandardAction;
use Modules\Standards\Http\Requests\CreateStandardRequest;
use Modules\Standards\Http\Requests\UpdateStandardRequest;
use Modules\Standards\Transformers\StandardResource;

class StandardController extends Controller
{
    public function index(): Response
    {
        $standards = app(GetStandardsAction::class)->run();

        return Inertia::render('Standards::Index/Page', [
            'standards' => StandardResource::collection($standards)
        ]);
    }

    public function store(CreateStandardRequest $request): RedirectResponse
    {
        app(CreateStandardAction::class)->run($request->validated());

        return redirect()->route('standards.index')->with('message', [
            'message' => 'Запись успешно созана.',
            'type' => 'success'
        ]);
    }

    public function update(UpdateStandardRequest $request, int $id): RedirectResponse
    {
        app(UpdateStandardAction::class)->run($request->validated(), $id);

        return redirect()->route('standards.index')->with('message', [
            'message' => 'Запись успешно обновлена.',
            'type' => 'success'
        ]);
    }

    public function destroy(int $id): RedirectResponse
    {
        app(DeleteStandardAction::class)->run($id);

        return redirect()->route('standards.index')->with('message', [
            'message' => 'Запись успешно удалена.',
            'type' => 'success'
        ]);
    }
}
