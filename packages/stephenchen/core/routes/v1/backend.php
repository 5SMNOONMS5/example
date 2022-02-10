<?php

use Illuminate\Support\Facades\Route;

Route::group([
    // @TODO:
//    'prefix'    => 'api/core',
    'namespace' => 'Stephenchen\Core\Http\Backend',
], function () {

    /*
    |--------------------------------------------------------------------------
    | Admin Auth
    |--------------------------------------------------------------------------
    */

    Route::group([
        'namespace' => 'Admin\Auth',
        'prefix'    => 'admins',
    ], function () {
        Route::post('login', 'AuthController@login');

        Route::group([
            'middleware' => [
                'auth.assign.guard:admins',
                'auth.jwt.verify',
            ],
        ], function () {
            Route::get('me', 'AuthController@me');
            Route::get('refresh', 'AuthController@refresh');
            Route::get('logout', 'AuthController@logout');
        });
    });

    /*
    |--------------------------------------------------------------------------
    | 後台 admins, role, permissions 相關的
    | middleware 要 透過 jwt 驗證
    |--------------------------------------------------------------------------
    */

    Route::group([
        'middleware' => [
            'auth.assign.guard:admins',
            'auth.jwt.verify',
        ],
    ], function () {

        /*
        |--------------------------------------------------------------------------
        | 後台使用者
        |--------------------------------------------------------------------------
        */

        Route::group([
            'namespace' => 'Admin',
        ], function () {
            Route::resource('admins/authUser', 'AdminController');
        });

        /*
        |--------------------------------------------------------------------------
        | 權限
        |--------------------------------------------------------------------------
        */
        Route::group([
            'prefix'    => 'admins',
            'namespace' => 'Permission',
        ], function () {
            Route::resource('permissions', 'PermissionController');
        });

        /*
        |--------------------------------------------------------------------------
        | 權限群組(角色)
        |--------------------------------------------------------------------------
        */
        Route::group([
            'prefix'    => 'admins',
            'namespace' => 'Role',
        ], function () {
            Route::resource('roles', 'RoleController');
        });
    });
});
