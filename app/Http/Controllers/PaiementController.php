<?php

namespace App\Http\Controllers;

use App\Paiement;
use Illuminate\Http\Request;
use App\User;
class PaiementController extends Controller
{
    //
    public function paiementadd($responsable_id, Request $request)
    {
        $p = new Paiement;
        $p->store($request);

        return $request;
    }

    public function paiementgetbysaison($responsable_id,$saison_id)
    {
        return User::find($responsable_id)->paiements()->where('saison_id',$saison_id)->get();
    }

}
