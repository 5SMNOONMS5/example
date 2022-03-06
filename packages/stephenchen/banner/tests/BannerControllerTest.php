<?php

namespace Stephenchen\Banner\Tests;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Stephenchen\Banner\Http\Backend\Banner\BannerModel;
use Stephenchen\Admin\Tests\FakeUserTrait;
use Tests\TestCase;

class BannerControllerTest extends TestCase
{
    use FakeUserTrait;

    protected string $router = 'admins/homePgBanner';

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
            'title'  => Str::random(),
            'status' => 1,
            'path'   => "aaa/bbbb/ccc",
        ];

        $this->actingAsSuperAdmin();
    }

    /**
     * Test get lists
     */
    public function test_banners_get_all()
    {
        $response = $this->get($this->router);

        $all  = BannerModel::count();
        $json = $response->json();

//        dd($json);

        // Assert same count
        $lists = $json[ 'data' ][ 'lists' ];
        $this->assertSame($all, count($lists));

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'code',
                'msg',
                'data' => [
                    'lists' => [
                        [
                            'id',
                            'title',
                            'path',
                            'status',
                            'created_at',
                            'updated_at',
                        ],
                    ],
                    'total',
                ],
            ]);
    }

    /**
     * Test get lists
     */
    public function test_banners_get_all_with_page_and_perpage()
    {
        $perPage    = 5;
        $parameters = [
            'page'     => 1,
            'per_page' => $perPage,
        ];
        $query      = Arr::query($parameters);
        $response   = $this->get("$this->router?{$query}");

        $json = $response->json();
//        dd($json)

        // Assert same count
        $lists = $json[ 'data' ][ 'lists' ];
        $this->assertSame($perPage, count($lists));

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'code',
                'msg',
                'data' => [
                    'lists' => [
                        [
                            'id',
                            'title',
                            'path',
                            'status',
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
    public function test_banners_create()
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
    public function test_banners_get_by_id()
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
    public function test_banners_update()
    {
        $data     = [
            'title'  => Str::random(),
            'status' => 0,
            'path'   => "aaa/bbbb/ccc",
        ];
        $response = $this->put("{$this->router}/{$this->getID()}", $data);

//        $json = $response->json();
//        dd($json, $response);

        $response->assertStatus(200);
    }

    /**
     * Test delete
     */
    public function test_banners_delete()
    {
        $this->delete("{$this->router}/{$this->getID()}")
            ->assertStatus(200);
    }

    /**
     * Current data id for this test
     */
    private function getID()
    {
        return BannerModel::select('id')->orderBy('id', 'desc')->firstOrFail()->id;
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
                    'title',
                    'path',
                    'status',
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
                'title',
                'path',
                'status',
                'created_at',
                'updated_at',
            ],
        ];
    }
}
