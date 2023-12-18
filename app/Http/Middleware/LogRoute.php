<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LogRoute
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        $log = [
            'TIME' => date("d-m-Y H:i"),
            'URI' => $request->getUri(),
            'METHOD' => $request->getMethod(),
            'REQUEST_BODY' => $request->all(),
            'RESPONSE' => $response->getContent(),
            'STATUS' => $response->status()
        ];

        Storage::disk('public')->prepend('logs/' . date("d-m-Y") . '.txt', json_encode($log));
        return $response;
    }
}
