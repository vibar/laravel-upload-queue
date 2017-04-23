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
    return redirect()->route('product.index');
});

Route::group(['prefix' => 'product'], function() {
    Route::get('/', 'ProductController@index')->name('product.index');
    Route::post('/', 'ProductController@store')->name('product.store');
    Route::get('create', 'ProductController@create')->name('product.create');
    Route::get('{id}/edit', 'ProductController@edit')->name('product.edit');
    Route::put('{id}', 'ProductController@update')->name('product.update');
    Route::delete('{id}', 'ProductController@destroy')->name('product.destroy');
});
