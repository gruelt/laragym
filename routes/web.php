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

/*ANciennes routes*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);

Route::middleware('privileges:user')->middleware('verified')->get('/home', function () {
    return view('pages.bienvenue');
});

Route::get('/bienvenue', function () {
    return view('pages.bienvenue')->name('bienvenue');
});

//Admin
Route::group(['prefix' => 'admin', 'middleware' => 'privileges:admin'], function () {

    Route::get('/gymnastes', function () {
        return view('pages.admin.adherents');
    });

});

//Responsables
Route::group(['prefix' => 'responsable', 'middleware' => 'verified'], function () {

    Route::get('/gymnastes', function () {
        return view('pages.admin.adherents');
    });

});




//test
Route::get('/test', function () {
    return view('pages.test');
});
