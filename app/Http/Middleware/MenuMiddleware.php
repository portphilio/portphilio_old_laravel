<?php

namespace Portphilio\Http\Middleware;

use Menu;
use Closure;

class MenuMiddleware
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
        Menu::make('main', function ($menu) {
            $menu->add('Dashboard', 'dashboard')->data('icon', 'tachometer');
        });

        return $next($request);
    }
}
