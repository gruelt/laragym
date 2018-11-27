<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Filiere extends Model
{
    public function categories()
    {
        return $this->hasMany('App\Categorie');
    }
}
