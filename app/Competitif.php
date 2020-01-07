<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Competitif extends Model
{

    //récupère les équipes du gymnaste
    public function gymnastes()
    {
        return $this->belongsToMany('App\Gymnaste')->withPivot('individuel')->orderBy('nom');
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
}
