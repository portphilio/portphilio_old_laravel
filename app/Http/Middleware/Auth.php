<?php

namespace Portphilio\Http\Middleware;

use Closure;

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
            if ($user->hasAccess(Route::currentRouteAction())) {
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
