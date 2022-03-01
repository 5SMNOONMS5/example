<?php

namespace Stephenchen\Core\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Stephenchen\Core\Traits\ResponseJsonTrait;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class AuthenticateJwtVerify extends BaseMiddleware
{
    use ResponseJsonTrait;

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof TokenInvalidException) {
                return $this->jsonFail(trans('core::global.unauthorized'), 401);
            }
            if ($e instanceof TokenExpiredException) {
                return $this->jsonFail(trans('core::global.unauthorized'), 401);
            }
            return $this->jsonFail($e->getMessage());
        }
        return $next($request);
    }
}
