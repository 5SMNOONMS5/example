<?php

namespace Stephenchen\Core\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class AssignGuard
 *
 * @package App\Http\Middleware
 */
final class AuthenticateAssignGuard
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     *
     * @param null    $guard
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = NULL)
    {
        if (isset($guard) === TRUE && $guard === '') {
            abort(403);
        }

        Auth::shouldUse($guard);
        return $next($request);
    }
}
