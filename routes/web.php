<?php

use Illuminate\Support\Facades\Route;

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

Route::group(['namespace' => 'App\Http\Controllers'], function()
{   
    /**
     * Home Routes
     */
    // Route::get('/', 'HomeController@index')->name('home.index');
    Route::get('/', 'LoginController@show')->name('login.show');
    

    Route::group(['middleware' => ['guest']], function() {
        /**
         * Register Routes
         */
        Route::get('/register', 'RegisterController@show')->name('register.show');
        Route::post('/register', 'RegisterController@register')->name('register.perform');

        /**
         * Login Routes
         */
        Route::get('/login', 'LoginController@show')->name('login.show');
        Route::post('/login', 'LoginController@login')->name('login.perform');

    });

    Route::group(['middleware' => ['auth', 'permission']], function() {
        /**
         * Logout Routes
         */
        Route::get('/logout', 'LogoutController@perform')->name('logout.perform');

        /**
         * User Routes
         */
        Route::group(['prefix' => 'users'], function() {
            Route::get('/', 'UsersController@index')->name('users.index');
            Route::get('/create', 'UsersController@create')->name('users.create');
            Route::post('/create', 'UsersController@store')->name('users.store');
            Route::get('/{user}/show', 'UsersController@show')->name('users.show');
            Route::get('/{user}/edit', 'UsersController@edit')->name('users.edit');
            Route::patch('/{user}/update', 'UsersController@update')->name('users.update');
            Route::delete('/{user}/delete', 'UsersController@destroy')->name('users.destroy');
        });

        /**
         * User Routes
         */
        Route::group(['prefix' => 'posts'], function() {
            Route::get('/', 'PostsController@index')->name('posts.index');
            Route::get('/create', 'PostsController@create')->name('posts.create');
            Route::post('/create', 'PostsController@store')->name('posts.store');
            Route::get('/{post}/show', 'PostsController@show')->name('posts.show');
            Route::get('/{post}/edit', 'PostsController@edit')->name('posts.edit');
            Route::patch('/{post}/update', 'PostsController@update')->name('posts.update');
            Route::delete('/{post}/delete', 'PostsController@destroy')->name('posts.destroy');
        });

        Route::group(['prefix' => 'so'], function() {
            Route::get('/', 'SalesOrderController@index')->name('so.index');
        });

        Route::group(['prefix' => 'report'], function() {
            Route::get('/', 'ReportController@index')->name('report.index');
        });

        Route::group(['prefix' => 'report_customer_type'], function() {
            Route::get('/', 'ReportCustomerTypeController@index')->name('report_customer_type.index');
            Route::post('/store', 'ReportCustomerTypeController@store')->name('report_customer_type.store');
            Route::delete('/delete', 'ReportCustomerTypeController@destroy')->name('report_customer_type.destroy');
            Route::get('/reportCustomerType', 'ReportCustomerTypeController@reportCustomerType')->name('report_customer_type.reportCustomerType');
            Route::get('/reportBySupplier', 'ReportCustomerTypeController@reportBySupplier')->name('report_customer_type.reportBySupplier');
            Route::get('/reportByBrand', 'ReportCustomerTypeController@reportByBrand')->name('report_customer_type.reportByBrand');
            Route::get('/reportByPackaging', 'ReportCustomerTypeController@reportByPackaging')->name('report_customer_type.reportByPackaging');
        });

        Route::resource('roles', RolesController::class);
        Route::resource('permissions', PermissionsController::class);
    });
});
