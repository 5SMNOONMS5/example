<?php

namespace Tests\Stephenchen\Core\Http\Backend;

use Stephenchen\Core\Http\Backend\Admin\AdminModel;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    protected string $router = 'api/core/admins';

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
     * Test get lists
     */
    public function test_admins_login()
    {
        $parameters = [
            'email'    => 'admin@gmail.com',
            'password' => 'adminpassword',
        ];

        $response = $this->post("{$this->router}/login", $parameters);

        $response
            ->assertStatus(200)
            ->assertJsonStructure(
                $this->getJsonStructureForAssert()
            );

    }

    public function test_admins_login2()
    {
        dd('test');
    }

    /**
     * Current data id for this test
     */
    private function getID()
    {
        return AdminModel::select('id')->orderBy('id', 'desc')->firstOrFail()->id;
    }

    /**
     * Current assert json structure
     */
    public function getJsonStructureForAssert()
    {
        return [
            'code',
            'msg',
            'data' => [
                '*' => [
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

    /**
     * Current assert json structure
     */
    public function getJsonStructureForSingle()
    {
        return [
            'code',
            'msg',
            'data' => [
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
        ];
    }
}
