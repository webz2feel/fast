<?php

namespace Fast\Member\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfMember
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  string|null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = 'member')
    {
        if (Auth::guard($guard)->check()) {
            return redirect(route('public.member.overview'));
        }

        return $next($request);
    }
}