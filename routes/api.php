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

    //AJoute un paiement pour responsable/ saison
    Route::post('/responsable/{responsable_id}/paiement/add','PaiementController@paiementadd');



    Route::get('/responsable/{responsable_id}/paiement/saison/{saison_id}','PaiementController@paiementgetbysaison');

    //récupère les adhésions via helloasso
    Route::get('/helloasso/adhesion/current/{mail}','GymnastesController@getadhesion');

    //Add a user to a competitive group

    Route::post('/competitifs/{id_groupe}/gymnastes/{id_gym}/add','CompetitifsController@setgymtocompetitif');

    Route::delete('/competitifs/{id_groupe}/gymnastes/{id_gym}/detach','CompetitifsController@deletegymtocompetitif');



    //Gets all users
    Route::get('/gymnastes', 'GymnastesController@getall');

    //Gets all gymnastes eligibles to a competitive group
    Route::get('/competitifs/{equipe_id}/gymnastes/eligibles', 'CompetitifsController@getgymnasteseligible');

    Route::get('/gymnastes/{id}', 'GymnastesController@get');

    Route::get('/gymnastes/saison/{id}', 'GymnastesController@getbyseason');

    Route::get('/responsables/saison/{id}', 'UsersController@getbyseason');

    Route::get('/gymnastes/saison/{id}/quick', 'GymnastesController@getbyseasonquick');


    Route::get('/gymnastes/{id}/certificatmedical/valid', 'GymnastesController@validcertif');

    //Récupère toutes les équipes possibles + celles ou il est inscrit
    Route::get('/gymnastes/{gym_id}/saison/{saison_id}/equipes', 'GymnastesController@getgymequipesbyseason');

    Route::post('/gymnastes/{gym_id}/saison/{saison_id}/equipes', 'GymnastesController@setgymequipesbyseason');




    Route::get('/equipes', 'EquipesController@getall');

    Route::get('/equipes/saison/{id}', 'EquipesController@getbyseason');

    Route::get('/competitifs/saison/{id}', 'CompetitifsController@getbyseason');

    Route::get('/equipes/saison/{id}/{pluck}', 'EquipesController@getbyseason');

    Route::get('/equipes/{id}', 'EquipesController@get');

    Route::get('/competitifs/{id}', 'CompetitifsController@get');

    Route::get('/equipes/{id}/members', 'EquipesController@getmembers');

    Route::get('competitifs/{id}/members', 'CompetitifsController@getmembers');

    Route::get('/coachs/pluck','UsersController@getcoachspluck');

    Route::get('/equipes/{id}/coachs/ids','EquipesController@getcoachspluck');

    Route::post('/equipes/{id}/coachs/', 'EquipesController@setcoachtoteam');

    Route::post('/equipes/{id}/horaires/', 'EquipesController@setHoraire');


    //Update universelle pour tous es modeles (sans attach)

    Route::post('/model/{model}/{id}/{field}','UpdateController@univupdate');

    //Update pour la bascule liste d'attente/deginitive

    Route::get('/gymnastes/{gym_id}/equipes/{equipe_id}/attente/{attente}','GymnastesController@updateequipeattente');

    //Valide ou non le dossier pour la saison actuelle
    Route::get('/gymnastes/{id}/dossier/{statut}','GymnastesController@updatedossier');

    //Valide ou non le dossier pour la saison actuelle
    Route::get('/gymnastes/{id}/affiligue/{statut}','GymnastesController@updateaffiligue');

    Route::get('/responsables/{id}', 'UsersController@get');

    Route::get('/responsables/{id}/members', 'UsersController@getmembers');


});

    Route::group(['prefix' => 'inscription'], function () {

    Route::get('/gymnastes/{gym_id}/saison/{saison_id}/paiement/valid/{montant}','SaisonsController@payesaison');










});





Route::group(['prefix' => 'responsables', 'middleware' => 'auth:api'], function () {



    //Gets all usersge
    Route::get('/gymnastes', 'GymnastesController@getMy');

    //Gets one user
    Route::get('/gymnastes', 'GymnastesController@getMy');


});


//Commun //////////////////////////////////

Route::get('/saisons','SaisonsController@allplucked');

Route::get('/saisons/actuelle','SaisonsController@current');
Route::get('/saisons/ouverte','SaisonsController@opened');

