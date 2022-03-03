<?php

namespace Stephenchen\Admin\Http\Backend\Admin\Auth;

use Exception;
use Stephenchen\Admin\Http\Backend\Admin\AdminService;
use Stephenchen\Admin\Http\Backend\Auth\AuthService as BaseAuthService;

final class AuthService
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    const GUARD_ADMIN = 'admins';

    /**
     * @var BaseAuthService
     */
    private BaseAuthService $authService;

    /**
     * @var AdminService
     */
    private AdminService $adminService;

    /**
     * Create a new Service instance.
     *
     * @param AdminService $adminService
     * @param BaseAuthService $authService
     */
    public function __construct(AdminService $adminService,
                                BaseAuthService $authService)
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
//        dd($admin, 'ss ');
        return $this->adminService->me($admin);
    }

    /**
     * Regresh token
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
