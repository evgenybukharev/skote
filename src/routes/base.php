<?php

/*
|--------------------------------------------------------------------------
| Backpack\Base Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are
| handled by the Backpack\Base package.
|
*/

$routes=function () {
    // Auth
    if (config('skote.base.setup_auth_routes')) {
        Route::get('login', 'LoginController@showLoginForm')->name('admin.login');
        Route::post('login', 'LoginController@login');
        Route::post('logout', 'LoginController@logout')->name('admin.logout');
    }
};

Route::group([
    'namespace'  => 'EvgenyBukharev\Skote\Http\Controllers',
    'middleware' =>  config('skote.base.web_middleware', 'web'),
    'prefix'     => config('skote.base.route_prefix'),
],$routes);
