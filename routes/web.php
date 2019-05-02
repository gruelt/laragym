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
    return view('welcome-bs');
});





/*******  Verification Logins / Mail / complets */
Auth::routes(['verify' => true]);

Route::middleware('privileges:user')->middleware('verified')->middleware('complete')->get('/home', function () {
    return view('pages.bienvenue');
});


Route::middleware('verified')->get('/formcomplete',function()
{
    return view('forms.complete');
});
Route::middleware('verified')->post('/formcomplete','completeController@store');


/****      Fin verif logins ******///


//Admin
Route::group(['prefix' => 'admin', 'middleware' => 'privileges:admin'], function () {

    Route::get('/gymnastes', function () {
        return view('pages.admin.adherents');
    });

    Route::get('/passport', function () {
        return view('pages.admin.passport');
    });


});

///////////////////////////////////
///
///  Responsables
///
/// /////////////////////////////////////////////
Route::group(['prefix' => 'responsable', 'middleware' => ['verified','privileges:user']], function () {

    Route::get('/gymnastes', function () {
        return view('pages.responsables.adherents');
    });

    Route::get('/gymnastes/add', function () {
        return view('forms.gymnaste');
    });


    Route::post('/gymnastes/add', 'GymnastesController@store');

    //Montre le Gymnaste
    Route::get('/gymnastes/{id}', 'GymnastesController@show');

    //Montre le formulaire photo Gymnaste
    Route::get('/gymnastes/{id}/photo', 'GymnastesController@photoform');





});


Route::get('/logout', 'Auth\LoginController@logout');



Route::post('/gymnastes/{id}/photo', 'GymnastesController@uploadPhoto');
