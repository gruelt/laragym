<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gymnaste extends Model
{
    //récupère les équipes du gymnaste
    public function equipes()
    {
        return $this->belongsToMany('App\Equipe');
    }

    //récupère le "propriétaire" du gym
    public function responsable()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    //récupère les saisons du gym
    public function saisons()
    {
        return $this->belongsToMany(Saison::class);
    }

}
