<?php

namespace App\Http\Middleware;

use Closure;

class CheckRol
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$role)
    {
       if(! auth()->user()->hasRoles($role)){
           abort(403);
        }

        return $next($request);
    }
}
