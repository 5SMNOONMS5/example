<?php

namespace Stephenchen\Core\Tests;

use Illuminate\Support\Str;
use Tests\TestCase;

class PermissionControllerTest extends TestCase
{
    use FakeUserTrait;

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

    public function test_array_diffs()
    {
        // Arrange
        $sources     = [1, 2, 3, 4, 5, 6, 7];
        $challenger1 = [1];
        $challenger2 = [1, 2, 3];
        $challenger3 = [0];
        $challenger4 = [1, 2, 4, 8];

        // Act
        $result1 = array_diff($challenger1, $sources);
        $result2 = array_diff($challenger2, $sources);
        $result3 = array_diff($challenger3, $sources);
        $result4 = array_diff($challenger4, $sources);

        // Assert
        $this->assertSame([], array_values($result1));
        $this->assertSame([], array_values($result2));
        $this->assertSame([0], array_values($result3));
        $this->assertSame([8], array_values($result4));
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
}
