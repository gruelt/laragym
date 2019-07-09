<?php

namespace App\Http\Controllers;

use App\Privileges;
use App\Saison;
use App\User;
use Illuminate\Http\Request;

use phpDocumentor\Reflection\Types\Array_;

class UsersController extends Controller
{

    /**
     * Retourne les users avec le profil coach
     * @return array
     */
    public function getcoachspluck()
    {
        $return=array();


        $coachs = Privileges::find(5)->users()->get()->pluck('prenom','id');







        return $coachs;

        //return $gymnastes;
    }

    /**
     * Récupère la liste des responsables par saison
     * @param $saison_id
     * @return mixed
     */
    public function getbyseason($saison_id)
    {
        $return=array();

        if($saison_id == 9999)
        {
            return User::all();
        }

        $gymnastes = Saison::find($saison_id)->gymnastes;

        $done=array();

        foreach($gymnastes as $key => $gymnaste)
        {
            $responsable = $gymnaste->responsable()->first();

            if(!isset($done[$responsable->id]))
            {
                $return[] = $gymnaste->responsable()->first();
                $done[$responsable->id]=1;
            }

        }

        return $return;
    }


}
