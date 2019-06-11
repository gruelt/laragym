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

    Route::get('/gymnastes/{id}', 'GymnastesController@get');

    Route::get('/gymnastes/saison/{id}', 'GymnastesController@getbyseason');


    Route::get('/gymnastes/{id}/certificatmedical/valid', 'GymnastesController@validcertif');

    //Récupère toutes les équipes possibles + celles ou il est inscrit
    Route::get('/gymnastes/{gym_id}/saison/{saison_id}/equipes', 'GymnastesController@getgymequipesbyseason');

    Route::post('/gymnastes/{gym_id}/saison/{saison_id}/equipes', 'GymnastesController@setgymequipesbyseason');




    Route::get('/equipes', 'EquipesController@getall');

    Route::get('/equipes/saison/{id}', 'EquipesController@getbyseason');

    Route::get('/equipes/saison/{id}/{pluck}', 'EquipesController@getbyseason');





});

Route::group(['prefix' => 'inscription'], function () {

    Route::get('/gymnastes/{gym_id}/saison/{saison_id}/paiement/valid/{montant}','SaisonsController@payesaison');








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