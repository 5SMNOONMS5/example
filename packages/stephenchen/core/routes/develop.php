<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

// NOT allow in
//              `production`
// only in
//              `local`, `testing`, `staging`
if (!App::environment('production')) {

    Route::group([
        'prefix'    => 'api/core',
        'namespace' => 'Stephenchen\Core\Http',
    ], function () {

        /*
        |--------------------------------------------------------------------------
        | Admin Auth
        |--------------------------------------------------------------------------
        */

        Route::group([
            'prefix'    => 'develop',
        ], function () {
            Route::get('success', 'PingController@success');
            Route::post('success', 'PingController@success');
            Route::put('success', 'PingController@success');
            Route::delete('success', 'PingController@success');
            Route::get('error', 'PingController@error');
        });
    });
}
