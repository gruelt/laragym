<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    public function equipes()
    {
        return $this->hasMany('App\Equipe');
    }

    public function color()
    {
        if($this->id ==1)
        {
            return "primary";
        }
        if($this->id == 2)
        {
            return "danger";
        }

        return "secondary";

    }


}
