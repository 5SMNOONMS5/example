<?php

namespace Stephenchen\Admin\Tests;

use Tests\TestCase;

/**
 * Class AuthControllerTest
 *
 * @package Stephenchen\Core\Tests
 */
class AuthControllerTest extends TestCase
{
    use FakeUserTrait;

    protected string $router = 'admins';

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Login using account
     */
    public function test_admins_login_by_account()
    {
        $parameters = [
            'primary'  => 'admin',
            'password' => '123456',
        ];

        $response = $this->post("{$this->router}/login", $parameters);

//        $response->dd();

        $response
            ->assertStatus(200)
            ->assertJsonStructure(
                $this->getJsonStructureForSingle()
            );
    }

    /**
     * Login using email
     */
    public function test_admins_login_by_email()
    {
        $parameters = [
            'primary'  => 'admin@gmail.com',
            'password' => '123456',
        ];

        $response = $this->post("{$this->router}/login", $parameters);

//        $response->dd();

        $response
            ->assertStatus(200)
            ->assertJsonStructure(
                $this->getJsonStructureForSingle()
            );
    }

    /**
     * Login using email
     */
    public function test_admins_me()
    {
        $this->actingAsSuperAdmin();

        $response = $this->get("{$this->router}/me");

//        $response->dd();

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                    'code',
                    'msg',
                    'data' => [
                        'admin_infos' => [
                            "id",
                            "account",
                            "display_name",
                            "email",
                            "status",
                            "latest_ip",
                            "latest_login_at",
                            "created_at",
                            "updated_at",
                        ],
                        'permissions'
                    ],
                ]
            );
    }

    /**
     * Current assert json structure
     */
    public function getJsonStructureForSingle()
    {
        return [
            'code',
            'msg',
            'data' => [
                "expired_at",
//                "expired_at_timestamp",
                "token_type",
//                "refresh_expired_at",
                'admin_infos' => [
                    "id",
                    "account",
                    "display_name",
                    "email",
                    "status",
                    "latest_ip",
                    "latest_login_at",
                    "created_at",
                    "updated_at",
                ],
            ],
        ];
    }
}
