<?php

namespace App\Http\Middleware;

use App\Http\Resources\AuthUserResource;
use App\Http\Resources\CrumbResource;
use App\Http\Resources\MenuResource;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Menu;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'app';

    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'appName' => config('app.name'),
            'authUser' => auth()->check() ? new AuthUserResource(auth()->user()) : null,
            'navigation' => [
                'fullUrl' => url()->full(),
                'currentUrl' => url()->current(),
                'previousUrl' => url()->previous()
            ],
            'flash' => [
                'message' => fn () => $request->session()->get('message')
            ],
            'menu' => fn() => MenuResource::collection(Menu::get('menu')?->roots() ?? []),
            'crumbs' => fn() => CrumbResource::collection(Menu::get('menu')?->crumbMenu()->all() ?? []),
        ]);
    }
}
