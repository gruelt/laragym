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
})->middleware('noie');





/*******  Verification Logins / Mail / complets */
Auth::routes(['verify' => true]);

//Route::middleware('privileges:user')->middleware('verified')->middleware('complete')->get('/home', function () {
//    return view('pages.bienvenue');
//});

Route::group([ 'middleware' => ['verified','complete','privileges:user']], function () {
    Route::get('/home', function () {
        return view('pages.bienvenue');
    });
});


Route::middleware('verified')->get('/formcomplete',function()
{
    return view('forms.complete')->with('new',1);
});
Route::middleware('verified')->post('/formcomplete','completeController@store');


/****      Fin verif logins ******///




///////////////////////////////////
///
//  ______                                          _     _
// (_____ \                                        | |   | |
//  _____) )_____  ___ ____   ___  ____   ___ _____| |__ | | _____
// |  __  /| ___ |/___)  _ \ / _ \|  _ \ /___)____ |  _ \| || ___ |
// | |  \ \| ____|___ | |_| | |_| | | | |___ / ___ | |_) ) || ____|
// |_|   |_|_____)___/|  __/ \___/|_| |_(___/\_____|____/ \_)_____)
//                    |_|                                          ///
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
    //Route::get('/gymnastes/{id}/photo', 'GymnastesController@photoform');

    //Inscrit le gym à une saison
    Route::get('/gymnaste/{gymnasteid}/reinscrire/{saisonid}','GymnastesController@inscrire');

    //
    Route::get("/gymnastes/{gymnasteid}/facture",'GymnastesController@PDFFacture');



});


//  _______     _       _
// (_______)   | |     (_)
//  _______  __| |____  _ ____
// |  ___  |/ _  |    \| |  _ \
// | |   | ( (_| | | | | | | | |
// |_|   |_|\____|_|_|_|_|_| |_|
//

//Admin
Route::group(['prefix' => 'admin', 'middleware' => 'privileges:admin'], function () {

    Route::get('/gymnastes', function () {
        return view('pages.admin.adherents');
    });

    Route::get('/gymnastes/quick', function () {
        return view('pages.admin.adherents')->withQuick(1);
    });

    Route::get('/passport', function () {
        return view('pages.admin.passport');
    });

    Route::get('/equipes', function () {
        return view('pages.admin.equipes');
    });

    //Montre le Gymnaste
    Route::get('/gymnastes/{id}', 'GymnastesController@showadmin');

    //Montre l'equipe
    Route::get('/equipes/{id}', 'EquipesController@showequipe');

    //Ajout d'un horaire
    Route::get('/equipes/{id}/horaires/add', 'EquipesController@addhoraire');

    //suppr d'un horaire
    Route::get('/horaires/{id}/delete', 'EquipesController@deletehoraire');

    //Montre les responsables
    Route::get('/responsables/', function () {
        return view('pages.admin.responsables');
    });

    //ajoute un responsable par admin
    Route::get('/responsables/add', function () {
        return view('forms.complete');
    });

    //Montre le responsable et ses infos/gyms
    Route::get('/responsables/{id}', 'UsersController@showresponsable')->where('id', '[0-9]+');



    Route::get('/responsables/{user_id}/gymnastes/add', 'UsersController@addgymform');




    //test photo
    Route::get('/photo/test', 'PhotoController@formtest');

    Route::get('/gymnastes/export/{saison_id}', 'GymnastesController@export');

    Route::get("/gymnastes/{gymnasteid}/facture/{admin}",'GymnastesController@PDFFacture');

});


//  _                        _            _
// | |                      (_)       _  (_)
// | |____   ___  ____  ____ _ ____ _| |_ _  ___  ____   ___
// | |  _ \ /___)/ ___)/ ___) |  _ (_   _) |/ _ \|  _ \ /___)
// | | | | |___ ( (___| |   | | |_| || |_| | |_| | | | |___ |
// |_|_| |_(___/ \____)_|   |_|  __/  \__)_|\___/|_| |_(___/
//                            |_|
Route::group(['prefix' => 'inscription', 'middleware' => 'privileges:admin'], function () {

    Route::get('/gymnastes/{gym_id}/photo/take', 'PhotoController@takephoto');
    Route::get('/gymnastes/{gym_id}/photo/crop', 'PhotoController@cropphoto');



        Route::get('/gymnastes', function () {
            return view('pages.admin.adherents');
        });

        Route::get('/passport', function () {
            return view('pages.admin.passport');
        });

        Route::get('/equipes', function () {
            return view('pages.admin.equipes');
        });

        //Montre l'equipe
        Route::get('/equipes/{id}', 'EquipesController@showequipe');

        //Montre le Gymnaste
        Route::get('/gymnastes/{id}', 'GymnastesController@showadmin');








});




//  _______
// (_______)
//  _       ___  ____  ____  _   _ ____
// | |     / _ \|    \|    \| | | |  _ \
// | |_____ |_| | | | | | | | |_| | | | |
//  \______)___/|_|_|_|_|_|_|____/|_| |_|
//



Route::get('/logout', 'Auth\LoginController@logout');

Route::get('/about',  function () {
    return view('about');
});




Route::post('/gymnastes/{id}/photo', 'GymnastesController@uploadPhoto');
Route::post('/gymnastes/{id}/photo64', 'GymnastesController@uploadPhoto64');
Route::post('/gymnastes/{id}/photo64/{redirect}', 'GymnastesController@uploadPhoto64');
Route::post('/gymnastes/{id}/certif', 'GymnastesController@uploadCertif');

//Montre l'equipe
Route::get('/equipes/{id}', 'EquipesController@showequipe')->middleware(['privileges:admin']);

Route::get('/noie',  function () {
    return view('pages.noie');
});

//
Route::get("/equipes/{id}/appel",'EquipesController@PDFAppel');



