<?php

namespace Stephenchen\Core\Http\Middleware;

use App\Service\Cache\CacheService;
use Closure;
use Illuminate\Http\Request;

/**
 * Class FlushCache
 *
 * @package App\Http\Middleware
 */
final class CacheFlush
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param null $tags
     * @return mixed
     */
    public function handle($request, Closure $next, $tags = NULL)
    {
        CacheService::flush($tags);
        return $next($request);
    }
}
