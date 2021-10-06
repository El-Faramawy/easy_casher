<?php

namespace App\Http\Middleware\Website;

use Closure;
use Illuminate\Support\Facades\Auth;

class AuthSystemMiddleware
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
        if (!Auth::check()){
            return redirect()->route('login');
        }

        if (Auth::check() && Auth::user()->is_confirmed == 'no'){
            return redirect()->route('emailConfirmationView');
        }

        if (Auth::check() && Auth::user()->has_haqawat_subscribe == 'no'){
            return redirect()->route('haqawatRegisterView');
        }

        return $next($request);
    }
}
