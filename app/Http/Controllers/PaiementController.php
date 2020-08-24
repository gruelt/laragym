<?php

namespace App\Http\Controllers;

use App\Paiement;
use App\Saison;
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
        if($saison_id=='actuelle')
        {
            $s=new Saison();
            $saison_id= $s->actuelle()->id;
        }

        return User::find($responsable_id)->paiements()->where('saison_id',$saison_id)->with('operateur')->get();
    }

    public function paiementdelete($id_responsable,$id_paiement)
    {
        return Paiement::find($id_paiement)->delete();
    }

}
