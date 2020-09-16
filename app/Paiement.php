<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Psr\Log\NullLogger;

class Paiement extends Model
{
    public function operateur()
    {
        return $this->belongsTo(User::class,'operateur_id');
    }


    public function responsable()
    {
        return $this->belongsTo(User::class);
    }

    public function store($values)
    {
        $p = new Paiement;

        if(!isset($values->commentaire))
        {
            $values->commentaire='';
        }

        $p->type=$values->type;
        $p->montant=$values->montant;
        $p->commentaire=$values->commentaire;
        $p->responsable_id=$values->responsable_id;
        $p->saison_id=$values->saison_id;
        $p->operateur_id=$values->operateur_id;

        $p->save();

    }
}
