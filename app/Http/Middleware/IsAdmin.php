<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class IsAdmin
{
    /**
     * Handle an incoming request and throw exception if user role is not proper.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     * @throws \Exception
     */
    public function handle($request, Closure $next)
    {
        if (Auth::user() && Auth::user()->role > 2)
            return $next($request);

        abort(418, "I'm a teapot");
    }
}
