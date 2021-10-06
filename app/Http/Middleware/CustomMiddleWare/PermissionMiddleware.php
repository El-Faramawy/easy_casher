<?php

namespace App\Http\Middleware\CustomMiddleWare;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Closure;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$permission, $guard)
    {
        if (!admin()->check()){
            return redirect()->route('admin.login');
        }

        if (checkAdminHavePermission($permission))
        {
            return $next($request);
        }else{
            toastr()->error('لا تمتلك صلاحية الدخول');
            return redirect()->route('admin.dashboard');
        }

    }
}
