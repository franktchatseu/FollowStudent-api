<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');

    Route::get('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');

});


Route::group(['prefix' => 'roles'], function () {
    Route::get('/getRolesWithPermissions', 'RoleController@getRolesWithPermissions');
    Route::get('/', 'RoleController@get');
    Route::post('/', 'RoleController@store');
    Route::post('/{id}', 'RoleController@update');
    Route::delete('/{id}', 'RoleController@delete');
    Route::get('/{id}', 'RoleController@find');
});
