<?php

namespace Stephenchen\Admin\Tests;

use Illuminate\Support\Arr;
use Stephenchen\Admin\Http\Backend\Admin\AdminModel;
use Stephenchen\Admin\Http\Backend\Role\RoleModel;
use Tests\TestCase;

class AdminControllerTest extends TestCase
{
    use FakeUserTrait;

    protected string $router = 'admins/authUser';

    protected array $parameters;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $random           = time();
        $this->parameters = [
            'account'               => "ab{$random}",
            'email'                 => "{$random}@gmail.com",
            'password'              => 'a111111',
            'password_confirmation' => 'a111111',
            'display_name'          => $random,
            'status'                => 1,
            'role_id'               => ( new RoleModel )->first()->id,
        ];

        $this->actingAsSuperAdmin();
    }

    /**
     * Test get lists
     */
    public function test_admins_get_all()
    {
        // Assert
        $perPage    = 2;
        $parameters = [
            'page'     => 2,
            'per_page' => $perPage,
        ];
        $query      = Arr::query($parameters);
        $response   = $this->get("$this->router?{$query}", [
            'Accept', 'application/json',
        ]);

//        dd($response);

        // Act
        $json = $response->json();
        $data = $json[ 'data' ][ 'lists' ];

        // Assert
        $this->assertSame($perPage, count($data));
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'code',
                'msg',
                'data' => [
                    'lists' => [
                        [
                            'id',
                            'role_name',
                            'account',
                            'display_name',
                            'email',
                            'status',
                            'latest_ip',
                            'latest_login_at',
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
    public function test_admins_create()
    {
        $headers  = [
            'Accept', 'application/json',
        ];
        $response = $this->post($this->router, $this->parameters, $headers);

//        $response->dd();

        $response
            ->assertStatus(200);
    }

    /**
     * Test create without key
     */
    public function test_admins_create_without_key_account()
    {
        $headers = [
            'Accept', 'application/json',
        ];

        $new = $this->parameters;
        unset($new[ 'account' ]);
        $response = $this->post($this->router, $new, $headers);

        $response
            ->assertStatus(422);
    }

    /**
     * Test create without key
     */
    public function test_admins_create_without_key_email()
    {
        $headers = [
            'Accept', 'application/json',
        ];

        $new = $this->parameters;
        unset($new[ 'email' ]);
        $response = $this->post($this->router, $new, $headers);

        $response
            ->assertStatus(422);
    }

    /**
     * Test get by id
     */
    public function test_admins_get_by_id()
    {
        $response = $this
            ->get("{$this->router}/{$this->getID()}");

//        $response->dd();

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
        $newParameters[ 'role_id' ]      = 2;
        $newParameters[ 'display_name' ] = 'new';
        $response                        = $this->put("{$this->router}/{$this->getID()}", $newParameters);

//        $response->dd();

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
                    'id',
                    'account',
                    'display_name',
                    'email',
                    'status',
                    'latest_ip',
                    'latest_login_at',
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
                'account',
                'display_name',
                'email',
                'status',
                'latest_ip',
                'latest_login_at',
                'created_at',
                'updated_at',
            ],
        ];
    }
}
