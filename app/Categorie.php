<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    public function filiere()
    {
        return $this->belongsTo('App\Filiere');
    }

    public function equipes()
    {
        return $this->hasMany('App\Equipe');
    }
}
