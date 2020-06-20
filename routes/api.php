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

    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');

});


Route::group(['middleware' => 'api','prefix' => 'roles'], function () {
    Route::get('/getRolesWithPermissions', 'RoleController@getRolesWithPermissions')->middleware('has-permission:read-roles');
    Route::get('/', 'RoleController@get');
    Route::post('/', 'RoleController@store')->middleware('has-permission:create-roles');
    Route::post('/{id}', 'RoleController@update')->middleware('has-permission:update-roles');
    Route::delete('/{id}', 'RoleController@delete')->middleware('has-permission:delete-roles');
    Route::get('/{id}', 'RoleController@find')->middleware('has-permission:read-roles');
    Route::get('/getRolesWithPermissions', 'RoleController@getRolesWithPermissions')->middleware('has-permission:read-roles');
});
