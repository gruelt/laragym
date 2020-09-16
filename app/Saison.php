<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Saison extends Model
{
    /**
     * récupère les gymnastes de la saison
     */

    public function gymnastes(){
        return $this->belongsToMany('App\Gymnaste'); //
    }

    public function equipes(){
        return $this->hasMany('App\Equipe')->orderBy('nom'); //
    }

    public function competitifs(){
        return $this->hasMany('App\Competitif'); //
    }

    public function actuelle(){
        return $this->where('actuelle',1)->first();
    }

    public function inscriptionOuverte(){
        return $this->where('inscription',1)->first();
    }
}
