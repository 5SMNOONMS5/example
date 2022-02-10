<?php

namespace Stephenchen\Core\Tests;

use Illuminate\Support\Str;
use Stephenchen\Core\Http\Backend\Permission\PermissionModel;
use Stephenchen\Core\Http\Backend\Role\RoleModel;
use Tests\TestCase;

class RoleControllerTest extends TestCase
{
    use FakeUserTrait;

    protected string $router = 'admins/roles';

    protected array $parameters;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $all = PermissionModel::select('id')->get()->pluck('id')->toArray();

        $this->parameters = [
            'name'          => Str::random(),
            'description'   => Str::random(),
            'is_enabled'    => 1,
            'permissionIDs' => $all,
        ];

        $this->actingAsSuperAdmin();
    }

    /**
     * Test get lists
     */
    public function test_roles_get_all()
    {
        $response = $this->get($this->router);

//        $json = $response->json();
//        dd($json);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'code',
                'msg',
                'data' => [
                    'lists' => [
                        [
                            'id',
                            'name',
                            'guard_name',
                            'created_at',
                            'updated_at',
                        ],
                    ],
                    'total',
                ],
            ]);
    }

    /**
     * Test create
     */
    public function test_roles_create()
    {
        $response = $this->post($this->router, $this->parameters);

//        $response->dd();
//        dd($response);

        $response
            ->assertStatus(200);
    }

    /**
     * Test get by id
     */
    public function test_roles_get_by_id()
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
    public function test_roles_update()
    {
        $data     = [
            'name'          => Str::random(),
            'description'   => Str::random(),
            'is_enabled'    => 1,
            'permissionIDs' => [1],
        ];
        $response = $this->put("{$this->router}/{$this->getID()}", $data);

        $response->assertStatus(200);
    }

    /**
     * Test delete
     */
    public function test_roles_delete()
    {
        $this->delete("{$this->router}/{$this->getID()}")
            ->assertStatus(200);
    }

    /**
     * Current data id for this test
     */
    private function getID()
    {
        return RoleModel::select('id')->orderBy('id', 'desc')->firstOrFail()->id;
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
                    'id',
                    'name',
                    'guard_name',
                    'created_at',
                    'updated_at',
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
                'id',
                'name',
                'guard_name',
                'created_at',
                'updated_at',
            ],
        ];
    }
}
