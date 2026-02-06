<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
<<<<<<< HEAD
        if (!Auth::check() || !Auth::user()->is_admin) {
            return redirect()->route('login')->with('error', 'Silakan login sebagai admin.');
=======
        if (!Auth::check()) {
            return redirect()->route('login');
>>>>>>> 106af9c438f0a80ed8e942447f859b9b5880bdbf
        }

        if (!Auth::user()->is_admin) {
            abort(403, 'Unauthorized access.');
        }

        return $next($request);
    }
}
