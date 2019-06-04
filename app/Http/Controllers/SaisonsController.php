<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Saison;

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

}
