<?php

namespace Modules\Tests\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use Inertia\Response;
use Modules\ConnectionTypes\Actions\GetConncetionTypesAction;
use Modules\ConnectionTypes\Transformers\ConnectionTypeResource;
use Modules\Operators\Actions\GetOperatorsAction;
use Modules\Operators\Transformers\OperatorResource;
use Modules\Servers\Actions\GetServersAction;
use Modules\Servers\Transformers\ServerResource;
use Modules\Standards\Actions\GetStandardsAction;
use Modules\Standards\Transformers\StandardResource;
use Modules\Tests\Transformers\TestResource;
use Modules\Tests\Actions\GetTestsAction;

class TestsController extends Controller
{
    public function index(Request $request): Response
    {
        $operators = app(GetOperatorsAction::class)->run();
        $standards = app(GetStandardsAction::class)->run();
        $servers = app(GetServersAction::class)->run();
        $connectionTypes = app(GetConncetionTypesAction::class)->run();

        return Inertia::render('Tests::Index/Page', [
            'operators' => OperatorResource::collection($operators),
            'standards' => StandardResource::collection($standards),
            'servers' => ServerResource::collection($servers),
            'connectionTypes' => ConnectionTypeResource::collection($connectionTypes),
            'tests' => Inertia::lazy(fn() => TestResource::collection(
                app(GetTestsAction::class)->run($request->all())
            ))
        ]);
    }
}
