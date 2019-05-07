<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Saison extends Model
{
    /**
     * récupère les gymnastes de la saison
     */

    public function gymnastes(){
        return $this->belongsToMany(Gymnaste::class); //
    }

    public function actuelle(){
        return $this->where('actuelle',1)->first();
    }
}
