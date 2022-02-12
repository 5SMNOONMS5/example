<?php

namespace Stephenchen\Core\Tests;

use Illuminate\Support\Str;
use Tests\TestCase;

class PermissionControllerTest extends TestCase
{
    use FakeUserTrait;

//    TIP: Mark for temp
//    protected string $router = 'api/core/admins/permissions';
    protected string $router = 'admins/permissions';

    protected array $parameters;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->parameters = [
            'name' => Str::random(),
        ];

        $this->actingAsSuperAdmin();
    }

    /**
     * Test get lists
     */
    public function test_permissions_get_all()
    {
        $response = $this->get($this->router);

//        $response->dd();
//        $json = $response->json();
//        dd($json);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'code',
                'msg',
                'data' => [
                    '*' => [
                        'id',
                        'parent_id',
                        'name',
                        'path',
                        'icon',
                        'children' => [
                            '*' => [
                                'id',
                                'parent_id',
                                'name',
                                'path',
                                'icon',
                            ],
                        ],
                    ],
                ],
            ]);
    }

//    /**
//     * Test create
//     */
//    public function test_permissions_create()
//    {
//        $response = $this->post($this->router, $this->parameters);
//
//        $response
//            ->assertStatus(200);
//    }
//
//    /**
//     * Test get by id
//     */
//    public function test_permissions_get_by_id()
//    {
//        $response = $this->get("{$this->router}/{$this->getID()}");
//
//        $response->assertStatus(200)
//            ->assertJsonStructure(
//                $this->getJsonStructureForSingle()
//            );
//    }
//
//    /**
//     * Test update by id
//     */
//    public function test_permissions_update()
//    {
//        $response = $this->put("{$this->router}/{$this->getID()}", [
//            'name' => Str::random(),
//        ]);
//        $response->assertStatus(200);
//    }
//
//    /**
//     * Test delete
//     */
//    public function test_permissions_delete()
//    {
//        $this->delete("{$this->router}/{$this->getID()}")
//            ->assertStatus(200);
//    }
//
//    /**
//     * Current data id for this test
//     */
//    private function getID()
//    {
//        return (int)PermissionModel::select('id')->orderBy('id', 'desc')->firstOrFail()->id;
//    }
//
//    /**
//     * Current assert json structure
//     */
//    public function getJsonStructureForSingle()
//    {
//        return [
//            'code',
//            'msg',
//            'data' => [
//                'id',
//                'name',
//                'guard_name',
//                'created_at',
//                'updated_at',
//            ],
//        ];
//    }
}
