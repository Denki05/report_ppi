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

    // product
    Route::group(['as' => 'products.', 'prefix' => '/products'], function () {
        Route::get('/json', 'ProductController@json')->name('json');
        Route::post('/product_summary', 'ProductController@product_summary')->name('product_summary');
    });
    Route::resource('products', 'ProductController');

    // salesman
    Route::group(['as' => 'salesman.', 'prefix' => '/salesman'], function () {
        // Route::post('/print_report_principal', 'PrincipalController@print_report_principal')->name('print_report_principal');
    });
    Route::resource('salesman', 'SalesmanController');

    // customer
    Route::group(['as' => 'customer.', 'prefix' => '/customer'], function () {
        Route::post('/print_customer_report', 'CustomerController@print_customer_report')->name('print_customer_report');
    });
    Route::resource('customer', 'CustomerController');

    // principal
    Route::group(['as' => 'principal.', 'prefix' => '/principal'], function () {
        Route::post('/print_report_principal', 'PrincipalController@print_report_principal')->name('print_report_principal');
    });
    Route::resource('principal', 'PrincipalController');

    // Data Transform
    Route::group(['as' => 'data_transform.', 'prefix' => '/data_transform'], function () {
        // Route::post('/print_report_principal', 'PrincipalController@print_report_principal')->name('print_report_principal');
    });
    Route::resource('data_transform', 'DataTransformController');
});