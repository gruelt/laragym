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

Route::middleware('privileges:user')->get('/home', function () {
    return view('pages.bienvenue');
});

Route::get('/bienvenue', function () {
    return view('pages.bienvenue')->name('bienvenue');
});


Route::group(['prefix' => 'admin', 'middleware' => 'privileges:admin'], function () {

    Route::get('/gymnastes', function () {
        return view('pages.admin.adherents');
    });

});
