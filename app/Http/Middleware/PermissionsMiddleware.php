<?php

namespace App\Http\Middleware;

use App\Classes\Parsers\PermissionUrlParser;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;

class PermissionsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     *
     * @return mixed
     */
    public function handle( Request $request, Closure $next)
    {
        $name = Route::currentRouteName();

        $parser = new PermissionUrlParser($name);
        $ability = $parser->run();

        if (Gate::denies($ability))
            abort(403, 'Access Denied');

        return $next($request);
    }
}
