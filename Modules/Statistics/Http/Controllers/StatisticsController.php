<?php

namespace Modules\Statistics\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use Inertia\Response;
use Modules\Operators\Actions\GetOperatorsAction;
use Modules\Operators\Transformers\OperatorResource;
use Modules\Statistics\Actions\GetStatisticsAction;

class StatisticsController extends Controller
{
    public function index(Request $request): Response
    {
        $operators = app(GetOperatorsAction::class)->run();

        return Inertia::render('Statistics::Index/Page', [
            'operators' => OperatorResource::collection($operators),
            'statistics' => Inertia::lazy(
                fn() => app(GetStatisticsAction::class)->run($request->all())
            ),
        ]);
    }
}
