<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@index')->name('home');

Route::group(['prefix' => 'guestbook'], function () {
    Route::get('/', 'HomeController@guestbook')
        ->name('guestbook.index');

    Route::post('/', 'HomeController@addPost')
        ->name('guestbook.post');
});

Route::group(['prefix' => 'admin'], function () {
    Route::get('/', 'AdminController@index')
        ->name('admin.index');

    Route::get('getbadges', 'AdminController@getBadges')
        ->name('admin.getbadges');

    Route::get('published', 'AdminController@publishedPage')
        ->name('admin.posts.published');

    Route::get('unpublished', 'AdminController@unpublishedPage')
        ->name('admin.posts.unpublished');

    Route::get('hidden', 'AdminController@hiddenPage')
        ->name('admin.posts.hidden');

    Route::get('remove/{id}', 'AdminController@removePost')
        ->name('admin.remove')
        ->where('id', '[0-9]+');

    Route::get('hide/{id}', 'AdminController@hidePost')
        ->name('admin.hide')
        ->where('id', '[0-9]+');

    Route::get('publish/{id}', 'AdminController@publishPost')
        ->name('admin.publish')
        ->where('id', '[0-9]+');
});

Route::get('login', [
    'as' => 'login',
    'uses' => 'Auth\LoginController@showLoginForm'
]);

Route::post('login', [
    'as' => '',
    'uses' => 'Auth\LoginController@login'
]);

Route::post('logout', [
    'as' => 'logout',
    'uses' => 'Auth\LoginController@logout'
]);

Route::get('register', [
    'as' => 'register',
    'uses' => 'Auth\RegisterController@showRegistrationForm'
]);

Route::post('register', [
    'as' => '',
    'uses' => 'Auth\RegisterController@register'
]);

//
//Route::post('password/email', [
//    'as' => 'password.email',
//    'uses' => 'Auth\ForgotPasswordController@sendResetLinkEmail'
//]);
//Route::get('password/reset', [
//    'as' => 'password.request',
//    'uses' => 'Auth\ForgotPasswordController@showLinkRequestForm'
//]);
//Route::post('password/reset', [
//    'as' => '',
//    'uses' => 'Auth\ResetPasswordController@reset'
//]);
//Route::get('password/reset/{token}', [
//    'as' => 'password.reset',
//    'uses' => 'Auth\ResetPasswordController@showResetForm'
//]);
//
