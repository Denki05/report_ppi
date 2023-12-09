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

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles','RoleController');
    Route::resource('users','UserController');

    Route::group(['as' => 'products.', 'prefix' => '/products'], function () {
        Route::get('/json', 'ProductController@json')->name('json');
        Route::post('/product_summary', 'ProductController@product_summary')->name('product_summary');
    });
    Route::resource('products', 'ProductController');
});