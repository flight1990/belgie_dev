<?php

namespace Modules\WebResources\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use Inertia\Response;
use Modules\WebResources\Actions\CreateWebResourceAction;
use Modules\WebResources\Actions\DeleteWebResourceAction;
use Modules\WebResources\Actions\FindWebResourceByIdAction;
use Modules\WebResources\Actions\GetWebResourcesAction;
use Modules\WebResources\Actions\UpdateWebResourceAction;
use Modules\WebResources\Http\Requests\CreateWebResourceRequest;
use Modules\WebResources\Http\Requests\UpdateWebResourceRequest;
use Modules\WebResources\Transformers\WebResource;

class WebResourceController extends Controller
{
    public function index(): Response
    {
        $webResources = app(GetWebResourcesAction::class)->run();

        return Inertia::render('WebResources::Index/Page', [
            'webResources' => WebResource::collection($webResources)
        ]);
    }

    public function store(CreateWebResourceRequest $request): RedirectResponse
    {
        app(CreateWebResourceAction::class)->run($request->validated());

        return redirect()->route('web-resources.index')->with('message', [
            'message' => 'Запись успешно создана.',
            'type' => 'success'
        ]);
    }

    public function update(UpdateWebResourceRequest $request, int $id): RedirectResponse
    {
        app(UpdateWebResourceAction::class)->run($request->validated(), $id);

        return redirect()->route('web-resources.index')->with('message', [
            'message' => 'Запись успешно обновлена.',
            'type' => 'success'
        ]);
    }

    public function destroy(int $id): RedirectResponse
    {
        app(DeleteWebResourceAction::class)->run($id);

        return redirect()->route('web-resources.index')->with('message', [
            'message' => 'Запись успешно удалена.',
            'type' => 'success'
        ]);
    }
}
