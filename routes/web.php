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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home')->middleware(['auth', 'verified']);

Route::namespace('Web')->prefix('shop')->name('shop.')->group(function () {
    Route::resource('/products', 'ProductController')
        ->only(['index', 'show'])
        ->middleware('auth')
        ->middleware('can:list-products');
});
Route::namespace('Admin')->prefix('admin')->name('admin.')->group(function () {
    Route::resource('/users', 'UserController')->middleware('auth')->middleware('can:list-users');
    Route::resource('/products', 'ProductController')->middleware('auth')->middleware('can:list-products');
});
