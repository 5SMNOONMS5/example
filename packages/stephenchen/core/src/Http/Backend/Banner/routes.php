<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'api/banner', 'namespace' => 'App\Http\Backend\Banner'], function () {

    // JWT Token middleware
    Route::group(['middleware' => 'auth.jwt.verify'], function () {
        Route::group(['prefix' => 'banners', 'namespace' => 'Banner'], function () {
            Route::get('', 'BannerController@index');
            Route::get('{id}', 'BannerController@show')->where('id', '[0-9]+');
            Route::post('', 'BannerController@store');
            Route::put('{id}', 'BannerController@update')->where('id', '[0-9]+');
            Route::delete('{id}', 'BannerController@destroy')->where('id', '[0-9]+');
        });
        // Add more here.......
    });
});
