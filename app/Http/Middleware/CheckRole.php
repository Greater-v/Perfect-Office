<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, $roles)
    {
        if (!Auth::check() || !$request->user()->hasAnyRole($roles)) {
            abort(403, 'User Does Not Have The Right Role.');
        }
        

        return $next($request);
    }
}
