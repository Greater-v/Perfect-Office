<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is an admin here
        // For example, using Laravel Auth:
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized Access');
        }

        return $next($request);
    }
}
