<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Equipe extends Model
{
    public function categorie()
    {
        return $this->belongsTo('App\Categorie');
    }

    public function genre()
    {
        return $this->belongsTo('App\Genre');
    }

    public function niveau()
    {
        return $this->belongsTo('App\Niveau');
    }

}
