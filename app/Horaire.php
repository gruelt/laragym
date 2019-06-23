<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Horaire extends Model
{
    public function jour()
    {
        return $this->belongsTo('App\Jour');
    }
}
