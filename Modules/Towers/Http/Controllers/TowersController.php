<?php

namespace Modules\Towers\Http\Controllers;

use App\Imports\TowersImport;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use Inertia\Response;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Operators\Actions\GetOperatorsAction;
use Modules\Operators\Transformers\OperatorResource;
use Modules\Standards\Actions\GetStandardsAction;
use Modules\Standards\Transformers\StandardResource;
use Modules\Towers\Actions\CreateTowerAction;
use Modules\Towers\Actions\DeleteTowerAction;
use Modules\Towers\Actions\UpdateTowerAction;
use Modules\Towers\Actions\TruncateTowersAction;
use Modules\Towers\Http\Requests\ImportTowerRequest;
use Modules\Towers\Http\Requests\ModifyTowerRequest;
use Modules\Towers\Transformers\TowerResource;
use Modules\Towers\Actions\GetTowersAction;

class TowersController extends Controller
{
    public function index(Request $request): Response
    {
        $standards = app(GetStandardsAction::class)->run();
        $operators = app(GetOperatorsAction::class)->run();

        return Inertia::render('Towers::Index/Page', [
            'standards' => StandardResource::collection($standards),
            'operators' => OperatorResource::collection($operators),
            'towers' => Inertia::lazy(fn() => TowerResource::collection(
                app(GetTowersAction::class)->run($request->all())
            ))
        ]);
    }

    public function import(ImportTowerRequest $request): RedirectResponse
    {
        if ($request->get('truncate')) {
            app(TruncateTowersAction::class)->run();
        }

        Excel::import(new TowersImport(), $request->file('file'));

        return redirect()->route('towers.index')->with('message', [
            'message' => 'Производится импорт данных.',
            'type' => 'success'
        ]);
    }

    public function store(ModifyTowerRequest $request): RedirectResponse
    {

        app(CreateTowerAction::class)->run($request->validated());

        return redirect()->route('towers.index')->with('message', [
            'message' => 'Запись успешно создана.',
            'type' => 'success'
        ]);
    }

    public function update(ModifyTowerRequest $request, int $id): RedirectResponse
    {
        app(UpdateTowerAction::class)->run($request->validated(), $id);

        return redirect()->route('towers.index')->with('message', [
            'message' => 'Запись успешно обновлена.',
            'type' => 'success'
        ]);
    }

    public function destroy(int $id): RedirectResponse
    {
        app(DeleteTowerAction::class)->run($id);

        return redirect()->route('towers.index')->with('message', [
            'message' => 'Запись успешно удалена.',
            'type' => 'success'
        ]);
    }
}
