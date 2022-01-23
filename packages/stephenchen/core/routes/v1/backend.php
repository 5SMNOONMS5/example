<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'prefix'    => 'api/core',
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
        'prefix' => 'admins',
//        'middleware' => [
//            'auth.assign.guard:admins',
//            'auth.jwt.verify',
//        ],
    ], function () {

        /*
        |--------------------------------------------------------------------------
        | 後台使用者
        |--------------------------------------------------------------------------
        */
        Route::group([
            'namespace' => 'Admin',
        ], function () {
            Route::get('', 'AdminController@index');
            Route::post('', 'AdminController@store');
            Route::get('{id}', 'AdminController@show')->where('id', '[0-9]+');
            Route::put('{id}', 'AdminController@update')->where('id', '[0-9]+');
            Route::delete('{id}', 'AdminController@destroy')->where('id', '[0-9]+');
        });

        /*
        |--------------------------------------------------------------------------
        | 權限
        |--------------------------------------------------------------------------
        */
        Route::group([
            'prefix'    => 'permissions',
            'namespace' => 'Permission',
        ], function () {
            Route::get('', 'PermissionController@index');
            Route::get('{id}', 'PermissionController@show')->where('id', '[0-9]+');
            Route::post('', 'PermissionController@store');
            Route::put('{id}', 'PermissionController@update')->where('id', '[0-9]+');
            Route::delete('{id}', 'PermissionController@destroy')->where('id', '[0-9]+');
        });

        /*
        |--------------------------------------------------------------------------
        | 權限群組(角色)
        |--------------------------------------------------------------------------
        */
        Route::group([
            'prefix'    => 'roles',
            'namespace' => 'Role',
        ], function () {
            Route::get('', 'RoleController@index');
            Route::get('{id}', 'RoleController@show')->where('id', '[0-9]+');
            Route::post('', 'RoleController@store');
            Route::put('{id}', 'RoleController@update')->where('id', '[0-9]+');
            Route::delete('{id}', 'RoleController@destroy')->where('id', '[0-9]+');
        });
    });
});
