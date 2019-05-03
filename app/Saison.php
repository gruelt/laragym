<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Saison extends Model
{
    /**
     * récupère les gymnastes de la saison
     */

    public function gymnastes(){
        $this->belongsToMany(Gymnaste::class);
    }
}
