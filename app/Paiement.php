<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    public function responsable()
    {
        return $this->belongsTo(User::class);
    }

    public function store($values)
    {
        $p = new Paiement;

        $p->type=$values->type;
        $p->montant=$values->montant;
        $p->commentaire=$values->commentaire;
        $p->responsable_id=$values->responsable_id;
        $p->saison_id=$values->saison_id;
        $p->operateur_id=$values->operateur_id;

        $p->save();

    }
}
