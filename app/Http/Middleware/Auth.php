<?php

namespace Portphilio\Http\Middleware;

use Route;
use Closure;
use Sentinel;

class Auth
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($user = Sentinel::check()) {
            if (true /*$user->hasAccess(Route::currentRouteAction())*/) {
                session(['user' => $user]);
                view()->share('user', $user);
            } else {
                return view('errors.forbidden');
            }
        } else {
            return redirect()->guest('/login');
        }

        return $next($request);
    }
}
