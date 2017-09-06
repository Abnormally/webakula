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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'guestbook'], function () {
    Route::get('{id}', 'ApiController@guestbookOne')
        ->name('api.posts.id')
        ->where('id', '[0-9]+');

    Route::get('all', 'ApiController@guestbookAll')->name('api.posts.all');
    Route::get('actual', 'ApiController@guestbookNonDeleted')->name('api.posts.actual');
    Route::get('deleted', 'ApiController@guestbookDeleted')->name('api.posts.deleted');
});