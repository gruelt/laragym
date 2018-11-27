<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    public function equipes()
    {
        return $this->hasMany('App\Equipe');
    }
}
