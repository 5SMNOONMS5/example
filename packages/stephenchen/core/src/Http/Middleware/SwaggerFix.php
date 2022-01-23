<?php

namespace Stephenchen\Core\Http\Middleware;

use Closure;

class SwaggerFix
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (strpos($request->headers->get("Authorization"), "Bearer ") === FALSE) {
            $request->headers->set("Authorization", "Bearer " . $request->headers->get("Authorization"));
        }

        $response = $next($request);

        return $response;
    }
}
