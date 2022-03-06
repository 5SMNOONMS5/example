<?php

namespace Stephenchen\Memb\Http\Backend\Auth;

use Exception;
use Stephenchen\Admin\Http\Backend\Admin\UserService;
use Stephenchen\Core\Service\Auth\AuthenticationService;

final class AuthService
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    const GUARD_ADMIN = 'admins';

    /**
     * @var AuthenticationService
     */
    private AuthenticationService $authService;

    /**
     * @var UserService
     */
    private UserService $adminService;

    /**
     * Create a new Service instance.
     *
     * @param UserService $adminService
     * @param AuthenticationService $authService
     */
    public function __construct(UserService $adminService,
                                AuthenticationService $authService)
    {
        $this->authService  = $authService;
        $this->adminService = $adminService;
    }

    /**
     * Attempt to authenticate a user using the given credentials.
     *
     * @param array $credentials
     * @return mixed
     * @throws Exception
     */
    public function attempt(array $credentials): ?array
    {
        $primary = $credentials[ 'primary' ];
        $field   = filter_var($primary, FILTER_VALIDATE_EMAIL) ? 'email' : 'account';

        $attempts[ $field ]     = $primary;
        $attempts[ 'password' ] = $credentials[ 'password' ];

        if ($token = $this->authService->attempt($attempts)) {

            // Update user `latest_login_at` and `latest_ip`....etc
            $admin = $this->authService->getAuthUser();
            $this->adminService->updateLoginStatus($admin);

            return array_merge($token, $this->me());
        }
        return NULL;
    }

    /**
     * Get auth admin info and permissions
     */
    public function me()
    {
        $admin = $this->authService->getAuthUser();
        return $this->adminService->me($admin);
    }

    /**
     * Refresh token
     *
     * @throws Exception
     */
    public function refresh(): ?array
    {
        return $this->authService->refresh(self::GUARD_ADMIN);
    }

    /**
     * Log the user out (Invalidate the token)
     *
     * @throws Exception
     */
    public function logout(): bool
    {
        return $this->authService->logout(self::GUARD_ADMIN);
    }
}
