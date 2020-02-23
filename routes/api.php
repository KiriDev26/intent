<?php

use Illuminate\Http\Request;

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
Route::get('main', 'Api\MainController@index' );

Route::post('login', 'PassportController@login');
Route::post('register', 'PassportController@register');

Route::middleware('auth:api')->group(function () {
    Route::get('user', 'PassportController@details');
    Route::get('users', 'Api\UserController@users');

    Route::post('user/update', 'Api\UserController@update');

    Route::resource('like', 'Api\LikeController')->except(['show', 'edit', 'index', 'create']);
    Route::resource('friend', 'Api\FriendController')->except(['show', 'edit', 'destroy', 'create']);
    Route::resource('post', 'Api\PostController')->except(['edit', 'create']);
    Route::resource('comment', 'Api\CommentController')->except(['edit', 'index', 'create']);
    Route::resource('image-to-post', 'Api\ImageToPostController')->except(['show', 'edit', 'index', 'create']);;
});
