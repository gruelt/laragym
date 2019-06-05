<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Equipe extends Model
{
    //récupère les équipes du gymnaste
    public function gymnastes()
    {
        return $this->belongsToMany('App\Gymnaste');
    }


    public function categorie()
    {
        return $this->belongsTo('App\Categorie');
    }

    public function genre()
    {
        return $this->belongsTo('App\Genre');
    }

    public function saison()
    {
        return $this->belongsTo('App\Saison');
    }

    public function niveau()
    {
        return $this->belongsTo('App\Niveau');
    }

    public function coach()
    {
        return $this->belongsToMany('App\User','coach_equipe');
    }

}
