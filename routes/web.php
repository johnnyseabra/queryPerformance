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

Route::get('/', function () {
    return redirect('/listPosts');
});


Route::get('/listPosts', 'App\Http\Controllers\PostsController@create')->name('listPosts');
Route::post('/listPosts', 'App\Http\Controllers\PostsController@filter')->name('filterPosts');