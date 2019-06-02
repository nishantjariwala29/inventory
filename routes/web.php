
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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::GET('/products', 'ProductsController@index')->name('products');
Route::GET('/products/create', 'ProductsController@create');
Route::POST('/products', 'ProductsController@store');
Route::GET('/products/{id}/edit', 'ProductsController@edit');
Route::DELETE('/products/delete/{id}', 'ProductsController@destroy');
Route::POST('/products/update/{id}', 'ProductsController@update');
