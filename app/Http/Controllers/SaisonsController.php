<?php

namespace App\Http\Controllers;

use App\Gymnaste;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Saison;
use Illuminate\Support\Facades\Auth;

class SaisonsController extends Controller
{
    /**
     * Récupère toutes les saisons
     */
    public function allplucked()
    {
        return Saison::orderBy('id','desc')->pluck('nom','id');
    }

    /**
     * Récupère toutes les saisons
     */
    public function all()
    {
        return Saison::all();
    }

    /**
     * Retourne l'Id de la saison en cours
     * @return mixed
     */
    public function current()
    {
        $saison = new Saison;
        return $saison->actuelle()->id;
    }

    /*retourne l'id de la saison ouverte aux inscriptions
     *
     */
    public function opened()
    {
        $saison = new Saison;
        return $saison->inscriptionOuverte()->id;
    }

    public function payesaison($gymnaste_id,$saison_id,$montant)
    {
        $update['paye']=$montant;
        $update['responsable_paye_id']=1;
        $update['date_paiement']=Carbon::now();

        $gym =  Gymnaste::find($gymnaste_id)->saisons()->updateExistingPivot($saison_id,$update);




        //$gym->save();

        //return Auth::user();

        return $gym;
    }

}
