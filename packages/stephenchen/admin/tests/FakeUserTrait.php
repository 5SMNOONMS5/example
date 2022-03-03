<?php

namespace Stephenchen\Admin\Tests;

use Stephenchen\Admin\Http\Backend\Admin\AdminModel;
use Tymon\JWTAuth\Facades\JWTAuth;

trait FakeUserTrait
{
    private $token;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function actingAsSuperAdmin()
    {
        $user = new AdminModel([
            'id'           => 1,
            'account'      => 'admin',
            'email'        => 'admin@gmail.com',
            'password'     => 'aaa111222',
            'display_name' => 'admin',
        ]);
        $this->actingAs($user);
    }

    public function actingAs($user, $guard = NULL)
    {
        $this->token = JWTAuth::fromUser($user);
        $this->withHeader('Accept', 'application/json');
        $this->withHeader('Authorization', "Bearer {$this->token}");
        parent::actingAs($user);
    }
}
