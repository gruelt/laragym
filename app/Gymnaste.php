<?php

namespace App;

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

        $tarif = $this->equipes()->where('saison_id',$saison->id)->wherePivot('attente',0)->max('tarif');

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

}
