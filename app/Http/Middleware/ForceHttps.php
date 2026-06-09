<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ForceHttps
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->header('x-forwarded-proto') === 'https' || env('FORCE_HTTPS')) {
            $request->server->set('HTTPS', 'on');
            \URL::forceScheme('https');
        }
        return $next($request);
    }
}
