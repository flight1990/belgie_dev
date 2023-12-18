<?php

namespace Modules\Maps\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use Inertia\Response;

class TestsMapController extends Controller
{
    public function index(Request $request): Response
    {
        return Inertia::render('Maps::Tests/Index/Page');
    }
}
