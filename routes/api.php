<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/user', function (Request $request) {
    return $request->user();
});



Route::group(['prefix' => 'admin'], function () {



    //Gets all users
    Route::get('/gymnastes', 'GymnastesController@getall');

    Route::get('/gymnastes/saison/{id}', 'GymnastesController@getbyseason');


    Route::get('/gymnastes/{id}/certificatmedical/valid', 'GymnastesController@validcertif');




    Route::get('/equipes', 'EquipesController@getall');




});





Route::group(['prefix' => 'responsables', 'middleware' => 'auth:api'], function () {



    //Gets all users
    Route::get('/gymnastes', 'GymnastesController@getMy');

    //Gets one user
    Route::get('/gymnastes', 'GymnastesController@getMy');


});


//Commun //////////////////////////////////

Route::get('/saisons','SaisonsController@allplucked');

Route::get('/saisons/actuelle','SaisonsController@current');
Route::get('/saisons/ouverte','SaisonsController@opened');