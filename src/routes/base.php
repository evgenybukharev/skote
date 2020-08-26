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

Route::group(
[
    'namespace'  => 'EvgenyBukharev\Skote\Crud\Controllers',
    'middleware' => 'web',
    'prefix'     => 'admin',
],
function () {

});
