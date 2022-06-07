<?php

use Illuminate\Support\Facades\Auth;
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
Auth::routes([
    'reset' => true,
    'confirm' => true,
    'verify' => true,
]);


Route::get('/', 'HomeController@index')->name('home');


Route::middleware(["auth"])->group(function(){
    Route::group([

        "namespace" => "Person",
        "prefix" => "person",
        "as" => "person.",
    ],function(){
        Route::get('/orders', 'OrderController@index')->name('orders.index');
        Route::get('/orders/{order}', 'OrderController@show')->name('orders.show');
        Route::post('/orders/{order}/cancel', 'OrderController@cancel')->name('orders.cancel');
        Route::get('/orders/{order}/word-export', 'OrderController@wordExport')->name('word');


    });


    Route::group([
        'namespace' => 'Admin',
        'prefix' => 'admin',
    ], function () {
        Route::group(['middleware' => 'is_admin'], function () {
            Route::get('/orders', 'OrderController@index')->name('orders');
            Route::get('/orders{order}', 'OrderController@show')->name('orders.show');
            Route::post('/orders{order}/cancel', 'OrderController@cancel')->name('orders.cancel');
            Route::get('/orders/export', 'OrderController@ordersAdminExport')->name('excel');
            Route::post('/orders/{order}/courier', 'OrderController@update')->name('orders.update');
            Route::post('/orders/{order}/courier/complete', 'OrderController@complete')->name('orders.complete');
            Route::get('/orders/word-export', 'OrderController@wordAdminExport')->name('admin-word');
        });
        Route::resource('categories', 'CategoryController');
        Route::post('/categories/{id}/restore', 'CategoryController@restore')->name('categories.restore');
        Route::resource('products', 'ProductController');
        Route::post('/products/{id}/restore', 'ProductController@restore')->name('products.restore');
        Route::resource('couriers', 'CourierController');


    });
});


Route::group([
    'prefix' => 'basket',
], function () {
    Route::post('/add{product}', 'BasketController@basketAdd')->name('basket-add');

    Route::group([
        'middleware' => 'basket_not_empty',
    ], function () {
        Route::get('/', 'BasketController@basket')->name('basket');
        Route::get('/place', 'BasketController@basketPlace')->name('basket-place');
        Route::post('/remove{product}', 'BasketController@basketRemove')->name('basket-remove');
        Route::post('/place', 'BasketController@basketConfirm')->name('basket-confirm');
    });
});







