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
        return $this->belongsToMany('App\Equipe');
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
        return $this->belongsToMany(Saison::class)->withPivot(['prix','paye','complet']);
    }

    public function tarif()
    {
        $tarif = $this->equipes()->max('tarif');

        return $tarif;
    }

}
