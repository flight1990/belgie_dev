<?php

namespace Modules\Operators\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use Inertia\Response;
use Modules\Operators\Actions\CreateOperatorAction;
use Modules\Operators\Actions\DeleteOperatorAction;
use Modules\Operators\Actions\GetOperatorsAction;
use Modules\Operators\Actions\UpdateOperatorAction;
use Modules\Operators\Http\Requests\CreateOperatorRequest;
use Modules\Operators\Http\Requests\UpdateOperatorRequest;
use Modules\Operators\Transformers\OperatorResource;

class OperatorController extends Controller
{
    public function index(): Response
    {
        $operators = app(GetOperatorsAction::class)->run();

        return Inertia::render('Operators::Index/Page', [
            'operators' => OperatorResource::collection($operators)
        ]);
    }

    public function store(CreateOperatorRequest $request): RedirectResponse
    {
        app(CreateOperatorAction::class)->run($request->validated());

        return redirect()->route('operators.index')->with('message', [
            'message' => 'Запись успешно создана.',
            'type' => 'success'
        ]);
    }

    public function update(UpdateOperatorRequest $request, int $id): RedirectResponse
    {
        app(UpdateOperatorAction::class)->run($request->validated(), $id);

        return redirect()->route('operators.index')->with('message', [
            'message' => 'Запись успешно обновлена.',
            'type' => 'success'
        ]);
    }

    public function destroy(int $id): RedirectResponse
    {
        app(DeleteOperatorAction::class)->run($id);

        return redirect()->route('operators.index')->with('message', [
            'message' => 'Запись успешно удалена.',
            'type' => 'success'
        ]);
    }
}
