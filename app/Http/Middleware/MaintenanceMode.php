<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaintenanceMode
{
    public function handle(Request $request, Closure $next)
    {
        $enabled = filter_var(env('APP_MAINTENANCE', false), FILTER_VALIDATE_BOOLEAN);

        if (!$enabled) {
            return $next($request);
        }

        if (Auth::check() && Auth::user()->is_admin) {
            return $next($request);
        }

        $secret = env('MAINTENANCE_SECRET');

        if ($secret && $request->query('secret') === $secret) {
            return $next($request);
        }

        return response()->view('maintenance', [], 503);
    }
}

