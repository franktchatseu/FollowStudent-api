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
    Route::get('/', 'UserController@index');
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
Route::group(['prefix' => 'projets'], function () {
    Route::get('/', 'ProjetController@index');
    Route::get('/search', 'ProjetController@search');
    Route::post('/', 'ProjetController@store');
    Route::post('/{id}', 'ProjetController@update');
    Route::delete('/{id}', 'ProjetController@destroy');
    Route::get('/{id}', 'ProjetController@find');
});

Route::group(['prefix' => 'presences'], function () {
    Route::get('/', 'PresenceController@index');
    Route::get('/search', 'PresenceController@search');
    Route::post('/', 'PresenceController@store');
    Route::post('/{id}', 'PresenceController@update');
    Route::delete('/{id}', 'PresenceController@destroy');
    Route::get('/{id}', 'PresenceController@find');
});

Route::group(['prefix' => 'taches'], function () {
    Route::get('/', 'TacheController@index');
    Route::get('/search', 'TacheController@search');
    Route::post('/', 'TacheController@store');
    Route::post('/{id}', 'TacheController@update');
    Route::delete('/{id}', 'TacheController@destroy');
    Route::get('/{id}', 'TacheController@find');
});

Route::group(['prefix' => 'documentations'], function () {
    Route::get('/', 'DocumentationController@index');
    Route::get('/search', 'DocumentationController@search');
    Route::post('/', 'DocumentationController@store');
    Route::post('/{id}', 'DocumentationController@update');
    Route::delete('/{id}', 'DocumentationController@destroy');
    Route::get('/{id}', 'DocumentationController@find');
});

