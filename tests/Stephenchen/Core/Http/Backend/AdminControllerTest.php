<?php

namespace Tests\Stephenchen\Core\Http\Backend;

use Illuminate\Support\Str;
use Stephenchen\Core\Http\Backend\Admin\AdminModel;
use Stephenchen\Core\Http\Backend\Role\RoleModel;
use Tests\TestCase;

class AdminControllerTest extends TestCase
{
    protected string $router = 'api/core/admins';

    protected array $parameters;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();



        $random           = Str::uuid();
        $random           = Str::substr($random, 0, 10);
        $this->parameters = [
            'account'      => $random,
            'email'        => "{$random}@gmail.com",
            'password'     => 'a111111',
            'display_name' => $random,
            'status'       => 1,
            'role_id'      => ( new RoleModel )->first()->id,
        ];
    }

    /**
     * Test get lists
     */
    public function test_admins_get_all()
    {
        $response = $this->get($this->router);

        $response
            ->assertStatus(200)
            ->assertJsonStructure(
                $this->getJsonStructureForAssert()
            );
    }

    /**
     * Test create
     */
    public function test_admins_create()
    {
        $response = $this->post($this->router, $this->parameters);
        $response
            ->assertStatus(200);
    }

    /**
     * Test get by id
     */
    public function test_admins_get_by_id()
    {
        $response = $this->get("{$this->router}/{$this->getID()}");

        $response->assertStatus(200)
            ->assertJsonStructure(
                $this->getJsonStructureForSingle()
            );
    }

    /**
     * Test update by id
     */
    public function test_admins_update()
    {
        $newParameters                   = $this->parameters;
        $newParameters[ 'display_name' ] = 'nwqewqe';
        $response                        = $this->put("{$this->router}/{$this->getID()}", $newParameters);
        $response->assertStatus(200);
    }

    /**
     * Test delete
     */
    public function test_admins_delete()
    {
        $this->delete("{$this->router}/{$this->getID()}")
            ->assertStatus(200);
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
