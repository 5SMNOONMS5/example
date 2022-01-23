<?php

namespace Stephenchen\Core\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
                return self::jsonFail('token 無效，請重新登入', 401);
            }
            if ($e instanceof TokenExpiredException) {
                return self::jsonFail('token 過期，請重新登入', 401);
            }
            return self::jsonFail($e->getMessage());
        }
        return $next($request);
    }
}
