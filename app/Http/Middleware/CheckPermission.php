<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{

    public function handle(Request $request, Closure $next, $permissions)
    {

        if (!Auth::check() || !$request->user()->hasAnyPermission($permissions)) {
            abort(403, 'User Does Not Have The Right Permission.');
        }

        return $next($request);
    }
}
