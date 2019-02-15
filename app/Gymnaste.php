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
}
