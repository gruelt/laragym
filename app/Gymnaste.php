<?php

namespace App;

use App\Imports\certifsImport;
use Illuminate\Database\Eloquent\Model;

class Gymnaste extends Model
{
    //récupère les équipes du gymnaste pour la saison actuelle
    public function equipes()
    {
        $saison= new Saison;
        $saison_id = $saison->actuelle()->id;

        return $this->equipesall()->where('saison_id',$saison_id);
    }

    //Récupère toutes les équipes d'un gymnaste
    public function equipesall()
    {
        return $this->belongsToMany('App\Equipe')->withPivot('attente');
    }

    //récupère le "propriétaire" du gym
    public function responsable()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    //récupère le genre du gym
    public function genre()
    {
        return $this->belongsTo(Genre::class,'genre_id','id');
    }

    //TODO: Ajouter les pivots
    //récupère les saisons du gym
    public function saisons()
    {
        return $this->belongsToMany(Saison::class)->withPivot(['prix','paye','complet','responsable_paye_id','date_paiement','dossier','affiligue']);
    }

    public function tarif()
    {
        $s = new Saison;
        $saison = $s->inscriptionOuverte();

        $tarif = $this->equipes()->where('saison_id',$saison->id)->wherePivot('attente',0)->sum('tarif');

        return $tarif;

    }

    public function paye()
    {
        $s = new Saison;
        $saison = $s->inscriptionOuverte();

        $tarif = $this->saisons()->find($saison->id);

        if ($tarif == null )
        {
            return 0;
        }

        return $tarif->pivot->paye;
    }

    //pour un gymnaste , on retoruve combien doit être paye par le responsable pour tous ces gymnastes
    public function totalapayer()
    {
        $mesgyms = $this->responsable()->first()->gymnastes()->get();

        $total=0;

        foreach ($mesgyms as $gym)
        {
            $total += $gym->paye();

        }

        return $total;

    }

    //récupère les horaires du gymnaste
    public function horaires()
    {
        //TODO recup liste horaires
    }

    //MOulinette piochant dans le storage/imports et qui tente de mettre les dates au bon endroit
    public function moulinettecertif()
    {
        Excel::import(new certifsImport,'imports/certificatsmedic.csv');
    }

    /**
     * Renvoie si le gymnaste est compétitif
     * retourne le nombre d'équipes compétitives ou il est(>=1 ) ou pas (0)
     */
    public function competitif()
    {
        $equipes = $this->equipes()->whereNotIn('categorie_id',[10,11])->count();

        return $equipes;
    }

    /**
     * désinscrit le gymnaste pour la saison actuelle
     */
    public function annuleSaison()
    {

        //récupère les saison
        $saison= new Saison;
        $saison_id = $saison->actuelle()->id;

        $this->equipes()->detach();
        $this->saisons()->detach($saison_id);

    }

    /**
     * désinscrit le gymnaste pour la saison actuelle
     */
    public function remove()
    {

        $this->annuleSaison();

        $this->delete();

    }


}
