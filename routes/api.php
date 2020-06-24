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


Route::group(['prefix' => 'users'], function () {
    Route::get('/', 'UserController@get');
    Route::post('/', 'UserController@store');
    Route::post('/{id}', 'UserController@update');
    Route::delete('/{id}', 'UserController@delete');
    Route::get('/{id}', 'UserController@find');
});

//les blogs de categorie
Route::group(['prefix' => 'blog_categories'], function () {
    Route::get('/', 'BlogCategorieController@index');
    Route::post('/', 'BlogCategorieController@store');
    Route::post('/{id}', 'BlogCategorieController@update');
    Route::delete('/{id}', 'BlogCategorieController@destroy');
    Route::get('/{id}', 'BlogCategorieController@find');
});
//les blogs 
Route::group(['prefix' => 'blogs'], function () {
    Route::get('/', 'BlogController@index');
    Route::post('/', 'BlogController@store');
    Route::post('/{id}', 'BlogController@update');
    Route::delete('/{id}', 'BlogController@destroy');
    Route::get('/{id}', 'BlogController@find');
    Route::post('/{id}/comment', 'BlogCommentController@store');
    
});
//les commantaires
Route::group(['prefix' => 'blog_comments'], function () {

    Route::post('/{id}', 'BlogCommentController@update');
    Route::delete('/{id}', 'BlogCommentController@destroy');
    Route::post('/{id}/response', 'CommentResponseController@store');
 
});
//les respobse au commentaire
Route::group(['prefix' => 'comment_response'], function () {

    Route::post('/{id}', 'CommentResponseController@update');
    Route::delete('/{id}', 'CommentResponseController@destroy');
 
});

