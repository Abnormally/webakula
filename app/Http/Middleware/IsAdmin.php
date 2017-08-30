<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::user() && Auth::user()->role > 2)
            return $next($request);

        throw new NotFoundHttpException();
    }
}
