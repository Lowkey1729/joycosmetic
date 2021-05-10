<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {

                    $role = Auth::user()->is_admin;

                    switch ($role) {
                      case '1':
                         return redirect('/admin');
                         break;
                      case '0':
                         return redirect('/shop');
                         break;

                      default:
                         return redirect('/');
                         break;
                    }


                return redirect('/shop');
            }
        }

        return $next($request);
    }
}
