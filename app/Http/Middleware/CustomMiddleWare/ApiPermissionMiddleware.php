<?php

namespace App\Http\Middleware\CustomMiddleWare;

use Closure;

class ApiPermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next , $permission )
    {
        if (checkApiUserHavePermission($request->user() , $permission))
        {
            return $next($request);
        }else{
           return response(['message' =>'لا تمتلك صلاحية الدخول'],409);
        }
    }
}
