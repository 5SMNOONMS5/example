<?php

use Illuminate\Support\Facades\Route;

Route::group([
    // @TODO:
//    'prefix'    => 'api/core',
    'namespace' => 'Stephenchen\Banner\Http\Backend',
    'middleware' => [
        'set.language',
    ],
], function () {

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
        | Banners
        |--------------------------------------------------------------------------
        */
        Route::group([
            'prefix'    => 'admins',
            'namespace' => 'Banner',
        ], function () {
            Route::resource('banners', 'BannerController');
        });
    });
});
