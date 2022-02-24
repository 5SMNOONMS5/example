<?php

namespace Stephenchen\Core\Http\Backend\Auth;

use Exception;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

final class AuthService
{
    /**
     * @param        $people
     * @param string $guard
     * @return mixed
     * @throws Exception
     */
    public function authenticate($people, string $guard)
    {
        if (!$token = Auth::guard($guard)->login($people)) {
            return NULL;
        }

        return $this->transformJWTToken($token);
    }

    /**
     * Transform
     *
     * @param string $token
     * @return array
     * @throws Exception
     */
    private function transformJWTToken(string $token): array
    {
        $authorization      = new JwtObject($token);
        $expiredAtTimestamp = $authorization->getExpiredAt();
        $date               = Carbon::createFromTimestamp($expiredAtTimestamp)->toDateTimeString();;

        return [
            'token'                => $authorization->getToken(),
            'expired_at'           => $date,
            'expired_at_timestmap' => $expiredAtTimestamp,
            'token_type'           => 'Bearer',
//            'refresh_expired_at'   => $authorization->getRefreshExpiredAt(),
        ];
    }

    /**
     * Attempt to authenticate a user using the given credentials.
     *
     * @param array $credentials
     * @return mixed
     * @throws Exception
     */
    public function attempt(array $credentials)
    {
        if (!$result = Auth::attempt($credentials)) {
            return NULL;
        }

        return $this->transformJWTToken($result);
    }

    /**
     * Set auth user while user success login by socialite ways
     *
     * @param $guard
     * @param $user
     * @return mixed
     * @throws Exception
     */
    public function loginBy($guard, $user)
    {
        $auth = Auth::guard($guard);

        if (!$result = $auth->login($user)) {
            return NULL;
        }

        return $this->transformJWTToken($result);
    }

    /**
     * Refresh
     *
     * @param string $guard
     * @return array|null
     * @throws Exception
     */
    public function refresh(string $guard): ?array
    {
        if ($token = Auth::guard($guard)->refresh(TRUE, TRUE)) {
            return $this->transformJWTToken($token);
        }

        return NULL;
    }

    /**
     * Get Auth user|admin
     *
     * @return Authenticatable
     */
    public function getAuthUser()
    {
        return Auth::user();
    }

    /**
     * Logout user
     *
     * @param string $guard
     * @return bool|null
     * @throws Exception
     */
    public function logout(string $guard): bool
    {
        Auth::guard($guard)->logout();
        return TRUE;
    }
}
