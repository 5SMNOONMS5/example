<?php

use Illuminate\Support\Facades\Route;

Route::group([
    // @TODO:
//    'prefix'    => 'api/core',
    'namespace' => 'Stephenchen\Core\Http\Backend',
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
        | 上傳檔案
        |--------------------------------------------------------------------------
        */
        Route::group([
            'namespace' => 'File',
        ], function () {
            Route::post('files/upload', 'FileController@upload');
        });
    });
});
